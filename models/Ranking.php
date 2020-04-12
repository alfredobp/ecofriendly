<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ranking".
 *
 * @property int $id
 * @property int|null $puntuacion
 * @property int $usuariosid
 *
 * @property Usuarios $usuarios
 */
class Ranking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ranking';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['puntuacion', 'usuariosid'], 'default', 'value' => null],
            [['puntuacion', 'usuariosid'], 'integer'],
            [['usuariosid'], 'required'],
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
            'puntuacion' => 'Puntuacion',
            'usuariosid' => 'Usuariosid',
        ];
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuariosid'])->inverseOf('ranking');
    }
}
