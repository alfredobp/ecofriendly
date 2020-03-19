<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eco_retos".
 *
 * @property int $id
 * @property int|null $usuario_id
 * @property string|null $descripcion
 * @property int|null $categoria_id
 * @property int|null $puntaje
 *
 * @property TiposEcoRetos $categoria
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
            [['usuario_id', 'categoria_id', 'puntaje'], 'default', 'value' => null],
            [['usuario_id', 'categoria_id', 'puntaje'], 'integer'],
            [['descripcion'], 'string', 'max' => 255],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposEcoRetos::className(), 'targetAttribute' => ['categoria_id' => 'id']],
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
            'descripcion' => 'Descripcion',
            'categoria_id' => 'Categoria ID',
            'puntaje' => 'Puntaje',
        ];
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(TiposEcoRetos::className(), ['id' => 'categoria_id'])->inverseOf('ecoRetos');
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

    public function otorgarReto()
    {
        $puntuacion = Ranking::find()->select('puntuacion')->where(['usuariosid' => Yii::$app->user->identity->id])->one();
       
        return $puntuacion;
    }
}
