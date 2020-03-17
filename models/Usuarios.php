<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string$username
 * @property string|null$contrasena
 * @property string|null$auth_key
 * @property string $apellidos
 * @property string $email
 * @property string|null $direccion
 * @property string|null $estado
 * @property string|null $fecha_nac
 * @property string|null $token_acti
 * @property string|null $codigo_verificacion
 * @property Bloqueos[] $bloqueos
 * @property Bloqueos[] $bloqueos0
 * @property Comentarios[] $comentarios
 * @property EcoRetos[] $ecoRetos
 * @property Feeds[] $feeds
 * @property MensajesPrivados[] $mensajesPrivados
 * @property MensajesPrivados[] $mensajesPrivados0
 * @property Notificaciones[] $notificaciones
 * @property Ranking[] $rankings
 * @property Seguidores[] $seguidores
 */
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    const SCENARIO_CREAR = 'crear';
    const SCENARIO_MODIFICAR = 'modificar';
    public $password_repeat;
    public $verification_code;
    private $_imagen = null;
    private $_imagenUrl = null;


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
            [['nombre'], 'unique'],
            [['nombre', 'auth_key', 'direccion'], 'string', 'max' => 255],
            [['contrasena'], 'string', 'max' => 60],
            [['password_repeat'], 'required', 'on' => self::SCENARIO_CREAR],
            // [['password'], 'compare'],
            [['password_repeat'], 'compare', 'compareAttribute' => 'contrasena'],
            [
                ['password_repeat'],
                'compare',
                'compareAttribute' => 'contrasena',
                'skipOnEmpty' => true,
                'on' => [self::SCENARIO_MODIFICAR],
            ],
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
            // 'auth_key' => 'Auth Key',
            'telefono' => 'Teléfono',
            'poblacion' => 'Población',
            'email' => 'Email',
            'direccion' => 'Direccion',
            'estado' => 'Estado',
            'fecha_nac' => 'Fecha Nac',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
    }
    //obtiene el id
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


    public function getImagen()
    {
        if ($this->_imagen !== null) {
            return $this->_imagen;
        }

        $this->setImagen(Yii::getAlias('@img/' . $this->id . '.jpg'));
        return $this->_imagen;
    }


    public function setImagen($imagen)
    {
        $this->_imagen = $imagen;
    }

    public static function getImagenUrl()
    {



        return Yii::getAlias('@imgUrl/' . 1 . '.jpg');
    }

    public function setImagenUrl($imagenUrl)
    {
        $this->_imagenUrl = $imagenUrl;
    }
    /**
     * Gets query for [[Bloqueos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBloqueos()
    {
        return $this->hasMany(Bloqueos::className(), ['usuariosid' => 'id'])->inverseOf('usuarios');
    }

    /**
     * Gets query for [[Bloqueos0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBloqueos0()
    {
        return $this->hasMany(Bloqueos::className(), ['bloqueadosid' => 'id'])->inverseOf('bloqueados');
    }

    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentarios::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * Gets query for [[EcoRetos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEcoRetos()
    {
        return $this->hasMany(EcoRetos::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * Gets query for [[Feeds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeeds()
    {
        return $this->hasMany(Feeds::className(), ['usuariosid' => 'id'])->inverseOf('usuarios');
    }

    /**
     * Gets query for [[MensajesPrivados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensajesPrivados()
    {
        return $this->hasMany(MensajesPrivados::className(), ['emisor_id' => 'id'])->inverseOf('emisor');
    }

    /**
     * Gets query for [[MensajesPrivados0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensajesPrivados0()
    {
        return $this->hasMany(MensajesPrivados::className(), ['receptor_id' => 'id'])->inverseOf('receptor');
    }

    /**
     * Gets query for [[Notificaciones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotificaciones()
    {
        return $this->hasMany(Notificaciones::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * Gets query for [[Rankings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRankings()
    {
        return $this->hasMany(Ranking::className(), ['usuariosid' => 'id'])->inverseOf('usuarios');
    }

    /**
     * Gets query for [[Seguidores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeguidores()
    {
        return $this->hasMany(Seguidores::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }
}
