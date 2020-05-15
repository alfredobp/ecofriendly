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

        <?= DetailView::widget([
            'model' => $model,
            'attributes' =>  [

                // 'id',
                'username',
                // 'contrasena',
                // 'auth_key',
                'nombre',
                'apellidos',
                'localidad',
                'descripcion',
                // 'email:email',
                // 'direccion',
                'estado',
                'fecha_nac',
                // 'token_acti',
                // 'codigo_verificacion',
            ],
            'options' => ['class' => 'table table table-hover table-md col-10  ']
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
        echo '<br>';
        echo Html::a('Enviar mensaje', ['mensajes-privados/create', 'receptor_id' => $model2->seguidor_id], [
            'class' => 'btn btn-success',
            'controller' => 'mensajesPrivados',
            'data' => [
                
                'method' => 'post',
            ],
        ]);
    } else

        echo Html::a(

            'Añadir como amigo',
            ['site/index'],
            [
                'onclick' => "$.ajax({

                        url: '" . Url::to(['seguidores/create']) . "',
                        type: 'POST',
                        data: 'seguidor_id=$model->id',
                         })",
                'class' => 'btn btn-success'
            ],
            ['class' => 'btn btn-success'],
        );
    ?>

</div>