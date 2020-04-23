<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RetosUsuarios */

$this->title = 'Update Retos Usuarios: ' . $model->idreto;
$this->params['breadcrumbs'][] = ['label' => 'Retos Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idreto, 'url' => ['view', 'idreto' => $model->idreto, 'usuario_id' => $model->usuario_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="retos-usuarios-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
