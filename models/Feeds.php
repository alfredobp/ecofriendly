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
 *
 * @property Comentarios[] $comentarios
 * @property Usuarios $usuarios
 */
class Feeds extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
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
            [['usuariosid', 'contenido'], 'required'],
            [['usuariosid'], 'default', 'value' => null],
            [['usuariosid'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['contenido'], 'string', 'max' => 255],
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
            'updated_at' => 'Updated At',
        ];
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
