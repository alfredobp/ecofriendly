<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Actualizar estado';
$this->params['breadcrumbs'][] = $this->title;
?>



<p>Puede modificar sus datos a continuación:</p>
<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'method' => 'post',
    'layout' => 'horizontal',
    'fieldConfig' => [
        'horizontalCssClasses' => ['wrapper' => 'col-sm-5'],
    ],
]); ?>


<?= $form->field($model, 'estado')->textInput(['type' => 'text']) ?>




<div class="form-group">
    <div class="offset-sm-2">
        <?= Html::submitButton('Modificar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>


</div>