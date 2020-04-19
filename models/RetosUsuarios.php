<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "retos_usuarios".
 *
 * @property int $id
 * @property int $idreto
 * @property int $usuario_id
 * @property string $fecha_aceptacion
 * @property string|null $fecha_culminacion
 * @property bool|null $culminado
 *
 * @property AccionesRetos $idreto0
 * @property Usuarios $usuario
 */
class RetosUsuarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'retos_usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idreto', 'usuario_id'], 'required'],
            [['idreto', 'usuario_id'], 'default', 'value' => null],
            [['idreto', 'usuario_id'], 'integer'],
            [['fecha_aceptacion', 'fecha_culminacion'], 'safe'],
            [['culminado'], 'boolean'],
            [['idreto', 'usuario_id'], 'unique', 'targetAttribute' => ['idreto', 'usuario_id']],
            [['idreto'], 'exist', 'skipOnError' => true, 'targetClass' => AccionesRetos::className(), 'targetAttribute' => ['idreto' => 'id']],
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
            'idreto' => 'Idreto',
            'usuario_id' => 'Usuario ID',
            'fecha_aceptacion' => 'Fecha Aceptacion',
            'fecha_culminacion' => 'Fecha Culminacion',
            'culminado' => 'Culminado',
        ];
    }

    /**
     * Gets query for [[Idreto0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdreto0()
    {
        return $this->hasOne(AccionesRetos::className(), ['id' => 'idreto'])->inverseOf('retosUsuarios');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('retosUsuarios');
    }
}
