<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Feeds */

$this->title = 'Create Feeds';
$this->params['breadcrumbs'][] = ['label' => 'Feeds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feeds-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
