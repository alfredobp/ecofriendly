<?php
/*
Conjunto de herramientas que permiten realizar consultas a la base de datos.

*/

namespace app\helper_propio;

use app\models\Comentarios;
use app\models\Ranking;
use kartik\icons\Icon;
use yii\data\ArrayDataProvider;

class Consultas
{

    public static function comentarios($feeds)
    {
        $comentar = $comentarios = Comentarios::find()->where(['comentarios_id' => $feeds]);
        return $comentar;
    }
    public static function muestraComentarios($feeds)
    {
        $comentarios = Comentarios::find()->where(['comentarios_id' => $feeds])->orderBy('created_at DESC')->all();
        return $comentarios;
    }
    public static function muestraRanking()
    {

        $arrModels = Ranking::find()->joinWith('usuarios')->where(['!=', 'rol', 'superadministrador'])->orderBy('puntuacion DESC')->limit(10)->all();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $arrModels,
        ]);

        return Gridpropio::widget([
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'table table-hover table-borderless mb-6', 'style' => 'padding:50px, text-align:justify', 'encode' => false],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'Usuario',
                    'value' => function ($dataProvider) {

                        return  ucfirst($dataProvider->usuarios['nombre']);
                    },
                    'format' => 'raw',

                ],
                [
                    'attribute' => 'puntuacion',
                    'value' => function ($dataProvider) {

                        return $dataProvider->puntuacion .  ' ' . Icon::show('trophy');
                    },
                    'format' => 'raw',

                ],
            ],

        ]);
    }
}
