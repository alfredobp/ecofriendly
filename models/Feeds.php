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
            [['contenido'], 'required'],
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
            'usuariosid' => 'Usuariosid',
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
}
