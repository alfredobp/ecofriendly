<?php

namespace app\controllers;

use Yii;
use app\models\RetosUsuarios;
use app\models\RetosUsuariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RetosUsuariosController implements the CRUD actions for RetosUsuarios model.
 */
class RetosUsuariosController extends Controller
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
        ];
    }

    /**
     * Lists all RetosUsuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RetosUsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RetosUsuarios model.
     * @param integer $idreto
     * @param integer $usuario_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idreto, $usuario_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($idreto, $usuario_id),
        ]);
    }

    /**
     * Creates a new RetosUsuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RetosUsuarios();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idreto' => $model->idreto, 'usuario_id' => $model->usuario_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RetosUsuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $idreto
     * @param integer $usuario_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idreto, $usuario_id)
    {
        $model = $this->findModel($idreto, $usuario_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idreto' => $model->idreto, 'usuario_id' => $model->usuario_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RetosUsuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $idreto
     * @param integer $usuario_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idreto, $usuario_id)
    {
        $this->findModel($idreto, $usuario_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RetosUsuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $idreto
     * @param integer $usuario_id
     * @return RetosUsuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idreto, $usuario_id)
    {
        if (($model = RetosUsuarios::findOne(['idreto' => $idreto, 'usuario_id' => $usuario_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
