<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use app\helper_propio\Auxiliar;
use kartik\icons\Icon;
use yii\helpers\Html;

$this->title = 'FAQs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faqs">

    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>


        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            Esta sección contiene preguntas e información relacionadas con <strong>#Ecofriendly</strong> y su utilización. Si no encuentras respuesta a tu pregunta no dudes
            en ponerte en contacto con nosotros.
        </div>

        <br />

        <div class="" id="accordion">
            <div class="faqHeader">Cuestiones generales</div>
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-header">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">¿El registro es obligatorio?</a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="card-block">
                        Sí, el registro es obligatorio para participar en <strong>#Ecofriendly</strong>. El proceso es muy simple y no te llevará más
                        de 5 minutos. Recuerda, que tras el registro, te llegará un email de confirmación a la cuenta de correo.
                        Hasta que no hagas la validación tu cuenta no estará activa.
                        <p>Pasos a seguir:</p>
                        <ul>
                            <li>Registrate en la plataforma</li>
                            <li>Activa tu cuenta </li>
                            <li>Accede y consigue tu <strong>ecopuntuación</strong> en el formulario de inicio</li>
                            <li>Observa los retos, cumplelos, aumenta tu puntuación e interactua con otros usuarios.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-header">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen">¿Es totalmente gratuita?</a>
                    </h4>
                </div>
                <div id="collapseTen" class="panel-collapse collapse">
                    <div class="card-block">
                        Sí, no tiene coste alguno ni negociamos con la información de tu perfil. <strong>Ecofriendly</strong> es una iniciativa altruista con el único objetivo
                        de mejorar nuestro impacto sobre el planeta.
                    </div>
                </div>
            </div>
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-header">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseEleven">¿Quien diseña las acciones?</a>
                    </h4>
                </div>
                <div id="collapseEleven" class="panel-collapse collapse">
                    <div class="card-block">
                        Las acciones son planteadas por expertos en la materia, se trata de pequeños gestos que ayuda a cambiar nuestros hábitos de vida.
                    </div>
                </div>
            </div>

            <div class="faqHeader">Metodología</div>
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-header">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">¿Cómo se obtiene la ecopuntuación?</a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="card-block">
                        Tras el registro, el sistema prepara una serie de preguntas al usuario, distribuidas en tres bloques temáticos, otorgando una puntuación de 0 a 100,
                        y asignado retos para mejorar su huella ecológica.
                    </div>
                </div>
            </div>
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-header">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">¿Que es la huella ecológica?</a>
                    </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse">
                    <div class="card-block">
                        El concepto "huella ecológica" surge como un indicador de sostenibilidad que trata de medir el impacto que nuestro modo de vida tiene sobre el entorno.

                        Todas las decisiones que como consumidores tomamos en nuestra vida cotidiana tienen un impacto sobre el planeta. Ese impacto ambiental se expresa como la cantidad de terreno biológicamente productivo que se necesita por persona para producir los recursos necesarios para mantener su estilo de vida.

                    </div>
                </div>
            </div>
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-header">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">¿Puedo interactuar con otros usuarios?</a>
                    </h4>
                </div>
                <div id="collapseFive" class="panel-collapse collapse">
                    <div class="card-block">
                        Sí, <strong>Ecofriendly</strong>, intenta conectar a personas con inquietudes similares y propiciar hábitos de vida más saludables.
                        <br />
                    </div>
                </div>
            </div>


            <div class="faqHeader">Patrocinadores</div>
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-header">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">Quiero patrocinar la plataforma - ¿Cuales
                            son los pasos?</a>
                    </h4>
                </div>
                <div id="collapseFour" class="panel-collapse collapse">
                    <div class="card-block">
                        Para patrocinar <strong> #Ecofriendly</strong> envíe un email a <mail>ecofriendlyrrss@gmail.com.</mail>
                        <br />

                    </div>
                </div>
            </div>
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-header">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">Quiero poner publicidad</a>
                    </h4>
                </div>
                <div id="collapseSeven" class="panel-collapse collapse">
                    <div class="card-block">
                        La publicidad en <strong>Ecofriendly</strong> no esta permitida, y todos nuestros decenas son altruistas con un objetivo común reducir el
                        impacto sobre nuetsro planeta.
                    </div>
                </div>
            </div>
            <div class="alert alert-info alert-info col-6 d-none d-md-block mt-5" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                Si estas preguntas frecuentes no han contestado a tus dudas. Puedes enviarnos un <a href="/index.php?r=site%2Fcontactar">mensaje</a> al <strong>El equipo de #Ecofriendly</strong>
            </div>
            <?php echo Auxiliar::volverAtras() ?>
        </div>
    </div>
    <br>

</div>