<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Feeds */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Feeds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="feeds-view">

    <h1><?= Html::encode('#hastag: ' . $cadena) ?></h1>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            // 'usuariosid',
            'contenido',
            [
                'label' => 'Ruta Imagen',
                'attribute' => 'imagen',
                'value' => function ($dataProvider) {
                    return $dataProvider->imagen ==null ? '------------' : $dataProvider->imagen;
                },
                'format' => 'raw',
            ],
            'created_at',
            // 'updated_at',
            
        ],
    ]) ?>
  
</div>