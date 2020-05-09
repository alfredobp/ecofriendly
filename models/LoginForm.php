<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    //por defecto, se recuerda el recordatorio de acceso 
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }
    public function attributeLabels()
    {
        return [

            'username' => 'Nombre usuario',

            'password' => 'Contraseña',


        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();


            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Nombre de usuario o contraseña incorrecta.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        $usuarios = Usuarios::find()->where(['username' => $this->getUser()])->one();
        $bloqueo = UsuariosActividad::find()->joinWith('usuario u')->where(['username' => $this->getUser()])->one();

        // si el usua
        if ($bloqueo != null) {
            Yii::$app->session->setFlash('error', 'Su cuenta ha sido bloqueada por ' . $bloqueo['motivo'] .
                ' Por Favor, pongáse en contacto con el administrador de la plataforma (admin@ecofriendly.es)');
            return;
        }
        if ($usuarios['token_acti'] == null) {
            Yii::$app->session->setFlash('error', 'Todavía no ha validado su cuenta');
            return;
        }
        if ($this->validate()) {
            $usuarios = Usuarios::find()->where(['username' => $this->getUser()])->one();
            $usuarios->ultima_conexion = date('Y-m-d H:i:s');
            $usuarios->save();
            //se recuerda la sesión del usuario durante un mes.
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Usuarios::findPorNombre($this->username);
        }

        return $this->_user;
    }
}
