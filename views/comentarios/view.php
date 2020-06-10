<?php

use app\helper_propio\Auxiliar;
use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Comentarios */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Comentarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="comentarios-view">

    <h1><?= Html::encode('Ver comentario') ?></h1>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'usuario.nombre',
            'contenido',
            [

                'attribute' => 'Fecha de creación',
                'value' => function ($dataProvider) {
                    return Yii::$app->formatter->asRelativeTime($dataProvider->created_at);
                },

            ]
            // 'updated_at',
            // 'deleted:boolean',
            // 'comentarios_id',
        ],
    ]) ?>
    <?= Auxiliar::volverAtras() ?>
</div>