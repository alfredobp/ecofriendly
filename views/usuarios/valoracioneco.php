<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;


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
            te daremos una puntuación para proponerte retos que te ayuden a tener una actitud más #ecofriendly.
        </h5>
        <hr>
        <?php $form = ActiveForm::begin(); ?>

        <div class="alert alert-success" role="alert">
            <h4>Desplazamientos</h4>

        </div>

        <p>
            Sus viajes domicilio - trabajo en coche, ¿Son en coche compartido?
        </p>

        <?=
            $form->field($model, 'desplazamiento1')->inline()
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

        <hr size="3px">
        <br>
        <p> Introduzca el número de Km. aproximados que viaja al año en cada modo de transporte:</p>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Coche</th>
                    <th scope="col">Autobús</th>
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
        <br>
        <div class="alert alert-success" role="alert">
            <h4>Compras cotidianas</h4>
        </div>


        ¿Con qué frecuencia haces las compras de artículos de primera necesidad? (alimentos, artículos de limpieza, etc)
        </p>

        <?=
            $form->field($model, 'compra1')->inline()
                ->radioList(
                    [0 => 'Todos los dias', 1 => '6 días a la semana', 8 => '1 dia a la semana', 10 => 'Compro por internet'],
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
        <hr>
        <br>
        </p>
        ¿Dónde adquiere el mayor volumen de estas compras?
        </p>

        <?=
            $form->field($model, 'compra2')->inline()
                ->radioList(
                    [2 => 'Supermercados', 4 => 'Internet', 6 => 'Comercio local', 10 => 'Proximidad'],
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

        <hr>
        <br>
        </p>
        ¿Con qué frecuencia selecciona alimentos certificados como orgánicos o producidos de forma sostenible?
        </p>

        <?=
            $form->field($model, 'compra3')->inline()
                ->radioList(
                    [0 => 'Nunca', 3 => 'Casi Nunca', 8 => 'A veces', 10 => 'La mayoría de las veces'],
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
        <hr>
        <br>
        
        <div class="alert alert-success" role="alert">
            <h4>Estilo de Vida</h4>
        </div>
        <p> ¿Qué tipos de envases son más frecuentes en tu hogar?</p>
        <?=
            $form->field($model, 'estilo1')->inline()
                ->radioList(
                    [0 => 'Botellas/envases de plásticos', 3 => 'Botellas de vidrio', 6 => 'Tupperware reutilizable', 10 => 'Utilizo mi propio envase'],
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
        <hr>
        <br>
        <p> ¿Duración aproximada de una ducha en su casa?</p>
        <?=
            $form->field($model, 'estilo2')->inline()
                ->radioList(
                    [0 => 'No me ducho, me baño', 1 => '>10 min', 4 => '5-10 min', 10 => ' <5 min'],
                    ['uncheckValue' => null],
                    [
                        'item' => function ($index, $label, $name, $checked, $value) {

                            $return = '<label class="modal-radio">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3">';
                            $return .= '<span>' . ucwords($label) . '</span>';
                            $return .= '</label>';

                            return $return;
                        }
                    ]
                )
                ->label(false);
        ?>
        <hr>
        <br>
        <p> ¿Que tipo de edificación define su casa?</p>
        <?=
            $form->field($model, 'estilo3')->inline()
                ->radioList(
                    [0 => 'Vivienda de Lujo', 4 => 'Dúplex con parcela', 7 => 'Dúplex', 10 => 'Bloque de viviendas'],
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
        <div class="divider col-10 border-bottom-3"></div>
        <br>
        <div class="form-group">
            <?= Html::submitButton('Ecocalculo', ['class' => 'btn btn-success btn-lg']) ?>
        </div>






        <?php ActiveForm::end(); ?>



    </div>
</div>