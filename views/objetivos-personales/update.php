<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ObjetivosPersonales */

$this->title = 'Update Objetivos Personales: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Objetivos Personales', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="objetivos-personales-update">

    <h1><?= Html::encode('Editar objetivo personal') ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
