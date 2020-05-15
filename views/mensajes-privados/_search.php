<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MensajesPrivadosSearch */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="mensajes-privados-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'emisor_id') ?>

    <?= $form->field($model, 'receptor_id') ?>

    <?= $form->field($model, 'asunto') ?>

    <?= $form->field($model, 'contenido') ?>

    <?php // echo $form->field($model, 'seen')->checkbox() ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'visto_dat') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
