<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegistrarForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Restablecer contraseña';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Introduzca los siguientes datos para resetear su contraseña:</p>

    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => ['wrapper' => 'col-sm-5'],
        ],
    ]);
    ?>


    <?= $form->field($model, 'email')->input('email') ?>


    <?= $form->field($model, 'contrasena')->passwordInput() ?>


    <?= $form->field($model, 'password_repeat')->passwordInput() ?>


    <?= $form->field($model, 'verification_code')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'recover')->input('hidden')->label(false) ?>


    <?= Html::submitButton('Reestablecer contraseña', ['class' => 'btn btn-primary']) ?>

    <?php $form->end() ?>
    <br>
</div>