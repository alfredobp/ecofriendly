<?php

namespace app\controllers;

use Yii;
use app\models\Feeds;
use app\models\FeedsSearch;
use app\models\ImagenForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * FeedsController implements the CRUD actions for Feeds model.
 */
class FeedsController extends Controller
{

    public $contenido;
    public $imagen;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['update', 'view', 'index', 'create'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ]
        ];
    }
    /**
     * Lists all Feeds models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FeedsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Feeds model.
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

    /**
     * Creates a new Feeds model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Feeds();
        $model2 = new ImagenForm();
        $id = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->usuariosid = Yii::$app->user->id;
            $model->contenido = $model->contenido;
            $model->created_at = date('Y-m-d H:i:s');
            $model->save();
            $id = $model->id;
        }

        // if (Yii::$app->request->isPost) {
        //     $model2->imagen = UploadedFile::getInstance($model2, 'imagen');
        //     if ($model2->upload($id)) {
        //         return $this->redirect('index');
        //     }
        // }

        // return $this->render('imagen', [
        //     'model' => $model2,
        //     'id' => $id,

        // ]);

        return $this->redirect(['site/index', 'id' => $model->id]);
    }
    public function actionImagen()
    {
        $model = new ImagenForm();
       

        if (Yii::$app->request->isPost) {
            $model->imagen = UploadedFile::getInstance($model, 'imagen');
            if ($model->upload('feed')) {
                return $this->redirect('index');
            }
        }

        return $this->render('imagen', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Feeds model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Feeds model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->goHome();
    }
    /**
     * Finds the Feeds model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Feeds the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Feeds::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
