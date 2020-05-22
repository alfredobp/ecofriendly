<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsuariosActividad */

$this->title = 'Create Usuarios Actividad';
$this->params['breadcrumbs'][] = ['label' => 'Cuentas suspendidas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Bloquear Cuenta de usuario';
?>
<div class="usuarios-actividad-create">

    <h1><?= Html::encode('Suspender actividad usuario') ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'participantes'=>$participantes,
    ]) ?>

</div>
