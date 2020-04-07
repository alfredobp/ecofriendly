<?php

namespace app\helper_propio;

use Yii;
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

    public static function obtenerImagen($id)
    {
        file_exists(Url::to('@app/web/img/' . $id . '.jpg')) ?  $imagenUsuario = Url::to('@web/img/' . $id . '.jpg') : $imagenUsuario = Url::to('@web/img/basica.jpg');
        return $imagenUsuario;
    }
    public static function obtenerImagenFeed($id)
    {


        return file_exists(Url::to('@app/web/img/' . $id . 'feed.jpg')) ?   '<img  class=" img-fluid mr-md-3 mb-3 ml-3 mt-1" src="/img/' . $id  . 'feed.jpg" width=auto padding=20px>' :  '';
    }
}
