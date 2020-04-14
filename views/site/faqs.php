<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;


?>
<div class="faqs">

    <div class="container">
        <br />
        <br />
        <br />

        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            Esta secciión contiene preguntas e información relacionadas con <strong>#Ecofriendly</strong> y su utilziación. Si no encuentras respuesta a tu pregunta no dudes
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
                        Lorem ipsum dolor sit amet consectetur adipisicing. <strong>PrepBootstrap</strong> Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione saepe esse similique nesciunt repudiandae officia in suscipit placeat explicabo alias voluptas asperiores labore velit, expedita eum ipsam quia ipsum adipisci!
                    </div>
                </div>
            </div>
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-header">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen">Can I submit my own Bootstrap templates or themes?</a>
                    </h4>
                </div>
                <div id="collapseTen" class="panel-collapse collapse">
                    <div class="card-block">
                        A lot of the content of the site has been submitted by the community. Whether it is a commercial element/template/theme
                        or a free one, you are encouraged to contribute. All credits are published along with the resources.
                    </div>
                </div>
            </div>
           
    </div>

    <style>
        .faqHeader {
            font-size: 27px;
            margin: 20px;
        }

        .panel-heading [data-toggle="collapse"]:after {
            font-family: 'Glyphicons Halflings';
            content: "e072";
            /* "play" icon */
            float: right;
            color: #F58723;
            font-size: 18px;
            line-height: 22px;
            /* rotate "play" icon from > (right arrow) to down arrow */
            -webkit-transform: rotate(-90deg);
            -moz-transform: rotate(-90deg);
            -ms-transform: rotate(-90deg);
            -o-transform: rotate(-90deg);
            transform: rotate(-90deg);
        }

        .panel-heading [data-toggle="collapse"].collapsed:after {
            /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
            -webkit-transform: rotate(90deg);
            -moz-transform: rotate(90deg);
            -ms-transform: rotate(90deg);
            -o-transform: rotate(90deg);
            transform: rotate(90deg);
            color: #454444;
        }
    </style>

</div>