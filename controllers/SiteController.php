<?php

namespace app\controllers;

use app\models\AccionesRetos;
use app\models\CategoriasEcoretos;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EcoRetos;
use app\models\EcoValora;
use app\models\Feeds;
use app\models\ImagenForm;
use app\models\Ranking;
use app\models\Seguidores;
use app\models\Usuarios;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

class SiteController extends Controller
{
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
                        'actions' => ['login', 'contact'],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Feeds();

        $model3 = new ImagenForm();
        $puntuacion = Ranking::find()->select('ranking.*')->joinWith('usuarios', false)->groupBy('ranking.id')->one();
        // $puntuacion = Ranking::find()->where(['usuariosid' => Yii::$app->user->identity->id])->one();
        $listaUsuarios = Usuarios::find()->select(['nombre', 'id'])->where(['!=', 'id', Yii::$app->user->identity->id])
            ->all();
        $retos = EcoRetos::find()->where(['usuario_id' => Yii::$app->user->identity->id])->all();
        $sql = 'select  a.descripcion, a.id, e.usuario_id, e.nombrereto from categorias_ecoretos c inner join eco_retos e  on c.categoria_id=e.categoria_id join acciones_retos a  on c.categoria_id=a.cat_id group by  e.usuario_id, e.nombrereto, a.id having e.usuario_id=1';
        // $sql = 'select  a.descripcion  from acciones_retos a inner join categorias_ecoretos c on c.categoria_id=a.cat_id group by a.descripcion order by a.descripcion';

        $retosListado = AccionesRetos::findBySql($sql)->all();

        if ($puntuacion['puntuacion'] < 1) {
            return $this->redirect(['usuarios/valorar']);
        }
        /**
         * Si el usuario no tiene retos asignados, en función de la puntuación
         *  calculada se le otorga unas serie de acciones que corresponden a un reto
         *  [0-30]->categoria1: principante [0-30] ->categoria2: intermedio  [0-60]->categoria3: avanzado
         */
        if (count($retos) == 0) {
            if ($puntuacion['puntuacion'] < 30) {
                $ecoreto = new EcoRetos();
                $ecoreto->usuario_id = Yii::$app->user->identity->id;
                $ecoreto->nombrereto = 'reto' . Yii::$app->user->identity->id;
                $ecoreto->categoria_id = 1;
                $ecoreto->save();
            }
            if ($puntuacion['puntuacion'] > 30 && $puntuacion['puntuacion'] < 60) {
                $ecoreto = new EcoRetos();
                $ecoreto->usuario_id = Yii::$app->user->identity->id;
                $ecoreto->nombrereto = 'reto' . Yii::$app->user->identity->id;
                $ecoreto->categoria_id = 2;
                $ecoreto->save();
            }
            if ($puntuacion['puntuacion'] > 60) {
                $ecoreto = new EcoRetos();
                $ecoreto->usuario_id = Yii::$app->user->identity->id;
                $ecoreto->nombrereto = 'reto' . Yii::$app->user->identity->id;
                $ecoreto->categoria_id = 3;
                $ecoreto->save();
            }
        }


        $sql2 = 'select * from feeds where usuariosid IN (select seguidor_id from seguidores where usuario_id=' . Yii::$app->user->identity->id  . ') or usuariosid=' . Yii::$app->user->identity->id;
        $feedCount = Feeds::findBySql($sql2);

        // var_dump($feedCount);
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $feedCount->count(),
        ]);

        // :find()
        // ->select(['generos.*', 'COUNT(l.id) AS total'])
        // ->joinWith('libros l', false)
        // ->groupBy('generos.id');

        $sql = 'select * from feeds where usuariosid IN (select seguidor_id from seguidores where usuario_id=' . Yii::$app->user->identity->id  . ') or usuariosid=' . Yii::$app->user->identity->id . 'order by created_at desc offset ' . $pagination->offset .  'limit ' .  $pagination->limit;
        $sql2 = 'SELECT f.*, f.id as identificador, usuarios.* FROM usuarios LEFT JOIN feeds f ON usuarios.id = f.usuariosid GROUP BY f.id, usuarios.id having usuarios.id=' . Yii::$app->user->identity->id  . 'or  usuarios.id IN (select seguidor_id from seguidores where usuario_id=' . Yii::$app->user->identity->id  . ')order by created_at desc offset ' . $pagination->offset .  'limit ' .  $pagination->limit;

        // $feed = Feeds::findBySql($sql)
        // $feed = Usuarios::find()->joinWith(['feeds'])->select(['usuarios.id', 'feeds.contenido'])->all();
        // $feed = Usuarios::find()->select('f.contenido')->joinWith('feeds f', false, 'FULL OUTER JOIN')->groupBy(['f.id', 'usuarios.id'])->ALL();
        $feed = Yii::$app->db->createCommand($sql2)->queryAll();
        // var_dump($feed);

        //   $usuarioPuntos = Ranking::find()->select('ranking.*')->joinWith('usuarios', false)->groupBy('ranking.id')->one();
        // var_dump($feed);
        // die;

        return $this->render('index', [

            'datos' => Usuarios::findOne(Yii::$app->user->identity->id),
            'puntos' => $puntuacion,
            'retos' => $retos,
            'retosListado' => $retosListado,
            'feeds' => $feed,
            'model' => $model,
            'pagination' => $pagination,
            'usuarios' => $listaUsuarios,
            'model2' => Usuarios::findOne(Yii::$app->user->identity->id),
            'model3' => $model3,
            'seguidores' => Seguidores::find()
                ->where(['usuario_id' => Yii::$app->user->identity->id])
                ->andWhere(['!=', 'seguidor_id', Yii::$app->user->identity->id])
                ->all(),

        ]);
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
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
    public function actionBuscar()
    {
        $usuarios = new ActiveDataProvider([
            'query' => Usuarios::find()->where('1=0'),
        ]);
        $feed = new ActiveDataProvider([
            'query' => Feeds::find()->where('1=0'),
        ]);

        if (($cadena = Yii::$app->request->get('cadena', ''))) {
            $usuarios->query->where(['ilike', 'nombre', $cadena]);
            $feed->query->where(['ilike', 'contenido', $cadena]);
        }
        return $this->render('buscar', [
            'feed' => $feed,
            'usuarios' => $usuarios,
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

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
