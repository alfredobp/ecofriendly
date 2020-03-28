<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CategoriasEcoretos */

$this->title = 'Update Categorias Ecoretos: ' . $model->categoria_id;
$this->params['breadcrumbs'][] = ['label' => 'Categorias Ecoretos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->categoria_id, 'url' => ['view', 'id' => $model->categoria_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="categorias-ecoretos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
