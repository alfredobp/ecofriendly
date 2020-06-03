<?php

use app\helper_propio\Auxiliar;
use app\models\Comentarios;
use app\models\Feeds;
use app\models\Usuarios;
use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NotificacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notificaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notificaciones-index">


    <?=
        !Auxiliar::esAdministrador() ? GridView::widget([
            'dataProvider' => $dataProvider,
            'options' => [
                'class' => 'shadow-lg p-3 mb-5 bg-white rounded'
            ],
            'columns' => [

                [
                    'attribute' => 'link',
                    'value' => function ($dataProvider) {
                        if ($dataProvider->tipoNotificacion->tipo == 'comentario') {
                            return  Html::a('Ver notificacion', Url::to(['comentarios/view', 'id' => $dataProvider->id_evento, 'idNotificacion' => $dataProvider->id_evento, true]));
                        } elseif ($dataProvider->tipoNotificacion->tipo == 'me gusta') {
                            return  Html::a('Ver notificacion', Url::to(['feeds-favoritos/view', 'id' => $dataProvider->id_evento, 'idNotificacion' => $dataProvider->id_evento, true]));
                        } else {
                            return  Html::a('Ver notificacion', Url::to(['seguidores/view', 'id' => $dataProvider->id_evento, 'idNotificacion' => $dataProvider->id_evento, true]));
                        }
                    },


                    'format' => 'raw',
                ],
                [
                    'attribute' => 'Usuario',
                    'value' => function ($dataProvider) {

                        return (Usuarios::findOne($dataProvider->seguidor_id))->nombre;
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'Leida',

                    'value' => function ($dataProvider) {

                        return ($dataProvider->leido);
                    },
                    'format' => 'Boolean',
                ],

                [

                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function ($url, $model) {
                            return Html::a('Borrar Notificación', ['delete', 'id' => $model->id], [
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
                            return Usuarios::findOne($dataProvider->seguidor_id)->nombre . ' ha realizado un  '
                                . $dataProvider->tipoNotificacion->tipo . ' en una publicación';
                        } else {
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
        ]) : GridView::widget([
            'dataProvider' => $dataProvider,

            'columns' => [
                [
                    'attribute' => 'link',
                    'value' => function ($dataProvider) {
                        if ($dataProvider->tipoNotificacion->tipo == 'comentario') {
                            return  Html::a('Ver notificacion', Url::to(['comentarios/view', 'id' => $dataProvider->id_evento, 'idNotificacion' => $dataProvider->id_evento, true]));
                        } elseif ($dataProvider->tipoNotificacion->tipo == 'me gusta') {
                            return  Html::a('Ver notificacion', Url::to(['feeds-favoritos/view', 'id' => $dataProvider->id_evento, 'idNotificacion' => $dataProvider->id_evento, true]));
                        } else {
                            return  Html::a('Ver notificacion', Url::to(['seguidores/view', 'id' => $dataProvider->id_evento, 'idNotificacion' => $dataProvider->id_evento, true]));
                        }
                    },


                    'format' => 'raw',
                ],
                [
                    'attribute' => 'Tipo Notificación',
                    'value' => function ($dataProvider) {
                        if ($dataProvider->tipoNotificacion->tipo == 'comentario' || $dataProvider->tipoNotificacion->tipo == 'me gusta') {
                            return Usuarios::findOne($dataProvider->seguidor_id)->nombre . ' ha realizado un  '
                                . $dataProvider->tipoNotificacion->tipo . ' en una publicación de ' . Usuarios::findOne($dataProvider->usuario_id)->nombre;
                        } else {
                            return Usuarios::findOne($dataProvider->seguidor_id)->nombre . ' ha comenzado a seguir a ' . Usuarios::findOne($dataProvider->usuario_id)->nombre;
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
        ])  ?>

    <?= Auxiliar::esAdministrador()?Html::a(Icon::show('server') . 'Configurar Tipos de Notificaciones', '/index.php?r=tipos-notificaciones%2Findex', $options = []):'' ?>
    <?php echo Auxiliar::volverAtras() ?>
</div>