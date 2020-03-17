<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Feeds */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="feeds-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'usuariosid')->textInput() ?>

    <?= $form->field($model, 'contenido')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
