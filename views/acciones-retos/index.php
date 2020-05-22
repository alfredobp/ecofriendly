<?php

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
        <?= Html::a('Create Acciones Retos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <div class="overflow-auto">
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
                    'template' => '{verreto} {update} {delete}',
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
                    ],
                ],


            ],
        ]); ?>

    </div>
</div>