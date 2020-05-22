<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AccionesRetos */

$this->title = 'Create Acciones Retos';
$this->params['breadcrumbs'][] = ['label' => 'Acciones Retos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acciones-retos-create">

    <h1><?= Html::encode('Crear nueva acción reto') ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categorias'=>$categorias,
    ]) ?>

</div>
