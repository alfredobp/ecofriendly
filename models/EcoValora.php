<?php

namespace app\models;

use Yii;
use yii\base\Model;


class EcoValora extends Model
{
    public $desplazamiento1;
    public $desplazamiento2;
    public $desplazamiento3;
    public $desplazamiento4;
    public $desplazamiento5;
    public $compra1;
    public $compra2;
    public $compra3;
    public $estilo1;
    public $estilo2;
    public $estilo3;
    public $puntuacion;
    public $sumatorio1;
    public $valorBloque1;
    public $valorBloque2;
    public $valorBloque3;
    public $puntuacion2;
    public $user;





    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [[
                'desplazamiento1', 'desplazamiento2', 'desplazamiento3', 'desplazamiento4', 'desplazamiento5'
            ], 'required'],
            [[
                'desplazamiento1', 'desplazamiento2', 'desplazamiento3', 'desplazamiento4', 'desplazamiento5'
            ], 'integer'],

            [[
                'compra1', 'compra2', 'compra3',
            ], 'required'],
            [[
                'compra1', 'compra2', 'compra3'
            ], 'integer'],
            [[
                'estilo1', 'estilo2', 'estilo3',
            ], 'required'],
            [[
                'estilo1', 'estilo2', 'estilo3'
            ], 'integer'],

        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [];
    }

    public function calculo()

    {
        $this->sumatorio1 = $this->desplazamiento2 + $this->desplazamiento3 + $this->desplazamiento4 + $this->desplazamiento5;

        if (($this->desplazamiento2 / $this->sumatorio1) > 0.8) {
            $this->valorBloque1 = 0;
        } elseif (($this->desplazamiento3 / $this->sumatorio1) > 0.40) {
            $this->valorBloque1 = 2;
        } elseif (($this->desplazamiento4 / $this->sumatorio1) > 0.40) {
            $this->valorBloque1 = 1;
        } elseif (($this->desplazamiento5 / $this->sumatorio1) > 0.40) {
            $this->valorBloque1 = 0;
        }
        $this->valorBloque2 = $this->compra1 + $this->compra2 + $this->compra3;

        $this->valorBloque3 = $this->estilo1 + $this->estilo2 + $this->estilo3;

        $this->puntuacion = $this->valorBloque1 + $this->valorBloque2 + $this->valorBloque3;
        $ranking = new Ranking();
        $ranking->usuariosid = Yii::$app->user->identity->id;
        $ranking->puntuacion = $this->puntuacion;
        $ranking->save();
    }
}
