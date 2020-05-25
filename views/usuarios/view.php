<?php

use app\helper_propio\Auxiliar;
use app\models\Seguidores;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="usuarios-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <div class="col-12 center-block">
        <?php
        $optionsBarraUsuarios = ['class' => ['img-contenedor'], 'style' => ['width' => '160px', 'height' => '160px', 'margin-right' => '2px', 'margin-left' => '2px'], 'href' => 'www.google.es'];

        $seguidor_id = $model->id;



        echo Auxiliar::obtenerImagenUsuario($model->id, $optionsBarraUsuarios);

        ?>

        <p>


        </p>
        <div itemscope itemtype="http://schema.org/Person">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' =>  [

                    // 'id',
                    'username',
                    // 'contrasena',
                    // 'auth_key',
                    [
                        'attribute' => 'Nombre completo',
                        'value' => function ($dataProvider) {
                            return '<span itemprop="name">' . $dataProvider->nombre . ' ' . $dataProvider->apellidos . '</span>';
                        },
                        'format' => 'raw',
                    ],
                    'localidad',
                    'ranking.puntuacion',


                    [
                        'attribute' => 'Categoría',
                        'value' => function ($dataProvider) {
                            if ($dataProvider->categoria==null) {
                                return;
                            }
                            if ($dataProvider->categoria['cat_nombre'] === 'Principiante') {
                                return '<h5><span class="badge badge-danger">' . $dataProvider->categoria['cat_nombre'] . '</span></h5>';
                            } elseif ($dataProvider->categoria['cat_nombre'] === 'Intermedio') {
                                return '<h5><span class="badge badge-warning">' . $dataProvider->categoria['cat_nombre'] . '</span></h5>';
                            } elseif ($dataProvider->categoria['cat_nombre'] === 'Avanzado') {
                                return '<h5><span class="badge badge-success">' . $dataProvider->categoria['cat_nombre'] . '</span></h5>';
                            }
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'Descripción',
                        'value' => function ($dataProvider) {
                            if ($dataProvider->descripcion == null) {

                                return  '-----------';
                            }
                            return '<span itemprop="knows">' . $dataProvider->descripcion  . '</span>';
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'Edad',
                        'value' => function ($dataProvider) {

                            $fecha = time() - strtotime($dataProvider->fecha_nac);

                            $edad = floor($fecha / 31556926);
                            return  '<span itemprop="birthDate">' .  $edad . ' años </span>';
                        },
                        'format' => 'raw',
                    ],
                    // [
                    //     'attribute' => 'Email',
                    //     'value' => function ($dataProvider) {

                    //         return  '<span itemprop="email">' .  $dataProvider->email . '  </span>';
                    //     },
                    //     'format' => 'raw',
                    // ],
                    // 'email:email',
                    // 'direccion',
                    'estado',
                    // 'fecha_nac',
                    // 'token_acti',
                    // 'codigo_verificacion',
                ],
                'options' => ['class' => 'table table table-hover table-md col-12  ']
            ]) ?>
        </div>

        <?php
        $siguiendo = Seguidores::find()
            ->where(['usuario_id' => Yii::$app->user->identity->id])
            ->andWhere(['seguidor_id' => $model->id])
            ->one();


        $model2 = Seguidores::find()->where(['seguidor_id' => $model->id])->one();
        if ($siguiendo != null) {
            echo Html::a('Dejar de seguir a usuario', ['seguidores/delete', 'id' => $model2->id], [
                'class' => 'btn btn-danger',
                'controller' => 'seguidores',
                'data' => [
                    'confirm' => '¿Desea dejar de seguir a este usuario?',
                    'method' => 'post',
                ],
            ]);
            echo '    ';
            echo Html::a('Enviar mensaje', ['mensajes-privados/create', 'receptor_id' => $model2->seguidor_id], [
                'class' => 'btn btn-success ml-5',
                'controller' => 'mensajesPrivados',
                'data' => [

                    'method' => 'post',
                ],
            ]);
        } elseif (Yii::$app->user->identity->rol !== 'superadministrador') {



            echo Html::a(

                'Seguir a este usuario',
                ['site/index'],
                [
                    //función flecha
                    'onclick' => "$.ajax({
    
                        url: '" . Url::to(['seguidores/create']) . "',
                        type: 'POST',
                        data: 'seguidor_id=$model->id',
                         })",
                    'class' => 'btn btn-success'
                ],
                ['class' => 'btn btn-success'],
            );
        }

        ?>

    </div>