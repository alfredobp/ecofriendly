<?php

namespace app\helper_propio;

use app\models\Usuarios;
use Yii;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\Dialog;

class Gridpropio extends GridView
{
    public $layout = "\n{items}\n{pager}";
}
