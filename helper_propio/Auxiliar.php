<?php
/*
Conjunto de herramientas que permiten la reutilización de código.

*/

namespace app\helper_propio;

use app\models\Usuarios;
use Yii;
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

    public static function obtenerImagenUsuario($id, $options = ['class' => ['img-contenedor'], 'style' => ['width' => '45px', 'height'=>'65px', 'margin-right' => '12px', 'margin-left' => '12px']])
    {


        $id != null ? $imagenUsuario = Html::img(Yii::getAlias('@uploads') . '/' . $id, $options) :  $imagenUsuario = Html::img('@web/img/basica.jpg', $options);
        return $imagenUsuario;
    }
    public static function obtenerImagenSeguidor($id, $options)
    {
        $id1 = Usuarios::findOne($id);
        $id1->url_avatar != null ? $imagenUsuario = Html::img(Yii::getAlias('@uploads') . '/' .  $id1->url_avatar, $options) :  $imagenUsuario = Html::img('@web/img/basica.jpg', $options);
        return $imagenUsuario;
    }
    public static function obtenerImagenFeed($id, $options = ['class' => ['img-contenedor'], 'style' => ['width' => '150px', 'margin-right' => '12px', 'margin-left' => '12px', 'border-radius' => '30px']])
    {
        $id != null ? $imagenFeed = Html::img(Yii::getAlias('@uploads') . '/' . $id, $options) : $imagenFeed = '';
        return $imagenFeed;
    }
}
