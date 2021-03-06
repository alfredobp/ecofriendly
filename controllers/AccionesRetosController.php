<?php

namespace app\controllers;

use app\helper_propio\Auxiliar;
use Yii;
use app\models\AccionesRetos;
use app\models\AccionesRetosSearch;
use app\models\Ecoretos;
use app\models\Ranking;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AccionesRetosController implements the CRUD actions for AccionesRetos model.
 */
class AccionesRetosController extends Controller
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
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        //Solo el usuario admin puede crear nuevos retos desde la plataformas
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rules, $action) {
                            return Auxiliar::esAdministrador();
                        },
                    ],


                ],
            ]
        ];
    }

    /**
     * Lists all AccionesRetos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccionesRetosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Displays a single AccionesRetos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax('_view', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Función Ver Reto para las búsquedas de los retos asignados por el usuario.
     *
     * @param [type] $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionVerreto($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    // public function actionVerhastag($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }
    /**
     * Creates a new AccionesRetos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AccionesRetos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'categorias' => Ecoretos::categorias(),

        ]);
    }

    /**
     * Updates an existing AccionesRetos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'categorias' => Ecoretos::categorias(),
        ]);
    }
    /**
     * Aceptar
     * Permite al usuario aceptar un reto propuesto por el sistema
     * @param [type] $id
     * @return void
     */
    public function actionAceptar($id)
    {
        $model = $this->findModel($id);
        if ($model->save()) {
            $model->aceptado = true;
            $model->fecha_aceptacion = date('Y-m-d H:i:s');
            $model->usuario_id = Yii::$app->user->identity->id;
            $model->save();
            Yii::$app->session->setFlash('success', 'El reto propuesto ha sido aceptado.');
            return $this->redirect(['site/index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }




    /**
     * Deletes an existing AccionesRetos model.
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
     * Finds the AccionesRetos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AccionesRetos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AccionesRetos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
