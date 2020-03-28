<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CategoriasEcoretos */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="categorias-ecoretos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cat_nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'categoria_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
