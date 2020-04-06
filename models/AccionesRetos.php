<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acciones_retos".
 *
 * @property int $id
 * @property string $titulo
 * @property string $descripcion
 * @property int|null $cat_id
 * @property int|null $puntaje
 * @property string|null $fecha_aceptacion
 * @property string|null $fecha_culminacion
 * @property bool|null $aceptado
 * @property bool|null $culminado
 *
 * @property CategoriasEcoretos $cat
 */
class AccionesRetos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acciones_retos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {

        return [
            [['titulo', 'descripcion'], 'required'],
            [['cat_id', 'puntaje'], 'default', 'value' => null],
            [['cat_id', 'puntaje'], 'integer'],
            [['fecha_aceptacion', 'fecha_culminacion'], 'safe'],
            [['aceptado', 'culminado'], 'boolean'],
            [['titulo', 'descripcion'], 'string', 'max' => 255],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoriasEcoretos::className(), 'targetAttribute' => ['cat_id' => 'categoria_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'titulo' => 'Titulo',
            'descripcion' => 'Descripción',
            'cat_id' => 'Categoría id',
            'puntaje' => 'Puntaje',
            'fecha_aceptacion' => 'Fecha Aceptación',
            'fecha_culminacion' => 'Fecha Culminación',
            'aceptado' => 'Aceptado',
            'culminado' => 'Culminado',
        ];
    }

    /**
     * Gets query for [[Cat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(CategoriasEcoretos::className(), ['categoria_id' => 'cat_id'])->inverseOf('accionesRetos');
    }
}
