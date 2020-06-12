<?php

use app\helper_propio\Auxiliar;
use yii\widgets\ActiveForm;
?>
<div class="col-10 shadow-lg p-3 mb-5 bg-white rounded">


    <?php $form = ActiveForm::begin() ?>
    <br>
    <br>
    <br>
    <br>
    <?= $form->field($model, 'url_avatar')->fileInput() ?>


    <button class="btn btn-success">Enviar</button>

    <?php ActiveForm::end() ?>

    <?= Auxiliar::volverAtras() ?>
</div>