<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MensajesPrivados */

$this->title = 'Create Mensajes Privados';
$this->params['breadcrumbs'][] = ['label' => 'Mensajes Privados', 'url' => ['index']];
$this->title='Enviar nuevo mensaje';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mensajes-privados-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'usuarios'=>$usuarios,
    ]) ?>

</div>
