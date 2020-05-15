<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MensajesPrivados */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="mensajes-privados-form col-8">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'receptor_id')->label('Nombre')->dropDownList($usuarios) ?>

    <?= $form->field($model, 'asunto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contenido')->textarea() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
