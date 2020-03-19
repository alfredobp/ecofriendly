<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EcoRetos */

$this->title = 'Create Eco Retos';
$this->params['breadcrumbs'][] = ['label' => 'Eco Retos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eco-retos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
