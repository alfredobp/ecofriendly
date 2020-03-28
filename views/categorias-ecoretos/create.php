<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CategoriasEcoretos */

$this->title = 'Create Categorias Ecoretos';
$this->params['breadcrumbs'][] = ['label' => 'Categorias Ecoretos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorias-ecoretos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
