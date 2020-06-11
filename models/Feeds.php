<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feeds".
 *
 * @property int $id
 * @property int $usuariosid
 * @property string $contenido
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $imagen
 * @property Comentarios[] $comentarios
 * @property Usuarios $usuarios
 */
class Feeds extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    private $_imagen = null;
    public static $id = 1;

    public static function tableName()
    {
        return 'feeds';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contenido'], 'required', 'message' => 'Debes escribir algo en el feed, antes de compartirlo'],
            [['usuariosid'], 'default', 'value' => 2],
            [['contenido'], 'safe'],
            [['usuariosid'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['contenido', 'imagen'], 'string', 'max' => 255],
            [['usuariosid'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuariosid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            // 'usuariosid' => 'Usuariosid',

            'contenido' => 'Contenido',
            'created_at' => 'Fecha de creación',
            // 'imagen' => 'Imagen',
            'updated_at' => 'Fecha Actualización',
        ];
    }
    public function getImagen()
    {
        if ($this->_imagen !== null) {
            return $this->_imagen;
        }

        $this->setImagen(Yii::getAlias('@img/' . $this->id . 'feed.jpg'));
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
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentarios::className(), ['comentarios_id' => 'id'])->inverseOf('comentarios');
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuariosid'])->inverseOf('feeds');
    }
    public static function feedsPropios()
    {

        return Feeds::find()
            ->where(['usuariosid' => Yii::$app->user->identity->id]);
    }
    public static function publicarFeed($titulo, $usuario_id)
    {
        $feed = new Feeds();
        $feed->contenido = 'Acabo de superar el reto: ' . $titulo . ' Ahora soy mas <strong>#ecofriendly</strong>';
        $feed->usuariosid = $usuario_id;
        $feed->imagen = 'retosuperado.jpg';
        $feed->created_at = date('Y-m-d H:i:s');
        if ($feed->validate()) {
            $feed->save();
        }
    }
    public static function listarFeeds($id)
    {
        $query =  Feeds::find()->select(['usuarios.*', 'seguidores.*', 'feeds.*'])
            ->leftJoin('seguidores', 'seguidores.seguidor_id=feeds.usuariosid')
            ->leftJoin('usuarios', 'usuarios.id=feeds.usuariosid')
            ->Where([
                'seguidores.usuario_id' => $id
            ])
            ->andWhere('feeds.created_at>seguidores.fecha_seguimiento')
            ->orwhere(['feeds.usuariosid' => $id]);
        return $query;
    }
}
