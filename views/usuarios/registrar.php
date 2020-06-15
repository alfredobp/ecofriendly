<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegistrarForm */

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\web\View;

$this->registerJs(
    "var prov = document.getElementById('usuarios-provincia');

    var mun = document.getElementById('usuarios-localidad');
    new Pselect().create(prov, mun);",
    View::POS_READY,
);
// $this->title = 'Registrar usuario';
// $this->params['breadcrumbs'][] = $this->title;
//pluguin con lista despegable provincias/municipios
$this->registerJsFile('https://cdn.jsdelivr.net/npm/pselect.js@4.0.1/dist/pselect.min.js', ['depends' => \yii\web\JqueryAsset::className()]);
?>
<div class="register-form mt-3 shadow p-3 mb-5 bg-white">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Introduzca los siguientes datos para registrarse:</p>


    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'layout' => 'horizontal',
        'options' =>   [
            'enctype' => 'multipart/form-data',
            'enableClientValidation' => true,
            'enableAjaxValidation' => false,
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'validateOnType' => false,
            'errorCssClass' => 'has-error',
            'successCssClass' => 'has-success',
            'afterValidate' => 'js:function(form, data, hasError){}'
        ],
        'fieldConfig' => [
            'horizontalCssClasses' => ['wrapper' => 'col-10'],
        ],
    ]); ?>
    <?= $form->field($model, 'username')->textInput(['autofocus' => true], ['class' => 'col-12']) ?>
    <?= $form->field($model, 'nombre')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'apellidos')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'contrasena')->passwordInput() ?>
    <?= $form->field($model, 'password_repeat')->passwordInput() ?>
    <?= $form->field($model, 'direccion')->textInput() ?>

    <?= $form->field($model, 'provincia')->dropDownList(['class' => '']) ?>
    <?= $form->field($model, 'localidad')->dropDownList(['class' => '']) ?>
    <?= $form->field($model, 'fecha_nac')->label('Fecha de nacimiento')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Introduzca su fecha de nacimiento*...', 'class' => 'col-12'],

        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd-M-yyyy',
            'endDate' => '-18Y',
            'startDate'=>'-100Y',
        ]
    ]); ?>
   <small>* Recuerda que la edad mínima para registrate en #ecofriendly es de 18 años.</small>
  
    <div class="form-group">
    
        <div class="offset-sm-2">
            <?= Html::submitButton('Registrar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
