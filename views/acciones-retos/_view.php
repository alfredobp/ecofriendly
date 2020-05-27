<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AccionesRetos */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Acciones Retos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="acciones-retos-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'titulo',
            'descripcion',
            'puntaje',

        ],
    ]) ?>
    <p class=" shadow p-1 text-center">

        <!-- <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> -->
        <?php

        echo Html::a('Aceptar Reto', ['retos-usuarios/create', 'idreto' => $model->id, 'usuario_id' => Yii::$app->user->identity->id], [
            'class' => 'btn btn-info btn-lg  mt-3 mb-3 ',
            'data' => [

                'method' => 'post'
            ],
        ]);
        ?>

    </p>
</div>