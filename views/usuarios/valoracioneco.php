<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\bootstrap4\ActiveForm */

$this->title = 'Ecofriendly';
$this->params['breadcrumbs'][] = $this->title;

$this->title = 'EcoFriendly'; ?>


<div class="usuarios-form">
    <div class="col6">
        <br>
        <h1> Necesitamos valorar tu ecohuella <span class="badge badge-secondary">Imprescindible</span></h1>
        <hr>
        <h5>
            Para participar en la red social ecofriendly, necesitamos valorar tu huella ecológica. En función de tus hábitos de consumo, desplazamientos, conciencia ambiental,...
            te daremos una puntuación para proponerte retos que te ayuden a tener una actitud más positiva.
        </h5>
        <hr>
        <?php $form = ActiveForm::begin(); ?>

        <div class="alert alert-success" role="alert">
            <h4>Desplazamientos</h4>

        </div>

        <p>
            Sus viajes domicilio - trabajo en coche, ¿son en coche compartido?
        </p>

        <?=
            $form->field($model, 'desplazamiento1')
                ->radioList(
                    [0 => 'Nunca', 1 => 'A veces', 2 => 'Con frecuencia', 3 => 'Siempre'],
                    ['uncheckValue' => null],
                    [
                        'item' => function ($index, $label, $name, $checked, $value) {

                            $return = '<label class="modal-radio">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3">';
                            $return .= '<i></i>';
                            $return .= '<span>' . ucwords($label) . '</span>';
                            $return .= '</label>';

                            return $return;
                        }
                    ]
                )
                ->label(false);
        ?>
        <!-- <?= $form->field($model, 'desplazamiento1')->inline()->radioList(['example1' => 'example1', 'example2' => 'example2'])->label(false) ?> -->
        <hr size="3px">
        <p> Introduzca el número de Km. aproximados que viaja al año en cada modo de transporte:</p>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Coche</th>
                    <th scope="col">Autobus</th>
                    <th scope="col">Tren, metro o tranvía</th>
                    <th scope="col">Vuelos</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td> <?= $form->field($model, 'desplazamiento2')->textInput(['maxlength' => true])->label(false) ?></td>
                    <td> <?= $form->field($model, 'desplazamiento3')->textInput(['maxlength' => true])->label(false) ?></td>
                    <td> <?= $form->field($model, 'desplazamiento4')->textInput(['maxlength' => true])->label(false) ?></td>
                    <td> <?= $form->field($model, 'desplazamiento5')->textInput(['maxlength' => true])->label(false) ?></td>
                </tr>
            </tbody>
        </table>
        <hr>
        <div class="alert alert-success" role="alert">
            <h4>Compras cotidianas</h4>
        </div>

        <hr class="hr-danger" />
        ¿Con qué frecuencia haces las compras de artículos de primera necesidad? (alimentos, artículos de limpieza, etc)
        </p>

        <?=
            $form->field($model, 'compra1')
                ->radioList(
                    [0 => 'Todos los dias', 1 => '3 días a la semana', 2 => '1 dia a la semana', 3 => 'Compro por internet'],
                    ['uncheckValue' => null],
                    [
                        'item' => function ($index, $label, $name, $checked, $value) {

                            $return = '<label class="modal-radio">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3">';
                            $return .= '<i></i>';
                            $return .= '<span>' . ucwords($label) . '</span>';
                            $return .= '</label>';

                            return $return;
                        }
                    ]
                )
                ->label(false);
        ?>

        </p>
        ¿Dónde adquiere el mayor volumen de estas compras?
        </p>

        <?=
            $form->field($model, 'compra2')
                ->radioList(
                    [0 => 'Supermercados', 1 => 'Internet', 2 => 'Comercio local', 3 => 'Proximidad'],
                    
                    ['uncheckValue' => null],
                    [
                        'item' => function ($index, $label, $name, $checked, $value) {

                            $return = '<label class="modal-radio">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3">';
                            $return .= '<i></i>';
                            $return .= '<span>' . ucwords($label) . '</span>';
                            $return .= '</label>';

                            return $return;
                        }
                    ]
                )
                ->label(false);
        ?>


        </p>
        ¿Con qué frecuencia selecciona alimentos certificados como orgánicos o producidos de forma sostenible?
        </p>

        <?=
            $form->field($model, 'compra3')
                ->radioList(
                    [0 => 'Nunca', 1 => 'Casi Nunca', 2 => 'A veces', 3 => 'La mayoría de las veces'],
                    ['uncheckValue' => null],
                    [
                        'item' => function ($index, $label, $name, $checked, $value) {

                            $return = '<label class="modal-radio">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3">';
                            $return .= '<i></i>';
                            $return .= '<span>' . ucwords($label) . '</span>';
                            $return .= '</label>';

                            return $return;
                        }
                    ]
                )
                ->label(false);
        ?>
        <div class="alert alert-success" role="alert">
            <h4>Estilo de Vida</h4>
        </div>
        <hr>
        <p> ¿Qué tipos de envases son más frecuentes en tu hogar?</p>
        <?=
            $form->field($model, 'estilo1')
                ->radioList(
                    [0 => 'Botellas/envases de plásticos', 1 => 'Botellas de vidrio', 2 => 'Tupperware', 3 => 'Utilizo mi propio envase'],
                    ['uncheckValue' => null],
                    [
                        'item' => function ($index, $label, $name, $checked, $value) {

                            $return = '<label class="modal-radio">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3">';
                            $return .= '<i></i>';
                            $return .= '<span>' . ucwords($label) . '</span>';
                            $return .= '</label>';

                            return $return;
                        }
                    ]
                )
                ->label(false);
        ?>
        <p> ¿Duración aproximada de una ducha en su casa?</p>
        <?=
            $form->field($model, 'estilo2')
                ->radioList(
                    [0 => '5 min', 1 => '5-10 min', 2 => '> 10 min', 3 => 'No me ducho, me baño'],
                    ['uncheckValue' => null],
                    [
                        'item' => function ($index, $label, $name, $checked, $value) {

                            $return = '<label class="modal-radio">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3">';
                            $return .= '<i></i>';
                            $return .= '<span>' . ucwords($label) . '</span>';
                            $return .= '</label>';

                            return $return;
                        }
                    ]
                )
                ->label(false);
        ?>

        <p> ¿Que tipo de edificación define su casa?</p>
        <?=
            $form->field($model, 'estilo3')
                ->radioList(
                    [0 => 'Lujo', 1 => 'Duplex con parcela', 2 => 'Duplex', 3 => 'Bloque de viviendas'],
                    ['uncheckValue' => null],
                    [
                        'item' => function ($index, $label, $name, $checked, $value) {

                            $return = '<label class="modal-radio">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3">';
                            $return .= '<i></i>';
                            $return .= '<span>' . ucwords($label) . '</span>';
                            $return .= '</label>';

                            return $return;
                        }
                    ]
                )
                ->label(false);
        ?>

        <div class="form-group">
            <?= Html::submitButton('Ecocalculo', ['class' => 'btn btn-success']) ?>
        </div>






        <?php ActiveForm::end(); ?>



    </div>
</div>