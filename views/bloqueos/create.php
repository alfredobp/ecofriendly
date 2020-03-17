<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Bloqueos */

$this->title = 'Create Bloqueos';
$this->params['breadcrumbs'][] = ['label' => 'Bloqueos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bloqueos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
