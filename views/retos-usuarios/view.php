<?php

use app\models\AccionesRetos;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RetosUsuarios */

$this->title = $model->idreto;
$this->params['breadcrumbs'][] = ['label' => 'Retos Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="retos-usuarios-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <!-- <?= Html::a('Update', ['update', 'idreto' => $model->idreto, 'usuario_id' => $model->usuario_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'idreto' => $model->idreto, 'usuario_id' => $model->usuario_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> -->
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            // 'usuario_id',

            [
                'attribute' => 'Aceptaste este reto el: ',
                'value' => function ($dataProvider) {

                    return $dataProvider->fecha_aceptacion;
                },
                'format' => 'date',

            ],
            // 'fecha_culminacion',
            'culminado:boolean',
        ],
    ]) ?>
    <?= Html::a('Anotar este reto como superado', ['finalizar', 'idreto' => $model->idreto, 'usuario_id' =>$model->usuario_id], [
        'class' => 'btn btn-success',
        'data' => [
            'confirm' => '¿Confirmas que que has superado este reto? Recibiras un total de ' . 12 . ' puntos #Ecofriendly' ,
            'method' => 'post',
        ],
    ]) ?> 
    <p>Este reto consiste en:</p>
    <?php $model = AccionesRetos::find()->where(['id' => $model->idreto])->one() ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
        
            'titulo',
            // 'fecha_culminacion',
            'descripcion',
        ],
    ]) ?>
</div>