<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ranking */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="ranking-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'puntuacion')->textInput() ?>

    <?= $form->field($model, 'usuariosid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
