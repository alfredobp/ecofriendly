<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsuariosActividad */

$this->title = 'Update Usuarios Actividad: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Actualizar suspensión de cuenta', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar suspensión';
?>
<div class="usuarios-actividad-update">

    <h1><?= Html::encode('Actualizar suspensión de cuenta de usuario') ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'participantes'=>$participantes,
    ]) ?>

</div>
