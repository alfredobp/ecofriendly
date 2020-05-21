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


            [
                'attribute' => 'Usuario',
                'value' => function ($dataProvider) {

                    return (Usuarios::findOne($dataProvider->seguidor_id))->nombre;
                },
                'format' => 'raw',
            ],


            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        return Html::a('Marcar notificación como leido', ['delete', 'id' => $model->id], [
                            'class' => '',
                            'data' => [
                                'confirm' => '¿Estas seguro de querer marcar esta notificiación como leída?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ]
            ],
            [
                'attribute' => 'Tipo Notificación',
                'value' => function ($dataProvider) {
                    if ($dataProvider->tipoNotificacion->tipo == 'comentario' || $dataProvider->tipoNotificacion->tipo == 'me gusta') {
                        # code...
                        return Usuarios::findOne($dataProvider->seguidor_id)->nombre . ' ha realizado un  ' . $dataProvider->tipoNotificacion->tipo . ' en una publicación';
                    }
                    else {
                        return Usuarios::findOne($dataProvider->seguidor_id)->nombre . ' le sigue.';

                    }
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

        ],
    ]); ?>


</div>