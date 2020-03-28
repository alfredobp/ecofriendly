<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categorias_ecoretos".
 *
 * @property int $id
 * @property string|null $cat_nombre
 * @property int $categoria_id
 *
 * @property AccionesRetos[] $accionesRetos
 * @property EcoRetos $ecoRetos
 */
class CategoriasEcoretos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categorias_ecoretos';
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
            'id' => 'ID',
            'cat_nombre' => 'Cat Nombre',
            'categoria_id' => 'Categoria ID',
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
     * Gets query for [[EcoRetos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEcoRetos()
    {
        return $this->hasOne(EcoRetos::className(), ['categoria_id' => 'categoria_id'])->inverseOf('categoria');
    }
}
