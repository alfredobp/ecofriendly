<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="tarea col-6">
    <br>
    <h2><?= Html::encode($model->contenido) ?>
    <!-- <h2><?= Html::encode($model->created_at) ?></h2> -->

    <h6>Publicado: <?= HtmlPurifier::process(Html::encode(Yii::$app->formatter->asRelativeTime($model->created_at))) ?>
</div>