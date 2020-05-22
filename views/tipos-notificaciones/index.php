<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TiposNotificacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipos Notificaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-notificaciones-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tipos Notificaciones', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tipo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
