<?php

use app\models\AccionesRetos;
use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RetosUsuarios */

$this->title = $model->idreto;
// $this->params['breadcrumbs'][] = ['label' => 'Retos Usuarios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="retos-usuarios-view">
    <!-- <h1><?= Html::encode('Sus retos') ?></h1> 
    <h1><?= Html::encode($this->title) ?></h1> -->
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
    <br>
    <?php

    $puntos = AccionesRetos::find()->where(['id' => $model->idreto])->one();


    ?>
    <?php if ($model->fecha_culminacion == null) {
        echo Html::a('Anotar este reto como superado', ['finalizar', 'idreto' => $model->idreto, 'usuario_id' => $model->usuario_id], [
            'class' => 'btn btn-success mr-3  text-center',
            'data' => [
                'confirm' => '¿Confirmas que que has superado este reto? Recibiras un total de <strong> ' . $puntos['puntaje'] . '</strong> puntos #Ecofriendly',
                'method' => 'post',
            ],
        ]);

        echo Html::a('Declinar reto', ['declinar', 'idreto' => $model->idreto, 'usuario_id' => $model->usuario_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estas seguro de declinar este reto?',
                'method' => 'post',
            ],
        ]);
    } else {
    ?>
        <div class="alert alert-info alert-info col-12  mt-5" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            El reto ya ha sido anotado como terminado. <strong>El equipo de #Ecofriendly</strong> le agradece su participación.
        </div>
    <?php
    } ?>

    <p class="mt-5 shadow p-3">Este reto consiste en:</p>
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