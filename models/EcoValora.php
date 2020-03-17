<?php

namespace app\models;

use Yii;
use yii\base\Model;


class EcoValora extends Model
{
    public $input1;
    public $input2;
    public $input3;
    public $input4;
    public $input5;
    public $input6;
    public $input7;
    public $input8;
    public $input9;
    public $puntuacion;



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['input1'], 'required'],

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
        Yii::$app->session->setFlash('success', ($this->input1*2));
       
    }
    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    // public function calculo($input1)
    // {
    //     if ($this->validate())
    //     {

    //         Yii::$app->session->setFlash('success', 'hola');
    //         return $this->goHome();
    //            };


}
