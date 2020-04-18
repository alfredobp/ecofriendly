<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ecoretos".
 *
 * @property int $categoria_id
 * @property int $id
 * @property string|null $cat_nombre
 *
 * @property AccionesRetos[] $accionesRetos
 * @property Usuarios[] $usuarios
 */
class Ecoretos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ecoretos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categoria_id'], 'required'],
            [['categoria_id'], 'default', 'value' => null],
            [['categoria_id'], 'integer'],
            [['cat_nombre'], 'string', 'max' => 255],
            [['categoria_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'categoria_id' => 'Categoria ID',
            'id' => 'ID',
            'cat_nombre' => 'Cat Nombre',
        ];
    }

    /**
     * Gets query for [[AccionesRetos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccionesRetos()
    {
        return $this->hasMany(AccionesRetos::className(), ['cat_id' => 'categoria_id'])->inverseOf('cat');
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::className(), ['categoria_id' => 'categoria_id'])->inverseOf('categoria');
    }
}
