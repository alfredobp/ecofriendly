<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipos_notificaciones".
 *
 * @property int $id
 * @property string|null $tipo
 *
 * @property Notificaciones[] $notificaciones
 */
class TiposNotificaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipos_notificaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo'], 'string', 'max' => 255],
            ['tipo', 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo' => 'Tipo',
        ];
    }

    /**
     * Gets query for [[Notificaciones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotificaciones()
    {
        return $this->hasMany(Notificaciones::className(), ['tipo_notificacion_id' => 'id']);
    }
}
