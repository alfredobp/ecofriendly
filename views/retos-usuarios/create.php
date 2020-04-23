<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RetosUsuarios */

$this->title = 'Create Retos Usuarios';
$this->params['breadcrumbs'][] = ['label' => 'Retos Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="retos-usuarios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
