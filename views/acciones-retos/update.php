<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AccionesRetos */

$this->title = 'Actualizar Acción Reto: ';
$this->params['breadcrumbs'][] = ['label' => 'Acciones Retos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="acciones-retos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categorias'=>$categorias,
    ]) ?>

</div>
