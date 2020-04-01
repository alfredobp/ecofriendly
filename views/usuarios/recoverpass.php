<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->params['breadcrumbs'][] = $this->title;
$this->title = 'Restablecer contraseña';
?>
<div class="recoverpass col-6">

    <h1>Recover Password</h1>
    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'enableClientValidation' => true,
        'fieldConfig' => [
            'horizontalCssClasses' => ['wrapper' => 'col-sm-5'],
        ],
    ]);
    ?>

    <?= $form->field($model, 'email')->input('email') ?>

    <?= Html::submitButton('Recover Password', ['class' => 'btn btn-primary']) ?>

    <?php $form->end() ?>
</div>