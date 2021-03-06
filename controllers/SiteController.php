<?php

namespace app\controllers;

use app\helper_propio\Auxiliar;
use app\models\AccionesRetos;
use app\models\Comentarios;
use app\models\ContactForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Feeds;
use app\models\Ranking;
use app\models\Seguidores;
use app\models\Usuarios;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\Url;

class SiteController extends Controller
{

    public $successUrl = '';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'login', 'logout', 'contact'],

                'rules' => [
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login', 'contact', 'auth'],
                        'roles' => ['?'],
                    ],
                ],

            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }
    /**
     * Función de exito a la llamada a la api de facebook
     * Si encuentra el email en el perfil de facebook se accede a la aplicaci
     * @param [type] $client
     * @return void
     */
    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();
        $user = Usuarios::find()->where(['email' => $attributes['email']])->one();
        if (!empty($user)) {
            Yii::$app->user->login(Usuarios::findPorEmail($attributes));
        } else {
            $session = Yii::$app->session;
            $session['attributes'] = $attributes;
            $this->successUrl = Url::to(['login']);
        }
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $id = Yii::$app->user->identity->id;
        $model = new Feeds();
        $puntuacion = Ranking::find()->select('ranking.*')->joinWith('usuarios', false)->groupBy('ranking.id')->having(['usuariosid' => $id])->one();

        $listaUsuarios = Usuarios::usuariosRegistrados($id);
        if (Yii::$app->user->identity->rol == 'superadministrador') {
            //Envio de email a usuarios que lleven mas de una semana sin conectarse cuando el usuario admin inicia sesión
            Auxiliar::enviarEmailAusentes();

            return $this->render('_indexAdmin', [
                'model' => Feeds::find()->all(),
                'feeds' =>  Auxiliar::areaAdminConf()->offset(Auxiliar::areaAdminConfII()->offset)
                    ->limit(Auxiliar::areaAdminConfII()->limit)
                    ->all(),
                'pagination' => Auxiliar::areaAdminConfII(),
            ]);
        } else {
            if ($puntuacion == null) {
                return $this->redirect(['usuarios/valorar']);
            }

            $user = Usuarios::findOne($id);
            if ($user->categoria_id == null) {
                Ranking::puntuacionInicial($id);
                return  $this->goHome();
            }
            $query = Feeds::listarFeeds($id);
            //paginacion de 10 feeds, ordenados cronologicamente
            $pagination = new Pagination([
                'defaultPageSize' => 10,
                'totalCount' => $query->count(),
            ]);
            $query = $query->orderBy('feeds.created_at desc')
                ->asArray();

            $feed = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
            return $this->render('index', [
                'comentarios2' => new Comentarios(),
                'datos' => Usuarios::findOne($id),
                // 'retosListado' => $retosListado,
                'feeds' => $feed,
                'model' => $model,
                'pagination' => $pagination,
                'usuarios' => $listaUsuarios,
                'comentar' =>  new Comentarios(),
                'seguidores' => Seguidores::find()
                    ->joinWith('usuario')
                    ->where(['usuario_id' => $id])
                    ->andWhere(['!=', 'seguidor_id', $id])
                    ->all(),
            ]);
        }
    }
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    /**
     * Acción Buscar
     * Permite la busqueda desde un parametro que se le envía como cadena desde un formulario en el index.
     * Dependiendo de si el usuario es admin o no, se permite una búsqueda global o bien una búsqueda de su red
     * de contactos
     * @return void
     */
    public function actionBuscar()
    {
        $usuarios = new ActiveDataProvider([
            'query' => Usuarios::find()->where('1=0'),
        ]);
        $retos = new ActiveDataProvider([
            'query' => AccionesRetos::find()->where('1=0'),
        ]);
        $feed = new ActiveDataProvider([
            'query' => Feeds::find()->leftJoin('seguidores', 'seguidores.seguidor_id=feeds.usuariosid')
                ->leftJoin('usuarios', 'usuarios.id=feeds.usuariosid')->where('1=0'),
        ]);
        $feedGeneral = new ActiveDataProvider([
            'query' => Feeds::find()->where('1=0'),
        ]);
        $hastag = new ActiveDataProvider([
            'query' => Feeds::find()->leftJoin('seguidores', 'seguidores.seguidor_id=feeds.usuariosid')
                ->leftJoin('usuarios', 'usuarios.id=feeds.usuariosid')->where('1=0'),
        ]);
        $hastagGeneral = new ActiveDataProvider([
            'query' => Feeds::find()->where('1=0'),
        ]);
        if (($cadena = Yii::$app->request->get('cadena', ''))) {
            $usuarios->query->where(['ilike', 'nombre', $cadena])->andWhere(['!=', 'rol', 'superadministrador']);
            !Auxiliar::esAdministrador() ? $feed->query
                ->where(['ilike', 'contenido', $cadena])
                ->andWhere([
                    'seguidores.usuario_id' =>  Yii::$app->user->identity->id
                ])
                ->andWhere('feeds.created_at>seguidores.fecha_seguimiento') : $feedGeneral->query
                ->where(['ilike', 'contenido', $cadena]);
            Auxiliar::esAdministrador() ? $hastag : $hastagGeneral->query->where(['ilike',  'contenido', '%<p>' . $cadena . '</p>%', false]);
        }
        return $this->render('buscar', [
            'feed' => Auxiliar::esAdministrador() ? $feedGeneral : $feed,
            'usuarios' => $usuarios,
            'retos' => $retos,
            'hastag' => Auxiliar::esAdministrador() ? $hastag : $hastagGeneral,
            'cadena' => $cadena
        ]);
    }
    /**
     * Acción que genera una cookie para la gestión de la política de cookies.
     *
     * @param string $respuesta
     * @return void
     */
    public function actionCookie($respuesta = 'aceptada')
    {
        $valor = $respuesta;
        setcookie('politicaCookies', $respuesta, time() + 60 * 60 * 24 * 15);
        return $this->goBack();
    }
    public function actionNuevos($respuesta = 'leida')
    {
        $valor = $respuesta;
        setcookie('intro', $respuesta, time() + 60 * 60 * 24 * 15);
        return $this->goBack();
    }
    public function actionFaqs()
    {
        return $this->render('faqs');
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContactar()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('success', 'Correo enviado satisfactoriamente');

            return $this->redirect(['site/index']);
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
}
