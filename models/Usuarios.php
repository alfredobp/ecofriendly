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
 * @property string|null $provincia
 * @property string|null $localidad
 * @property string|null $direccion
 * @property string|null $estado
 * @property string|null $descripcion
 * @property string|null $fecha_nac
 * @property string|null $ultima_conexion
 * @property string $fecha_alta
 * @property string $rol
 * @property string|null $token_acti
 * @property string|null $codigo_verificacion
 * @property int|null $categoria_id
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
    public $backgroundColor;
    public $colorTexto;
    public $tamañoTexto;
    public $fuenteTexto;



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
            [['nombre', 'username', 'apellidos', 'email', 'contrasena', 'fecha_nac'], 'required'],
            [['fecha_nac'], 'required', 'message' => 'La edad es obligatoria'],
            [['nombre', 'email'], 'unique'],
            [['descripcion'], 'string'],
            ['email', 'match', 'pattern' => '/^.{5,80}$/', 'message' => 'Mínimo 5 y máximo 80 caracteres'],
            ['email', 'email', 'message' => 'Formato de email no válido. Por ejemplo: usuario@gestorcorreo.com'],
            [['nombre', 'auth_key', 'provincia', 'localidad', 'direccion'], 'string', 'max' => 255],
            ['contrasena', 'match', 'pattern' => '/^.{6,16}$/', 'message' => 'Mínimo 6 y máximo 16 caracteres', 'on' => self::SCENARIO_CREAR],
            [['estado'], 'safe'],
            [['rol'], 'string', 'max' => 30],
            [['fecha_nac', 'ultima_conexion', 'fecha_alta'], 'safe'],
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
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ecoretos::className(), 'targetAttribute' => ['categoria_id' => 'categoria_id']],
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
            'provincia' => 'Provincia',
            'localidad' => 'Localidad',
            'email' => 'Email',
            'rol' => 'Rol',
            'direccion' => 'Direccion',
            'estado' => 'Estado',
            'fecha_nac' => 'Fecha Nac',
            'ultima_conexion' => 'Última Conexión',
            'fecha_alta' => 'Fecha creación',
            'categoria_id' => 'Categoria ID',
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

    public static function findPorNombre($username)
    {
        return static::findOne(['username' => $username]);
    }
    /**
     * Método buscar por email, para el acceso a la aplicación mediante el perfil de la red social facebook
     *
     * @param [type] $email
     * @return void
     */
    public static function findPorEmail($email)
    {
        return static::findOne(['email' => $email]);
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


    public static function participantes()
    {
        return static::find()->select('username')->indexBy('id')->column();
    }
    public static function usuariosAmigos()
    {
        $id = Yii::$app->user->identity->id;
        $esSeguidor = Seguidores::find()->where(['seguidor_id' => $id])->andWhere(['usuario_id' => Yii::$app->user->identity->id])->one();
        return static::find()
            ->select('username')
            ->joinWith('seguidores s')
            ->where(['!=', 'usuarios.id', $id])
            ->andWhere(['!=', 'rol', 'superadministrador'])
            ->andWhere($esSeguidor);
         
    }
    public function setEstado($estado)
    {
        $this->_estado = $estado;
    }
    public function getImagen()
    {
        if ($this->_imagen !== null) {
            return $this->_imagen;
        }

        $this->setImagen(Yii::getAlias('@img/' . $this->id . '.jpg'));
        return $this->_imagen;
    }
    // public function actionActivar($id, $token)
    // {
    //     $usuario = $this->findModel($id);
    //     if ($usuario->token === $token) {
    //         $usuario->token = null;
    //         $usuario->save();
    //         Yii::$app->session->setFlash('success', 'Usuario validado. Inicie sesión.');
    //         return $this->redirect(['site/login']);
    //     }
    //     Yii::$app->session->setFlash('error', 'La validación no es correcta.');
    //     return $this->redirect(['site/index']);
    // }

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
     * Gets query for [[Ranking]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRanking()
    {
        return $this->hasOne(Ranking::className(), ['usuariosid' => 'id'])->inverseOf('usuarios');
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
    /**
     * Gets query for [[RetosUsuarios]].
     *
     * @return \yii\db\ActiveQuery
     */

    public function getRetosUsuarios()
    {
        return $this->hasMany(RetosUsuarios::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * Gets query for [[Idretos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdretos()
    {
        return $this->hasMany(AccionesRetos::className(), ['id' => 'idreto'])->viaTable('retos_usuarios', ['usuario_id' => 'id']);
    }

    /**
     * Gets query for [[Seguidores0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeguidores0()
    {
        return $this->hasMany(Seguidores::className(), ['seguidor_id' => 'id'])->inverseOf('seguidor');
    }
    /**
     * Gets query for [[Categoria]].
     * @return \yii\db\ActiveQuery
     *      */
    public function getCategoria()
    {
        return $this->hasOne(Ecoretos::className(), ['categoria_id' => 'categoria_id'])->inverseOf('usuarios');
    }
}
