<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notificaciones".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $seguidor_id
 * @property bool|null $leido
 * @property int $tipo_notificacion_id
 * @property string|null $created_at
 *
 * @property TiposNotificaciones $tipoNotificacion
 * @property Usuarios $usuario
 */
class Notificaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notificaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'seguidor_id', 'tipo_notificacion_id'], 'required'],
            [['usuario_id', 'seguidor_id', 'tipo_notificacion_id'], 'default', 'value' => null],
            [['usuario_id', 'seguidor_id', 'tipo_notificacion_id'], 'integer'],
            [['leido'], 'boolean'],
            [['created_at'], 'safe'],
            [['tipo_notificacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposNotificaciones::className(), 'targetAttribute' => ['tipo_notificacion_id' => 'id']],
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
            'seguidor_id' => 'Seguidor ID',
            'leido' => 'Leido',
            'tipo_notificacion_id' => 'Tipo Notificacion ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[TipoNotificacion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoNotificacion()
    {
        return $this->hasOne(TiposNotificaciones::className(), ['id' => 'tipo_notificacion_id'])->inverseOf('notificaciones');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('notificaciones');
    }
}
