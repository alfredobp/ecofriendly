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
 * @property Ecoretos $cat
 * @property RetosUsuarios[] $retosUsuarios
 * @property Usuarios[] $usuarios
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
            [['ecoreto.cat_nombre'],'safe'],
            [['titulo', 'descripcion'], 'string', 'max' => 255],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ecoretos::className(), 'targetAttribute' => ['cat_id' => 'categoria_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id Acción',
            'titulo' => 'Titulo',
            'descripcion' => 'Descripcion',
            'cat_id' => 'Categoría id',
            'puntaje' => 'Puntaje',
            'ecoreto.cat_nombre'=>'Categoría de usuario'

        ];
    }

    /**
     * Gets query for [[Cat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEcoreto()
    {
        return $this->hasOne(Ecoretos::className(), ['categoria_id' => 'cat_id'])->inverseOf('accionesRetos');
    }
    /**
     * Gets query for [[RetosUsuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRetosUsuarios()
    {
        return $this->hasMany(RetosUsuarios::className(), ['idreto' => 'id'])->inverseOf('idreto0');
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::className(), ['id' => 'usuario_id'])->viaTable('retos_usuarios', ['idreto' => 'id']);
    }

   
}
