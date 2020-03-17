<?php

namespace app\controllers;

use yii\web\Session;
use app\models\FormRecoverPass;
use app\models\FormResetPass;
use app\models\ImagenForm;
use app\models\Usuarios;
use Yii;
use yii\bootstrap4\Alert;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use app\models\UsuariosSearch;

class UsuariosController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['registrar'],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    // everything else is denied by default
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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'estado' => $this->estados(),
        ]);
    }
    // public function actionValorar()
    // {
    //     return $this->render('valorar', [
            
    //     ]);
    // }
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
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
                ->setHtmlBody(Html::a(
                    'Haz click aquí para confirmar esta dirección de
                                   correo electrónico',
                    Url::to(['usuarios/validar-correo', 'token_acti' => $model->token_acti], true)
                ),)
                ->send();


            return $this->redirect(['site/login']);
        }

        return $this->render('registrar', [
            'model' => $model,
        ]);
    }
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

        return $this->redirect(['index/login']);
    }
    public function actionUpdate($id = null)
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

        $model->contrasena = '';
        $model->password_repeat = '';

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionRecoverpass()
    {
        //Instancia para validar el formulario
        $model = new FormRecoverPass;

        //Mensaje que será mostrado al usuario en la vista
        $msg = null;

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

                    $body .= '<p><a href="' . Url::to('/usuarios/resetpass', true) . '">Recuperar password</a></p>';

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
        return $this->render('recoverpass', ['model' => $model, 'msg' => $msg]);
    }

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
            var_dump('hola');

            return $this->redirect(['index']);
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
            var_dump(Yii::$app->request->post());

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
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Se ha borrado el usuario.');
        return $this->goHome();
    }

    public function actionImagen($id)
    {
        $model = new ImagenForm();

        if (Yii::$app->request->isPost) {
            $model->imagen = UploadedFile::getInstance($model, 'imagen');
            if ($model->upload($id)) {
                return $this->redirect('index');
            }
        }

        return $this->render('imagen', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
