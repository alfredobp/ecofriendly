<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FeedsFavoritosSearch */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="feeds-favoritos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'usuario_id') ?>

    <?= $form->field($model, 'feed_id') ?>

    <?= $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
