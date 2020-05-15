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

    <h3><?= Html::encode('Mensaje Recibido de:  ' . $model->emisor->username) ?></h3>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'emisor.nombre',
            'receptor.nombre',
            'asunto',
            'contenido',
            'seen:boolean',
            'created_at',
            'visto_dat',
        ],
    ]) ?>
    <p>
        <!-- <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> -->
        <?= Html::a('Responder', ['responder', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar Mensaje', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>