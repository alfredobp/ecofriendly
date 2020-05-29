<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsuariosActividad */

$this->title = 'Bloquear cuenta usuario';
$this->params['breadcrumbs'][] = ['label' => 'Cuentas suspendidas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Bloquear Cuenta de usuario';
?>
<div class="usuarios-actividad-create">

    <h1><?= Html::encode('Bloquear cuenta usuario') ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'participantes'=>$participantes,
    ]) ?>

</div>
