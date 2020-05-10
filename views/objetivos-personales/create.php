<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ObjetivosPersonales */

// $this->title = 'Create Objetivos Personales';
$this->params['breadcrumbs'][] = ['label' => 'Objetivos Personales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="objetivos-personales-create">

    <h5><?= Html::encode('Añada su objetivo personal:') ?></h5>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
