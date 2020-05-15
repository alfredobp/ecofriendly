<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MensajesPrivados */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="mensajes-privados-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'emisor_id')->textInput() ?>

    <?= $form->field($model, 'receptor_id')->textInput() ?> -->

    <?= $form->field($model, 'asunto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contenido')->textInput(['maxlength' => true]) ?>
<!-- 
    <?= $form->field($model, 'seen')->checkbox() ?> -->
<!-- 
    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'visto_dat')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
