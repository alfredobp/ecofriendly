<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuariosActividad */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="usuarios-actividad-form col-10 ">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'motivo')->textInput() ?>

    <!-- <?= $form->field($model, 'fecha_suspenso')->textInput() ?> -->
    <?= $form->field($model, 'usuario_id')->label('Nombre')->dropDownList($participantes) ?>

    <div class="form-group">
        <?= Html::submitButton('Bloquear cuenta', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
