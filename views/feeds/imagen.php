<?php


use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;

$this->title = 'Ecofriendly';
$this->params['breadcrumbs'][] = $this->title;
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