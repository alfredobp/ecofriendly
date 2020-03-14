<?php

namespace app\models;

use Yii;
use yii\base\Model;

class FormResetPass extends Model
{

    public $email;
    public $contrasena;
    public $password_repeat;
    public $verification_code;
    public $recover;

    public function rules()
    {
        return [
            [['email', 'contrasena', 'password_repeat', 'verification_code', 'recover'], 'required', 'message' => 'Campo requerido'],
            ['email', 'match', 'pattern' => "/^.{5,80}$/", 'message' => 'Mínimo 5 y máximo 80 caracteres'],
            ['email', 'email', 'message' => 'Formato no válido'],
            ['contrasena', 'match', 'pattern' => "/^.{8,16}$/", 'message' => 'Mínimo 6 y máximo 16 caracteres'],
            ['password_repeat', 'compare', 'compareAttribute' => 'contrasena', 'message' => 'Los passwords no coinciden'],
        ];
    }
}
