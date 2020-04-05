<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="tarea col-6">
    <br>
    <ul class="list-group">
        <li class="list-group-item-primary list-unstyled"><?= Html::encode($model->contenido) ?></li>

        <li class="list-group-item list-group-item-light">
            <h6>Publicado: <?= HtmlPurifier::process(Html::encode(Yii::$app->formatter->asRelativeTime($model->created_at))) ?>
        </li>

    </ul>
</div>