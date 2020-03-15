<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'imagen')->fileInput() ?>


    <button>Enviar</button>

<?php ActiveForm::end() ?>