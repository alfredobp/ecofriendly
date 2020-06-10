<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bloqueos".
 *
 * @property int $id
 * @property int $usuariosid
 * @property int $bloqueadosid
 *
 * @property Usuarios $usuarios
 * @property Usuarios $bloqueados
 */
class Bloqueos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bloqueos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuariosid', 'bloqueadosid'], 'required'],
            ['bloqueadosid', 'safe'],
            [['usuariosid', 'bloqueadosid'], 'default', 'value' => null],
            [['usuariosid', 'bloqueadosid'], 'integer'],
            [['usuariosid'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuariosid' => 'id']],
            [['bloqueadosid'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['bloqueadosid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'usuariosid' => 'Usuarios id',
            'bloqueadosid' => 'Bloqueados id',
        ];
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuariosid'])->inverseOf('bloqueos');
    }

    /**
     * Gets query for [[Bloqueados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBloqueados()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'bloqueadosid'])->inverseOf('bloqueos0');
    }

    public static function estaBloqueado($id)
    {

        return Bloqueos::find()->where(['bloqueadosid' => Yii::$app->user->identity->id])->andWhere(['usuariosid' => $id])->one();
    }
}
