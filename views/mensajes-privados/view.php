<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MensajesPrivados */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mensajes Privados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mensajes-privados-view">
    <?php
    if ($model->emisor->username === Yii::$app->user->identity->username) {
        echo '<h3>' . Html::encode('Mensaje enviado de:  ' . ucfirst($model->emisor->username)) . '</h3>';
    } else {
        echo '<h3>' . Html::encode('Mensaje Recibido de:  ' . ucfirst($model->emisor->username)) . '</h3>';
    }


    ?>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',

            [
                'attribute' => 'Enviado por:',
                'value' => function ($model) {
                    return ucfirst($model->emisor->nombre);
                },
                'format' => 'raw',
            ],

            // 'receptor.nombre',
            'asunto',
            'contenido',
            // 'seen:boolean',
            [
                'attribute' => 'Recibido:',
                'value' => function ($model) {
                    return Yii::$app->formatter->asRelativeTime($model->created_at);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'Viste este mensaje',
                'value' => function ($model) {
                    return Yii::$app->formatter->asRelativeTime($model->visto_dat);
                },
                'format' => 'raw',
            ],

        ],
    ]) ?>
    <p>
        <!-- <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> -->
        <?= Html::a('Responder', ['responder', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar Mensaje', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Seguro que quieres borrar este mensaje?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>