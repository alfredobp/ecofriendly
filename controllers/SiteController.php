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
use app\models\ImagenForm;
use app\models\Ranking;
use app\models\Seguidores;
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
    public function actionEditableDemo()
    {
        $model = new Feeds(); // your model can be loaded here

        // Check if there is an Editable ajax request
        if (isset($_POST['hasEditable'])) {
            // use Yii's response format to encode output as JSON
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            // read your posted model attributes
            if ($model->load($_POST)) {
                // read or convert your posted information
                $value = $model->estado;

                // return JSON encoded output in the below format
                return ['output' => $value, 'message' => ''];

                // alternatively you can return a validation error
                // return ['output'=>'', 'message'=>'Validation error'];
            }
            // else if nothing to do always return an empty JSON encoded output
            else {
                return ['output' => '', 'message' => ''];
            }
        }

        // Else return to rendering a normal view
        return $this->render('view', ['model' => $model]);
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Feeds();
        $model2 = Usuarios::findOne(Yii::$app->user->identity->id);
        $model3= new ImagenForm();

        $puntuacion = Ranking::find()->where(['usuariosid' => Yii::$app->user->identity->id])->one();
        $listaUsuarios = Usuarios::find()->select(['nombre', 'id'])->where(['!=', 'id', Yii::$app->user->identity->id])
            ->all();
        $retos = EcoRetos::find()->where(['usuario_id' => Yii::$app->user->identity->id])->all();

        if ($puntuacion['puntuacion'] < 1) {
            return $this->redirect(['usuarios/valorar']);
        } else {
            if (sizeof($retos) == 0) {
                if ($puntuacion['puntuacion'] < 30) {
                    $reto = new EcoRetos();
                    $reto->usuario_id = '1';
                    $reto->descripcion = 'Caminar más km al día';
                    $reto->puntaje = '30';
                    $reto->categoria_id = '1';
                    $reto->save();
                    $reto = new EcoRetos();
                    $reto->usuario_id = '1';
                    $reto->descripcion = 'Hacer compras más sostenibles';
                    $reto->puntaje = '10';
                    $reto->categoria_id = '1';
                    $reto->save();
                    $reto = new EcoRetos();
                    $reto->usuario_id = '1';
                    $reto->descripcion = 'Compartir coche con otros compañeros';
                    $reto->puntaje = '15';
                    $reto->categoria_id = '1';
                    $reto->save();
                }
                if ($puntuacion['puntuacion'] > 30 && $puntuacion['puntuacion'] < 60) {
                    $reto = new EcoRetos();
                    $reto->usuario_id = '1';
                    $reto->descripcion = 'Comprar más alimentos Eco';
                    $reto->puntaje = '3';
                    $reto->categoria_id = '1';
                    $reto->save();
                }
                if ($puntuacion['puntuacion'] > 60) {
                    $reto = new EcoRetos();
                    $reto->usuario_id = '1';
                    $reto->descripcion = 'Consumir menos carne';
                    $reto->puntaje = '3';
                    $reto->categoria_id = '1';
                    $reto->save();
                }
                return $this->goHome();
            }
        }


        $feed = Feeds::find()->where(['usuariosid' => Yii::$app->user->identity->id])->all();
        return $this->render('index', [

            'datos' => Usuarios::findOne(Yii::$app->user->identity->id),
            'puntos' => $puntuacion,
            'retos' => $retos,
            'feeds' => $feed,
            'model' => $model,
            'usuarios' => $listaUsuarios,
            'model2' => Usuarios::findOne(Yii::$app->user->identity->id),
            'model3'=>$model3,
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
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
