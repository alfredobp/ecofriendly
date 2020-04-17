<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ecoretos */

$this->title = 'Create Ecoretos';
$this->params['breadcrumbs'][] = ['label' => 'Ecoretos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ecoretos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
