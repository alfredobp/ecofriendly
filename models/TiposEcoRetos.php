<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipos_eco_retos".
 *
 * @property int $id
 * @property string|null $tipo
 *
 * @property EcoRetos[] $ecoRetos
 */
class TiposEcoRetos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipos_eco_retos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo'], 'string', 'max' => 255],
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
     * Gets query for [[EcoRetos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEcoRetos()
    {
        return $this->hasMany(EcoRetos::className(), ['categoria_id' => 'id'])->inverseOf('categoria');
    }
}
