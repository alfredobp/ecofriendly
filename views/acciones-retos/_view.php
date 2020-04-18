<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AccionesRetos */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Acciones Retos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="acciones-retos-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <!-- <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> -->
        <?php
        if ($model->aceptado == true) {
            echo  Html::a('Declinar Reto', ['declinar', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Estas seguro de rechazar este reto?',
                    'method' => 'post',
                ],
            ]);
        } else {
            echo Html::a('Aceptar Reto', ['aceptar', 'id' => $model->id], [
                'class' => 'btn btn-success',
                'data' => [
                    'confirm' => '¿Estas seguro de aceptar este reto?',
                    'method' => 'post',
                ],
            ]);
        }

        ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'titulo',
            'descripcion',
            'puntaje',

            // 'aceptado:boolean',
            // 'culminado:boolean',
        ],
    ]) ?>

</div>