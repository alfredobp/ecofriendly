<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eco_retos".
 *
 * @property int $id
 * @property int|null $usuario_id
 * @property string $nombrereto
 * @property int|null $categoria_id
 *
 * @property CategoriasEcoretos $categoria
 * @property Usuarios $usuario
 */
class EcoRetos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'eco_retos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'categoria_id'], 'default', 'value' => null],
            [['usuario_id', 'categoria_id'], 'integer'],
            [['nombrereto'], 'required'],
            [['nombrereto'], 'string', 'max' => 255],
            [['categoria_id'], 'unique'],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoriasEcoretos::className(), 'targetAttribute' => ['categoria_id' => 'categoria_id']],
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
            'usuario_id' => 'Usuario id',
            'nombrereto' => 'Nombre del reto',
            'categoria_id' => 'Categoria id',
        ];
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(CategoriasEcoretos::className(), ['categoria_id' => 'categoria_id'])->inverseOf('ecoRetos');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('ecoRetos');
    }
}
