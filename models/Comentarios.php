<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comentarios".
 *
 * @property int $id
 * @property int $usuario_id
 * @property string $contenido
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property bool|null $deleted
 * @property int|null $comentarios_id
 *
 * @property Feeds $comentarios
 * @property Usuarios $usuario
 */
class Comentarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'contenido'], 'required'],
            [['usuario_id', 'comentarios_id'], 'default', 'value' => null],
            [['usuario_id', 'comentarios_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['deleted'], 'boolean'],
            [['contenido'], 'string', 'max' => 255],
            [['comentarios_id'], 'exist', 'skipOnError' => true, 'targetClass' => Feeds::className(), 'targetAttribute' => ['comentarios_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'contenido' => 'Comentario',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted' => 'Deleted',
            'comentarios_id' => 'Comentarios ID',
        ];
    }

    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasOne(Feeds::className(), ['id' => 'comentarios_id'])->inverseOf('comentarios');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('comentarios');
    }
    /**
     * Obtiene los comentarios asociados a un feed determinado
     *
     * @param [type] $feeds
     * @return void
     */
    public static function obtenerComentarios($feeds)
    {
        return Comentarios::find()->where(['comentarios_id' => $feeds]);
    }
    /**
     * Muestra los comentarios ordenados para la lista despegable.
     *
     * @param [type] $feeds
     * @return void
     */
    public static function muestraComentarios($feeds)
    {
        return Comentarios::find()->where(['comentarios_id' => $feeds])->orderBy('created_at DESC')->all();
    }
}
