<?php

use app\helper_propio\Auxiliar;
use kartik\icons\Icon;
use yii\bootstrap4\ActiveForm as Bootstrap4ActiveForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->params['breadcrumbs'][] = $this->title;
$this->title = 'Restablecer contraseña';
$this->title = 'Objetivos Personales';
$this->params['breadcrumbs']['index'] = $this->title;
?>


<div class="usuarios-recoverpass h-100">

    <h1>Restaurar Password</h1>
    <?php $form = Bootstrap4ActiveForm::begin([
        'method' => 'post',
        'enableClientValidation' => true,
        'fieldConfig' => [
            'horizontalCssClasses' => ['wrapper' => 'col-sm-5'],
        ],
    ]);
    ?>
    <div class=col-3>
        <p>Introduzca el e-mail de registro para resetar su contraseña de acceso:</p>
        <?= $form->field($model, 'email')->input('email') ?>

        <?= Html::submitButton('Restaurar Password', ['class' => 'btn btn-primary']) ?>

        <?php $form->end() ?>
    </div>


    <div class="alert alert-info alert-info col-2  mt-5" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        Para terminar el reseteo de la clave deberá recibir un e-mail con las instrucciones, si el e-mail no le llega, Por favor, revise los correos no deseados
        de su gestor de correo. <strong>El equipo de #Ecofriendly</strong>
    </div>

    <?php echo Auxiliar::volverAtras() ?>
</div>