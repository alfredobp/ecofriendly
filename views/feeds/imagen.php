<?php

use kartik\widgets\FileInput;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin() ?>
<br>
<br>
<br>
<br>
<?php
echo $form->field($model, 'imagen')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
]);
?>
<button>Enviar</button>

<?php ActiveForm::end() ?>