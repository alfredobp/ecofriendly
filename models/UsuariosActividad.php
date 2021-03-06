<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios_actividad".
 *
 * @property int $id
 * @property int|null $usuario_id
 * @property string|null $motivo
 * @property string $fecha_suspenso
 *
 * @property Usuarios $usuario
 */
class UsuariosActividad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios_actividad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id'], 'default', 'value' => null],
            [['usuario_id'], 'integer'],
            [['usuario_id'], 'unique','message' => 'El usuario ya ha sido bloqueado.'],
            [['motivo'], 'string'],
            ['motivo', 'required'],
            [['fecha_suspenso'], 'safe'],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'El usuario ya ha sido bloqueado',
            // 'usuario_id' => 'Usuario ID',
            'motivo' => 'Motivo de la suspensión',
            'fecha_suspenso' => 'Fecha Suspensión de la cuenta',
        ];
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
