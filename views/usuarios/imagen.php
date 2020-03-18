<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin() ?>
<br>
<br>
<br>
<br>
    <?= $form->field($model, 'imagen')->fileInput() ?>


    <button>Enviar</button>

<?php ActiveForm::end() ?>