<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ranking */

$this->title = 'Create Ranking';
$this->params['breadcrumbs'][] = ['label' => 'Rankings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ranking-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
