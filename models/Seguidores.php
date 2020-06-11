<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seguidores".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $seguidor_id
 * @property string|null $fecha_seguimiento
 * @property Usuarios $usuario
 */
class Seguidores extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seguidores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['usuario_id', 'seguidor_id'], 'required'],
            [['usuario_id', 'seguidor_id'], 'default', 'value' => null],
            [['usuario_id', 'seguidor_id'], 'integer'],
            [['fecha_seguimiento'], 'safe'],
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
        ];
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('seguidores');
    }
    public function getSeguidor()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'seguidor_id'])->inverseOf('seguidores0');
    }
    public static function listaSeguidores($id)
    {
        return    Seguidores::find()
            ->joinWith('usuario')
            ->where(['usuario_id' => $id])
            ->andWhere(['!=', 'seguidor_id', $id])
            ->all();
    }
}
