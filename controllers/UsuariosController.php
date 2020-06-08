<?php

namespace app\controllers;

use app\helper_propio\Auxiliar;
use app\helper_propio\Consultas;
use app\models\AccionesRetos;
use app\models\Bloqueos;
use app\models\EcoValora;
use yii\web\Session;
use app\models\FormRecoverPass;
use app\models\FormResetPass;
use app\models\Ranking;
use app\models\Seguidores;
use app\models\Usuarios;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\UsuariosSearch;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

require '../helper_propio/AdministradorAWS3c.php';


class UsuariosController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'update', 'view', 'valorar', 'registrar', 'recoverpass'],

                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'actions' => ['update', 'imagen', 'valorar', 'correo', 'create', 'view'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['registrar', 'resetpass', 'recoverpass'],
                        'roles' => ['?'],
                    ],
                    //El usuario admin es el único que puede ver a todos los usuarios que hay registrados en la plataforma
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rules, $action) {
                            return Auxiliar::esAdministrador();
                        },
                    ],
                ],
            ],
        ];
    }


    /**
     * Lists all Usuarios models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        // $puntuacion = Ranking::find()->where(['usuariosid' => '1'])->one();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

            'estado' => $this->estados(),
        ]);
    }

    /**
     * Valoración de la huella ecológica de un usuario.
     * Solo se puede configurar si el usuario no tiene previamente una puntuación asignada
     * asignada por el usuario
     *
     * @return void
     */
    public function actionValorar()
    {
        $model = new EcoValora();
        $puntuacion2 = Ranking::find()->where(['usuariosid' => Yii::$app->user->id])->one();
        //si el usuario ya tine puntuacion asignada, impido que acceda a la acción
        if ($puntuacion2 !== null) {
            return $this->goHome();
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $ranking = new Ranking();
            $ranking->usuariosid = Yii::$app->user->identity->id;
            $ranking->puntuacion = $model->calculo();
            $ranking->save();
            Yii::$app->session->setFlash('Su puntuación ha sido actualizada correctamente');
            return $this->goHome();
        }

        return $this->render('valoracioneco', [
            'model' => $model,
            //  'punto' => $puntuacion2
        ]);
    }


    public static function estados()
    {
        return array_merge([''], Usuarios::find()
            ->select('estado')
            ->indexBy('id')
            ->column());
    }

    /**
     * Displays a single Usuarios model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        //renderizo la vista mediante consulta ajax en la ventana modal.
        $sonAmigos = Seguidores::find()->where(['usuario_id' => Yii::$app->user->identity->id])->andWhere(['seguidor_id' => $id])->one();


        if (Auxiliar::esAdministrador()) {
            return $this->renderAjax('_viewamigos', [
                'model' => $this->findModel($id),
            ]);
        } elseif ($sonAmigos == null) {
            return $this->renderAjax('view', [
                'model' => $this->findModel($id)
            ]);
        } else {
            return $this->renderAjax('_viewamigos', [
                'model' => $this->findModel($id)
            ]);
        }
    }
    /**
     * Displays a single Usuarios model without render with ajax.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewnoajax($id)
    {
        //renderizo la vista mediante consulta ajax en la ventana modal.
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }
    /**
     * Permite el registro de usuarios en función del modelo de datos
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionRegistrar()
    {
        $model = new Usuarios(['scenario' => Usuarios::SCENARIO_CREAR]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash(
                'info',
                'Confirme su dirección de correo electrónico: ' . $model->email
            );

            Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['smtpUsername'])
                ->setTo($model->email)
                ->setSubject('Validar cuenta ')
                ->setHtmlBody(
                    Html::a(
                        'Haz click aquí para confirmar esta dirección de
                                   correo electrónico',
                        Url::to(['usuarios/validar-correo', 'token_acti' => $model->token_acti], true)
                    ),
                )
                ->send();


            return $this->redirect(['site/login']);
        }

        return $this->renderAjax('registrar', [
            'model' => $model,
        ]);
    }
    /**
     * Función que valida el correo del usuario
     *
     * @param [type] $token_acti
     * @return void
     */
    public function actionValidarCorreo($token_acti)
    {
        if (($usuario = Usuarios::findOne(['token_acti' => $token_acti])) !== null) {
            $usuario->token_acti = null;
            $usuario->save();

            $mensaje['success'] = 'Su cuenta de  correo electrónico ha sido confirmada
                                   con éxito';
        } else {
            $mensaje['danger'] = 'Su cuenta de correo ha sido confirmada anteriormente.';
        }

        Yii::$app->session->setFlash(key($mensaje), $mensaje[key($mensaje)]);

        return $this->redirect(['/']);
    }
    /**
     * Acción update
     * Permite al usuarios modificar ciertos datos de su perfil, ajustar un estado y modificar su foto de perfil.
     * Permite conocer la actividad del usuario y sus amigos en la red
     * Permite personalizar aspectos de estilo de la aplicación
     * @param [type] $id
     * @return void
     */
    public function actionUpdate($id = null)
    {
        $seguidores = Seguidores::find()->where(['seguidor_id' => Yii::$app->user->identity->id])->all();
        $amigos = Seguidores::find()->where(['usuario_id' => Yii::$app->user->identity->id])->all();
        $bloqueados = Bloqueos::find()->where(['usuariosid' => Yii::$app->user->identity->id])->asArray()->all();
        $retosUsuarios =  new ActiveDataProvider([
            'query' => AccionesRetos::find()
                ->joinWith('retosUsuarios r')
                ->where(['cat_id' => Yii::$app->user->identity->categoria_id])

        ]);
        if ($id === null) {
            if (Yii::$app->user->isGuest) {
                Yii::$app->session->setFlash('error', 'Debe estar logueado.');
                return $this->goHome();
            } else {
                $model = Yii::$app->user->identity;
            }
        } else {
            $model = Usuarios::findOne($id);
        }

        $model->scenario = Usuarios::SCENARIO_MODIFICAR;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Se ha modificado correctamente ' . Yii::$app->user->identity->nombre);

            return $this->goHome();
        }


        // $model->contrasena = '';
        // $model->password_repeat = '';

        return $this->render('update', [
            'model' => $model,
            'feeds' => Consultas::gestionFeeds(),
            'seguidores' => $seguidores,
            'amigos' =>   $amigos,
            'bloqueados' => $bloqueados,
            'retosUsuarios' => $retosUsuarios
        ]);
    }
    /**
     * Update Estado
     * Función que permite actualizar solo el estado personal del usuario.
     * @param [type] $id
     * @return void
     */
    public function actionUpdateestado($id = null)
    {
        if ($id === null) {
            if (Yii::$app->user->isGuest) {
                Yii::$app->session->setFlash('error', 'Debe estar logueado.');
                return $this->goHome();
            } else {
                $model = Yii::$app->user->identity;
            }
        } else {
            $model = Usuarios::findOne($id);
        }

        $model->scenario = Usuarios::SCENARIO_MODIFICAR;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Se ha modificado correctamente ' . Yii::$app->user->identity->nombre);

            return $this->goHome();
        }

        return $this->renderAjax('_updateEstado', [
            'model' => $model,
        ]);
    }
    /**
     * Recuperar la contraseña para aquel usuario que no la recuerde.
     *
     * @return void
     */
    public function actionRecoverpass()
    {
        //Instancia para validar el formulario
        $model = new FormRecoverPass;

        //Mensaje que será mostrado al usuario en la vista

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                //Buscar al usuario a través del email
                $table = Usuarios::find()->where('email=:email', [':email' => $model->email]);

                //Si el usuario existe
                if ($table->count() == 1) {
                    //Crear variables de sesión para limitar el tiempo de restablecido del password
                    //hasta que el navegador se cierre
                    $session = new Session;
                    $session->open();

                    //Esta clave aleatoria se cargará en un campo oculto del formulario de reseteado
                    $session['recover'] = rand('0123456789', 200);
                    $recover = $session['recover'];

                    //También almacenaremos el id del usuario en una variable de sesión
                    //El id del usuario es requerido para generar la consulta a la tabla users y
                    //restablecer el password del usuario
                    $table = Usuarios::find()->where('email=:email', [':email' => $model->email])->one();
                    $session['id_recover'] = $table->id;

                    //Esta variable contiene un número hexadecimal que será enviado en el correo al usuario
                    //para que lo introduzca en un campo del formulario de reseteado
                    //Es guardada en el registro correspondiente de la tabla users
                    $verification_code = rand('0123456789', 200);
                    //Columna verification_code
                    $table->codigo_verificacion = $verification_code;
                    //Guardamos los cambios en la tabla users

                    $table->save();

                    //Creamos el mensaje que será enviado a la cuenta de correo del usuario
                    $subject = 'Recuperar password';
                    $body = '<p>Copie el siguiente código de verificación para restablecer su password ... ';
                    $body .= '<strong>' . $verification_code . '</strong></p>';

                    $body .= '<p><a href="' . Url::to('index.php?r=usuarios%2Fresetpass', true) . '">Recuperar password</a></p>';

                    //Enviamos el correo
                    Yii::$app->mailer->compose()
                        ->setTo($model->email)
                        ->setFrom([Yii::$app->params['adminEmail']])
                        ->setSubject($subject)
                        ->setHtmlBody($body)
                        ->send();

                    //Vaciar el campo del formulario
                    $model->email = null;

                    //Mostrar el mensaje al usuario

                    Yii::$app->session->setFlash('success', 'Le hemos enviado un mensaje a su cuenta de correo para que pueda resetear su password');
                    return $this->goHome();
                } else //El usuario no existe
                {
                    Yii::$app->session->setFlash('error', 'Se ha producido un error. No se ha encontrado la dirección de correo.');
                }
            } else {
                $model->getErrors();
            }
        }
        return $this->render('recoverpass', ['model' => $model]);
    }
    /**
     * Action ResetPass
     * Permite el reseteo de la contraseña
     * @return void
     */
    public function actionResetpass()
    {
        //Instancia para validar el formulario
        $model = new FormResetPass;

        //Mensaje que será mostrado al usuario
        $msg = null;

        //Abrimos la sesión
        $session = new Session;
        $session->open();

        //Si no existen las variables de sesión requeridas lo expulsamos a la página de inicio
        if (empty($session['recover']) || empty($session['id_recover'])) {
            return $this->goHome();
        } else {
            $recover = $session['recover'];
            //El valor de esta variable de sesión la cargamos en el campo recover del formulario
            $model->recover = $recover;

            //Esta variable contiene el id del usuario que solicitó restablecer el password
            //La utilizaremos para realizar la consulta a la tabla users
            $id_recover = $session['id_recover'];
        }

        //Si el formulario es enviado para resetear el password

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                //Si el valor de la variable de sesión recover es correcta

                if ($recover == $model->recover) {
                    //Preparamos la consulta para resetear el password, requerimos el email, el id
                    //del usuario que fue guardado en una variable de session y el código de verificación
                    //que fue enviado en el correo al usuario y que fue guardado en el registro
                    $table = Usuarios::findOne(['email' => $model->email, 'id' => $id_recover]);
                    //Encriptar el password
                    $security = Yii::$app->security;
                    $contrasena = $security->generatePasswordHash($model->contrasena);


                    $table->contrasena = $contrasena;

                    //Si la actualización se lleva a cabo correctamente
                    if ($table->save()) {
                        //Destruir las variables de sesión
                        $session->destroy();

                        //Vaciar los campos del formulario
                        $model->email = null;
                        // $model->contrasena = null;
                        $model->password_repeat = null;
                        $model->recover = null;
                        $model->verification_code = null;

                        Yii::$app->session->setFlash('success', 'La contraseña se ha modificado correctamente ');
                        return $this->goHome();
                    } else {
                        Yii::$app->session->setFlash('error', 'Se ha producido un error. Intentelo de nuevo más tarde.');
                        return $this->goHome();
                    }
                }
            }
        }

        return $this->render('resetpass', ['model' => $model, 'msg' => $msg]);
    }
    /**
     * Permite el borrado del perfil del usuario.
     * @param [type] $id
     * @return void
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Se ha borrado el usuario.');
        return $this->goHome();
    }

    public function actionSeguimiento()
    {
        $arrModels = Usuarios::find()->where(['!=', 'rol', 'superadministrador'])->all();
        $dataProvider = new ArrayDataProvider(['allModels' => $arrModels,  'sort' => [
            'attributes' => ['puntuacion'],
        ],]);

        return $this->render(
            'seguimiento',
            [
                'dataProvider' => $dataProvider
            ]
        );
    }

    public function actionImagen($id)
    {

        $model = Usuarios::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($_FILES)) {
                $model->url_avatar = $_FILES['Usuarios']['name']['url_avatar'];
            }
            $model->save();
            if (!empty($_FILES['Usuarios']['name']['url_avatar'])) {
                uploadImagenUsuarios($model);
            }
            return $this->goHome();
        }

        return $this->render('imagen', [
            'model' => $model,
        ]);
    }
    /**
     * Permite guardar valores en las cookies
     *
     * @param [type] $color
     * @param [type] $colorTexto
     * @param [type] $fuente
     * @param [type] $tama
     * @param [type] $colorFondo
     * @return void
     */
    public function actionGuardacookie($color, $colorTexto, $fuente, $tamaño, $colorFondo)
    {
        //Expira en 7 dias
        $color = $color;
        $tamaño = $tamaño . 'px';
        $fuente = $fuente;
        $colorTexto = $colorTexto;
        $colorFondo = $colorFondo;

        setcookie('colorPanel', $color, time() + 60 * 60 * 24 * 7);
        setcookie('tamaño', $tamaño, time() + 60 * 60 * 24 * 7);
        setcookie('fuente', $fuente, time() + 60 * 60 * 24 * 7);
        setcookie('colorTexto', $colorTexto, time() + 60 * 60 * 24 * 7);
        setcookie('colorFondo', $colorFondo, time() + 60 * 60 * 24 * 7);

        return $this->redirect('index');
    }
    /**
     * Permite obtener el valor de una cookie almacenada en el navegador.
     *
     * @param [type] $cookie
     * @return void
     */
    public function actionObtenercookie($cookie)
    {
        $cookies = $_COOKIE[$cookie];
        // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $cookies;
    }
    public function actionBorrarestilos()
    {
        setcookie('colorPanel', '', time() - 3600);
        setcookie('tamaño', '', time() - 3600);
        setcookie('fuente', '', time() - 3600);
        setcookie('colorTexto', '', time() - 3600);
        setcookie('colorFondo', '', time() - 3600);

        // unset($_COOKIE['intro']);
        return $this->goBack();
    }
    /**
     * Permite buscar en el modelo un usuario que coincida con el paramétro de búsqueda
     *
     * @param [type] $cadena
     * @return void
     */
    public function actionBuscar($cadena)
    {
        $usuarios = new ActiveDataProvider([
            'query' => Usuarios::find()->where('1=0'),
        ]);


        if (($cadena = Yii::$app->request->get('cadena', ''))) {
            $usuarios->query->where(['ilike', 'nombre', $cadena])
                ->orwhere(['ilike', 'username', $cadena])
                ->orwhere(['ilike', 'localidad', $cadena]);
            // $usuarios->query->where(['ilike', 'localidad', $cadena]);
        }

        return $this->render('buscar', [

            'usuarios' => $usuarios,
        ]);
    }
    /**
     * Obtiene el estado de un usuario
     *
     * @param [type] $id
     * @return void
     */
    public function actionEstado($id)
    {
        $usuario = Usuarios::find()->where(['id' => $id])->one();
        return $usuario->estado;
    }
    /**
     * Permite consultar la puntuación de un usuario
     *
     * @param [type] $id
     * @return $puntuacion
     */
    public function actionPuntos($id)
    {
        $usuarioPuntos = Ranking::find()->select('ranking.*')->joinWith('usuarios', false)->groupBy('ranking.id')->having(['usuariosid' => $id])->andFilterWhere(['!=', 'usuarios.rol', 'superadministrador'])->one();
        return $usuarioPuntos->puntuacion;
    }
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findModelByAcciones($id)
    {
        if (($model = AccionesRetos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
