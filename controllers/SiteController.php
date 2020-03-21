<?php

namespace app\controllers;

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
use app\models\Ranking;
use app\models\Usuarios;
use yii\data\ActiveDataProvider;

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
                'only' => ['index', 'logout'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
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

        $puntuacion = Ranking::find()->where(['usuariosid' => Yii::$app->user->identity->id])->one();
        $listaUsuarios = Usuarios::find()->select(['nombre','id'])->all();
        if ($puntuacion['puntuacion'] < 1) {
            return $this->redirect(['usuarios/valora', 'id' => $this->id]);
        }
        $retos = EcoRetos::find()->where(['usuario_id' => Yii::$app->user->identity->id])->all();
        if ($puntuacion['puntuacion'] < 10) {
            $reto = new EcoRetos();
            $reto->usuario_id = '1';
            $reto->descripcion = 'Caminar más km al día';
            $reto->puntaje = '3';
            $reto->categoria_id = '1';
            $reto->save();
        }
        if ($puntuacion['puntuacion'] > 10) {
            $reto = new EcoRetos();
            $reto->usuario_id = '1';
            $reto->descripcion = 'Coger el coche menos';
            $reto->puntaje = '3';
            $reto->categoria_id = '1';
            $reto->save();
        }
        if ($puntuacion['puntuacion'] > 20) {
            $reto = new EcoRetos();
            $reto->usuario_id = '1';
            $reto->descripcion = 'Comprar en el super';
            $reto->puntaje = '3';
            $reto->categoria_id = '1';
            $reto->save();
        }

        $feed = Feeds::find()->where(['usuariosid' => Yii::$app->user->identity->id])->all();
        return $this->render('index', [

            'estado' => Usuarios::findOne(1),
            'puntos' => $puntuacion,
            'retos' => $retos,
            'feeds' => $feed,
            'model' => $model,
            'usuarios' => $listaUsuarios,


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
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
