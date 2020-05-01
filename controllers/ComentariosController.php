<?php

namespace app\controllers;

use Yii;
use app\models\Comentarios;
use app\models\ComentariosSearch;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ComentariosController implements the CRUD actions for Comentarios model.
 */
class ComentariosController extends Controller
{
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
     * Lists all Comentarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ComentariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Comentarios model.
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
     * Creates a new Comentarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    // $model = new Feeds();
    // $model->usuariosid = Yii::$app->user->id;
    // // $model->created_at = date('Y-m-d H:i:s');

    // if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //     if (!empty($_FILES)) {
    //         $model->imagen = $_FILES['Feeds']['name']['imagen'];
    //     }
    //     $model->save();
    //     if (!empty($_FILES['Feeds']['name']['imagen'])) {
    //         uploadImagenFeed($model);
    //     }
    //     return $this->goHome();
    // }



    public function actionCreate()
    {

        $model = new Comentarios();
        $model->usuario_id = Yii::$app->user->id;
        $model->created_at = date('Y-m-d H:i:s');
        $model->comentarios_id=1;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->redirect(['site/index', 'id' => $model->id]);
        }
        // return $this->render('create', [
        //     'model' => $model,
        // ]);
    }

    /**
     * Updates an existing Comentarios model.
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
     * Deletes an existing Comentarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Comentarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comentarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comentarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
