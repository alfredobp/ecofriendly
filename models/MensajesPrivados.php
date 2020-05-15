<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mensajes_privados".
 *
 * @property int $id
 * @property int $emisor_id
 * @property int $receptor_id
 * @property string|null $asunto
 * @property string|null $contenido
 * @property bool|null $seen
 * @property string $created_at
 * @property string|null $visto_dat
 *
 * @property Usuarios $emisor
 * @property Usuarios $receptor
 */
class MensajesPrivados extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mensajes_privados';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['seen'], 'boolean'],
            [['created_at', 'visto_dat'], 'safe'],
            [['asunto', 'contenido'], 'string', 'max' => 255],
            [['emisor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['emisor_id' => 'id']],
            [['receptor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['receptor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'emisor_id' => 'Emisor ID',
            'receptor_id' => 'Receptor ID',
            'asunto' => 'Asunto',
            'contenido' => 'Contenido',
            'seen' => 'Seen',
            'created_at' => 'Created At',
            'visto_dat' => 'Visto Dat',
        ];
    }

    /**
     * Gets query for [[Emisor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmisor()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'emisor_id']);
    }

    /**
     * Gets query for [[Receptor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReceptor()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'receptor_id']);
    }
}
