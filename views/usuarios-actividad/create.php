<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsuariosActividad */

$this->title = 'Create Usuarios Actividad';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios Actividads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-actividad-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'participantes'=>$participantes,
    ]) ?>

</div>
