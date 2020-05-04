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
use app\models\Ecoretos;
use app\models\EcoValora;
use app\models\Feeds;
use app\models\ImagenForm;
use app\models\Ranking;
use app\models\RetosUsuarios;
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
        $id = Yii::$app->user->identity->id;
        $model = new Feeds();


        $puntuacion = Ranking::find()->select('ranking.*')->joinWith('usuarios', false)->groupBy('ranking.id')->having(['usuariosid' => $id])->one();

        $listaUsuarios = Usuarios::find()->select(['nombre', 'id', 'url_avatar'])->where(['!=', 'id', $id])->andWhere(['!=','rol', 'superadministrador'])
            ->all();


        if ($puntuacion==null) {
            return $this->redirect(['usuarios/valorar']);
        }
        /**
         * Si el usuario no tiene retos asignados, en función de la puntuación
         *  calculada se le otorga unas serie de acciones que corresponden a un reto
         *  [0-30]->categoria1: principante [0-30] ->categoria2: intermedio  [0-60]->categoria3: avanzado
         */
        $user = Usuarios::findOne($id);

        if ($user->categoria_id == null) {
            if ($puntuacion['puntuacion'] <= 30) {
                $usuarios = Usuarios::find()->where(['id' => $id])->one();
                $usuarios->categoria_id = 1;
                $usuarios->save();
                return $this->goHome();
            }
            if ($puntuacion['puntuacion'] > 30 && $puntuacion['puntuacion'] < 60) {
                $usuarios = Usuarios::find()->where(['id' => $id])->one();
                $usuarios->categoria_id = 2;
                $usuarios->save();
                return $this->goHome();
            }
            if ($puntuacion['puntuacion']  >= 60) {
                $usuarios = Usuarios::find()->where(['id' => $id])->one();
                $usuarios->categoria_id = 3;
                $usuarios->save();
                return $this->goHome();
            }
        }

        //paginacion de 10 feeds, ordenados cronologicamente
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => Feeds::find()->select(['usuarios.*', 'seguidores.*', 'feeds.*'])
                ->leftJoin('seguidores', 'seguidores.seguidor_id=feeds.usuariosid')
                ->leftJoin('usuarios', 'usuarios.id=feeds.usuariosid')
                ->Where([
                    'seguidores.usuario_id' => $id
                ])
                ->andWhere('feeds.created_at>seguidores.fecha_seguimiento')
                ->orwhere(['feeds.usuariosid' => $id])->count(),
        ]);

        $feed = Feeds::find()->select(['usuarios.*', 'seguidores.*', 'feeds.*'])
            ->leftJoin('seguidores', 'seguidores.seguidor_id=feeds.usuariosid')
            ->leftJoin('usuarios', 'usuarios.id=feeds.usuariosid')
            ->Where([
                'seguidores.usuario_id' => $id
            ])
            ->andWhere('feeds.created_at>seguidores.fecha_seguimiento')
            ->orwhere(['feeds.usuariosid' => $id])
            ->orderBy('feeds.created_at desc')
            ->asArray()->all();



        return $this->render('index', [

            'datos' => Usuarios::findOne($id),
            // 'retosListado' => $retosListado,
            'feeds' => $feed,
            'model' => $model,
            'pagination' => $pagination,
            'usuarios' => $listaUsuarios,
            'seguidores' => Seguidores::find()
                ->where(['usuario_id' => $id])
                ->andWhere(['!=', 'seguidor_id', $id])
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
    /**
     * Acción Buscar
     * Permite la busqueda desde un parametro que se le envía como cadena desde un formulario en el index.
     * @return void
     */
    public function actionBuscar()
    {
        $id = Yii::$app->user->identity->id;
        $usuarios = new ActiveDataProvider([
            'query' => Usuarios::find()->where('1=0'),
        ]);
        $retos = new ActiveDataProvider([
            'query' => AccionesRetos::find()->where('1=0'),
        ]);
        $feed = new ActiveDataProvider([
            'query' => Feeds::find()->where('1=0'),
        ]);
        $hastag = new ActiveDataProvider([
            'query' => Feeds::find()->where('1=0'),
        ]);

        if (($cadena = Yii::$app->request->get('cadena', ''))) {
            $usuarios->query->where(['ilike', 'nombre', $cadena]);
            $feed->query->where(['ilike', 'contenido', $cadena]);
            $retos->query->where(['ilike', 'titulo', $cadena])->andWhere(['cat_id' => $id = Yii::$app->user->identity->categoria_id]);
            $hastag->query->where(['ilike', 'contenido', $cadena . '%', false]);
        }
        return $this->render('buscar', [
            'feed' => $feed,
            'usuarios' => $usuarios,
            'retos' => $retos,
            'hastag' => $hastag,
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

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionFaqs()
    {
        return $this->render('faqs');
    }
}
