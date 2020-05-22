<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feeds_favoritos".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $feed_id
 * @property string $created_at
 *
 * @property Feeds $feed
 * @property Usuarios $usuario
 */
class FeedsFavoritos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feeds_favoritos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'feed_id'], 'required'],
            [['usuario_id', 'feed_id'], 'default', 'value' => null],
            [['usuario_id', 'feed_id'], 'integer'],
            [['created_at'], 'safe'],
            [['feed_id'], 'exist', 'skipOnError' => true, 'targetClass' => Feeds::className(), 'targetAttribute' => ['feed_id' => 'id']],
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
            'feed_id' => 'Feed ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Feed]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeed()
    {
        return $this->hasOne(Feeds::className(), ['id' => 'feed_id']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }
}
