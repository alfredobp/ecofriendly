<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
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

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'titulo',
            'descripcion',
            'cat_id',
            'puntaje',
            //'fecha_aceptacion',
            //'fecha_culminacion',
            //'aceptado:boolean',
            //'culminado:boolean',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
