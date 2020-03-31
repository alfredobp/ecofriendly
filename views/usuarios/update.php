<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\models\Feeds;
use app\models\Seguidores;
use app\models\Usuarios;
use yii\base\Model;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Button;
use yii\bootstrap4\ButtonDropdown;
use yii\bootstrap4\Tabs;
use yii\bootstrap\Button as BootstrapButton;
use yii\bootstrap\Tabs as BootstrapTabs;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\grid\GridView;
use yii\helpers\Funcionalidades;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Actualizar';
$this->params['breadcrumbs'][] = $this->title;
?>

<head>

    <style>
        /* Inserto css para controlar los aspectos de esa sección de página */
        fieldset {
            border: 1px solid #ddd !important;
            margin: 0;
            xmin-width: 0;
            padding: 10px;
            position: relative;
            border-radius: 4px;
            background-color: #f5f5f5;
            padding-left: 10px !important;
        }

        legend {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 0px;
            width: 35%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px 5px 5px 10px;
            background-color: #ffffff;
        }
    </style>

</head>

<nav>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Perfil usuario</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Actividad</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Red de contactos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab2" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">Preferencias</a>
        </li>
    </ul>
</nav>
<article class="tab-content" id="myTabContent">
    <section class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <h3>Bienvenido a su perfil personal de ecofriendly: <?= Yii::$app->user->identity->username ?></h3>
        <br>
        <?php $url = Url::to(['usuarios/view', 'id' => Yii::$app->user->identity->id]); ?>
        <?php
        //Comprueba que existe la imagen
        $file = Url::to('@app/web/img/' . Yii::$app->user->identity->id . '.jpg');
        $exists = file_exists($file);
        $imagenUsuario = Url::to('@web/img/' . $model->id . '.jpg');
        $urlImagenBasica = Url::to('@web/img/basica.jpg');

        if (!$exists) {
            $imagenUsuario = $urlImagenBasica;
        }
        ?>

        <div class="col-4"><a href='<?= $url ?>'></a> <img class='img-fluid rounded-circle' src="<?= $imagenUsuario ?>" width=250px alt=" avatar"></div>

        <p>Puede modificar sus datos a continuación:</p>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'method' => 'post',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'horizontalCssClasses' => ['wrapper' => 'col-sm-5'],
            ],
        ]); ?>

        <?= $form->field($model, 'nombre')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'direccion')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'apellidos')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>
        <?= $form->field($model, 'estado')->textInput(['type' => 'text']) ?>
        <!-- <?= $form->field($model, 'contrasena')->passwordInput() ?>
<?= $form->field($model, 'password_repeat')->passwordInput() ?> -->



        <div class="form-group">
            <div class="offset-sm-2">
                <?= Html::submitButton('Modificar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

        <?= Button::widget([

            'label' => 'Eliminar cuenta',

            'options' => ['class' => 'btn-danger grid-button', 'data-confirm' => '¿Estas seguro de borrar tu cuenta de usuario?', 'href' => Url::to(['usuarios/delete', 'id' => $model->id])],

        ]); ?>

        <?= Html::a('<span class="btn-label">Subir imagen avatar</span>', ['imagen', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </section>
    <section class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

        <?php
        $dataProvider = new ActiveDataProvider([
            'query' => Feeds::find()
                ->where(['usuariosid' => 1]),
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['created_at' => SORT_DESC],
        ]);
        $dataProvider->pagination = ['pageSize' => 5];
        $model = new Feeds();
        var_dump($model->contenido);
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'contenido',
                    'value' => function ($model) {
                        return $model->contenido;
                    },
                    'visible' => \Yii::$app->user->can('posts.owner.view'),
                ],
            ],
        ]);

        ?>
    </section>

    <section class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <fieldset class="col-md-12">

            <legend>Seguidores: </legend>
            <?php
            $seguidores = Seguidores::find()->all();
            for ($i = 0; $i < sizeof($seguidores); $i++) {

                echo Html::beginForm(['seguidores/delete', 'id' => $seguidores[$i]->id], 'post');

                echo Html::hiddenInput('id', $seguidores[$i]->id);
                echo Html::submitButton(
                    '<span class="glyphicon glyphicon-minus"></span>',
                    ['class' => 'btn btn-danger btn-sm ml-2'],
                );
                echo Html::endForm();
            }
            ?>
        </fieldset>

        <br>
        <br>
        <div class="clearfix"></div>
        <div class="panel-body">
            <fieldset class="col-md-12">
                <legend>Siguiendo a:</legend>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>Siguien content...</p>
                    </div>
                </div>

            </fieldset>
        </div>
    </section>

    <section class="tab-pane fade" id="contact2" role="tabpanel" aria-labelledby="contact2-tab">
        <br>
        <br>
        <h4> En esta sección puede modificar sus preferencias de estilo de aplicación: </h4>
        <?php
        $model = new Usuarios();
        $form = ActiveForm::begin([
            'action' => ['usuarios/preferencia'],
            'method' => 'post',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'horizontalCssClasses' => ['wrapper' => 'col-sm-5'],
            ],
        ]);
        ?>

        <p>Color de fondo:</p>
        <!-- <?=

                    $form->field($model, 'backgroundColor')->inline()
                        ->radioList(
                            [0 => 'Blanco', 1 => 'Gris', 2 => 'Verde', 3 => 'Morado'],
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
                ?> -->
        <p> Tamaño del texto:</p>
        <?=
            $form->field($model, 'tamañoTexto')->inline()
                ->radioList(
                    [0 => '10px', 1 => '20px', 2 => '25 px', 3 => '30px'],
                    ['uncheckValue' => null],
                    [
                        'item' => function ($index, $label, $name, $checked, $value) {

                            $return = '<label class="modal-radio">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3">';
                            $return .= '<i></i>';
                            $return .= '<span>' . ucwords($label) . '</span>';
                            $return .= '</label>';
                            $return .= "{beginWrapper}\n<div class=\"radio\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>\n{error}\n{endWrapper}\n{hint}";
                            return $return;
                        }
                    ]
                )
                ->label(false);
        ?>
        <p>Color del texto:</p>
        <!-- <?=
                    $form->field($model, 'colorTexto')->label('Tamaño del texto:')->inline()
                        ->radioList(
                            [0 => 'Negro', 1 => 'Gris', 2 => 'Rojo', 3 => 'Amarillo'],
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
                ?> -->
        <p>Fuente del texto:</p>
        <!-- <?=
                    $form->field($model, 'fuenteTexto')->label('Tamaño del texto:')->inline()
                        ->radioList(
                            [0 => 'Arial', 1 => 'Times New Roman', 2 => 'Comics Sans', 3 => 'Verdara'],
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
                ?> -->
        <div class="form-group">
            <?= Html::submitButton('Guardar preferencias', ['class' => 'btn btn-info']) ?>
        </div>

        <?php

        ActiveForm::end();
        ?>

        </body>

        </html>

    </section>

    </div>