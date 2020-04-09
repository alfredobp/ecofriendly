<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin() ?>
<br>
<br>
<br>
<br>
    <?= $form->field($model, 'url_avatar')->fileInput() ?>


    <button>Enviar</button>

<?php ActiveForm::end() ?>