<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $nombre
 * @property string $password
 * @property string $auth_key
 * @property string $telefono
 * @property string $poblacion
 */
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    const SCENARIO_CREAR = 'crear';

    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['nombre', 'username', 'apellidos', 'email', 'contrasena'], 'required'],
            [['username'], ['email'], 'unique'],
            [['nombre', 'auth_key', 'direccion'], 'string', 'max' => 255],
            [['contrasena'], 'string', 'max' => 60],
            [['password_repeat'], 'required', 'on' => self::SCENARIO_CREAR],
            // [['password'], 'compare'],
            [['password_repeat'], 'compare', 'compareAttribute' => 'contrasena'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Nombre usuario',
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'contrasena' => 'Contraseña',
            'password_repeat' => 'Repetir contraseña',
            'auth_key' => 'Auth Key',
            'telefono' => 'Teléfono',
            'poblacion' => 'Población',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public static function findPorNombre($nombre)
    {
        return static::findOne(['nombre' => $nombre]);
    }
    /**
     * Metodo que busca si existe el token de activación
     *
     * @param [type] $token_acti es una cadena aleatoria
     * @return null si lo encuentra
     */
    public static function findPorToken($token_acti)
    {

        return static::findOne(['token_act' => $token_acti]);
    }

    public function validatePassword($contrasena)
    {
        return Yii::$app->security->validatePassword($contrasena, $this->contrasena);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            if ($this->scenario === self::SCENARIO_CREAR) {
                $security = Yii::$app->security;
                $this->auth_key = $security->generateRandomString();
                $this->contrasena = $security->generatePasswordHash($this->contrasena);
                $this->token_acti = $security->generateRandomString();
            }
        }

        return true;
    }

    /**
     * Función que comprueba si la cuenta del usuario esta activada
     *
     * @return true
     */
    public function getCuentaActivada()
    {
        return $this->token_acti === null;
    }
}
