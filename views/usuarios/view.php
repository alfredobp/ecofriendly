<?php

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

        $id = $model->id;
        file_exists(Url::to('@app/web/img/' . $id . '.jpg')) ? $imagenUsuario = Url::to('@web/img/' . $id . '.jpg') : $imagenUsuario = Url::to('@web/img/basica.jpg');


        echo Html::img($imagenUsuario, $optionsBarraUsuarios) . '<h3>' . $model->username . '</h3>';

        ?>

        <p>
            <!-- <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> -->
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' =>  [

                // 'id',
                'username',
                // 'contrasena',
                // 'auth_key',
                'nombre',
                'localidad',
                'apellidos',
                'email:email',
                'direccion',
                'estado',
                'fecha_nac',
                // 'token_acti',
                // 'codigo_verificacion',
            ],
            'options' => ['class' => 'table table-bordered table-hover table-md col-6  ']
        ]) ?>
    </div>
    <?= Html::a('Prueba', ['seguidores/create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    <?= Html::button('Añadir como amigo', ['value' => Url::to('http://localhost:8080/index.php?r=seguidores%2Fcreate&id=' . $model->id), 'method' => 'post', 'class' => 'submit btn-success modalButton2']); ?>
</div>