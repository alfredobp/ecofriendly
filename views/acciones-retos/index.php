<?php

use app\helper_propio\Auxiliar;
use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccionesRetosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Acciones Retos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acciones-retos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Auxiliar::esAdministrador() ? Html::a('Crear nuevo reto', ['create'], ['class' => 'btn btn-success']) : '' ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <div style="height:600px" class="overflow-auto shadow-lg p-3 mb-5 bg-white rounded">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                // ['class' => 'yii\grid\SerialColumn'],

                'id',
                'titulo',
                'ecoreto.cat_nombre',
                'descripcion',
                // 'cat_id',
                'puntaje',
                [
                    'class' => ActionColumn::class,
                    'controller' => 'acciones-retos',
                    'template' => Auxiliar::esAdministrador() ? '{verreto} {update} {delete}' : '{verreto}{aceptarreto}',
                    'buttons' => [

                        'verreto' => function ($url, $model) {
                            return \yii\helpers\Html::a(
                                Icon::show('eye'),
                                (new yii\grid\ActionColumn())->createUrl('acciones-retos/verreto', $model, $model['id'], 1),
                                [
                                    'title' => Yii::t('yii', 'Ver Accion Reto'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                ]
                            );
                        },
                        'aceptarreto' => function ($url, $model) {
                            return \yii\helpers\Html::a(
                                Icon::show('check'),
                                (new yii\grid\ActionColumn())->createUrl('retos-usuarios/create', $model, ['idreto' => $model->id, 'usuario_id' => Yii::$app->user->identity->id], 1),
                                [
                                    'title' => Yii::t('yii', 'Aceptar Reto'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                ]
                            );
                        },
                    ],
                ],



            ],
        ]); ?>

    </div>
    <?= Auxiliar::volverAtras() ?>
</div>