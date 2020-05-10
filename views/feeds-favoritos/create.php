<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FeedsFavoritos */

$this->title = 'Create Feeds Favoritos';
$this->params['breadcrumbs'][] = ['label' => 'Feeds Favoritos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feeds-favoritos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
