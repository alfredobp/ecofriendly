<?php

use app\models\Comentarios;
use app\models\Feeds;
use app\models\Usuarios;
use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NotificacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notificaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notificaciones-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a('Create Notificaciones', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'Usuario',
                'value' => function ($dataProvider) {

                    return (Usuarios::findOne($dataProvider->seguidor_id))->nombre;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'Usuario',
                'value' => function ($dataProvider) {

                    return (Comentarios::find()->where(['created_at' => $dataProvider->created_at])->one());
                },
                'format' => 'raw',
            ],
            'leido:boolean',

            [
                'attribute' => 'Tipo Notificación',
                'value' => function ($dataProvider) {
                    return ucfirst($dataProvider->tipoNotificacion->tipo);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'Fecha Notificación',
                'value' => function ($dataProvider) {
                    return Yii::$app->formatter->asRelativeTime($dataProvider->created_at);
                },
                'format' => 'raw',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>