<?php
/*
Conjunto de herramientas que permiten la reutilización de código.

*/

namespace app\helper_propio;

use app\models\AccionesRetos;
use app\models\Ranking;
use app\models\RankingSearch;
use app\models\Usuarios;
use Yii;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\Dialog;

class Auxiliar
{
    /**
     * Función introduccion
     * Función que devuelve un texto introductorio para la primera vez que el usuario entra en la aplicación.
     * Cuando el usuario acepta se crea una cookie, para que no vuelva a salir el texto de ayuda.
     * @return $js
     */
    public static function introNovatos()
    {
        $urlCookie = Url::toRoute(['site/nuevos',  'respuesta' => 'aceptada'], $schema = true);

        $js =           Dialog::begin([
            'clientOptions' => [
                'modal' => true,
                'autoOpen' => true,
                'title' => 'Información para nuevos usuarios de #ecofriendly',
                'width' => '600px',
                'id' => 'prueba',
                'buttons' => [

                    ['text' => 'Aceptar', 'onclick' => 'window.location="' . $urlCookie . '"'],
                ],
            ],
        ]);
        echo    '<p> Bienvenido a la red social de ecofriendly, donde prodrás mejorar tu huella de carbono y ayudar a cuidar el planeta.

        ¿Por donde empezar?

            <a class="list-group-item list-group-item-action" href="#list-item-1"> 1. Agrega nuevos seguidores a tu red, para ver el contenido.</a>
            <a class="list-group-item list-group-item-action" href="#list-item-2"> 2. Observa los ecoretos que se te ha otorgado y acepta el desafio.</a>
            <a class="list-group-item list-group-item-action" href="#list-item-3"> 3. Comparte cualquier tema relacionado con la sostenibilidad y el planeta.</a>
            <a class="list-group-item list-group-item-action" href="#list-item-4">4. Recuerda que puedes ver tu progreso en cualquier momento desde el sidebar.</a>
        
    </p>
    <p class="card-text"><small class="text-muted"> El equipo de #Ecofriendly </small></p>';
        Dialog::end();
        return $js;
    }

    public static function obtenerImagenUsuario($id, $options = ['class' => ['img-contenedor'], 'style' => ['width' => '25px', 'height' => '35px']])
    {

        $id1 = Usuarios::find()->where(['id' => $id])->one();
        // var_dump($id1['url_avatar']);
        // die;
        $id1['url_avatar'] != null ? $imagenUsuario = Html::img(Yii::getAlias('@uploads') . '/' .  $id1['url_avatar'], $options) :  $imagenUsuario = Html::img('@web/img/basica.jpg', $options);
        return $imagenUsuario;
    }
    public static function obtenerImagenSeguidor($id, $options = ['class' => ['img-contenedor'], 'style' => ['width' => '45px', 'height' => '65px', 'margin-right' => '12px', 'margin-left' => '12px']])
    {
        $id1 = Usuarios::find()->where(['id' => $id])->one();
        $id1['url_avatar'] != null ? $imagenUsuario = Html::img(Yii::getAlias('@uploads') . '/' .  $id1['url_avatar'], $options) :  $imagenUsuario = Html::img('@web/img/basica.jpg', $options);
        return $imagenUsuario;
    }
    public static function obtenerImagenFeed($id, $options = ['class' => ['img-contenedor'], 'style' => ['width' => '150px', 'margin-right' => '12px', 'margin-left' => '12px', 'border-radius' => '30px']])
    {
        $id != null ? $imagenFeed = Html::img(Yii::getAlias('@uploads') . '/' . $id, $options) : $imagenFeed = '';
        return $imagenFeed;
    }


    public static function ventanaModal($title, $id, $size = 'md')
    {
        $ventana =
            Modal::begin([
                'title' => '<h3>' . $title . ':</h3>',
                'id' => 'modal' . $id,
                'size' => 'modal-' . $size,
            ]);
        echo '<div id="modalContent' . $id . '"></div>';

        Modal::end();

        return $ventana;
    }
    public static function puntosRestantes($id, $categoriaId)
    {
        $puntos = Ranking::find()->where(['usuariosid' => $id])->one();

        if ($categoriaId == 1) {
            return 30 - $puntos->puntuacion;
        } elseif ($categoriaId == 2) {
            return 60 - $puntos->puntuacion;
        } elseif ($categoriaId == 3) {
            return 100 - $puntos->puntuacion;
        }
    }
    public static function puntosConseguidos($id)
    {


        return AccionesRetos::find()->joinWith('retosUsuarios r')->where(['r.usuario_id' => $id])->andWhere(['r.culminado' => true])->sum('puntaje');
    }
}
