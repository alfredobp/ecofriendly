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

    public static function dimeRanking()
    {
        return   Ranking::find()->joinWith('usuarios')->where(['!=', 'rol', 'superadministrador'])->orderBy('puntuacion DESC')->limit(10)->all();
    }
    public static function puntuacionMedia()
    {
        $puntuacionMedia = Ranking::find()->average('puntuacion');
        return $puntuacionMedia;
    }
    public static function puntuacionUsuario($id)
    {
        return Ranking::find()->select('ranking.*')->joinWith('usuarios', false)->groupBy('ranking.id')->having(['usuariosid' => $id])->one();
    }
    public static function puntosTotales()
    {
        $puntosTotales =  Ranking::find()->sum('puntuacion');
        return $puntosTotales;
    }
    /**
     * Si el usuario no tiene retos asignados, en función de la puntuación
     *  calculada se le otorga unas serie de acciones que corresponden a un reto
     *  [0-30]->categoria1: principante [0-30] ->categoria2: intermedio  [0-60]->categoria3: avanzado
     */
    public static function puntuacionInicial($id)
    {
        $puntuacion = Ranking::find()->select('ranking.*')->joinWith('usuarios', false)->groupBy('ranking.id')->having(['usuariosid' => $id])->one();

        if ($puntuacion['puntuacion'] <= 30) {
            $usuarios = Usuarios::find()->where(['id' => $id])->one();
            $usuarios->categoria_id = 1;
            $usuarios->save();
            return;
        }
        if ($puntuacion['puntuacion'] > 30 && $puntuacion['puntuacion'] < 60) {
            $usuarios = Usuarios::find()->where(['id' => $id])->one();
            $usuarios->categoria_id = 2;
            $usuarios->save();
            return;
        }
        if ($puntuacion['puntuacion']  >= 60) {
            $usuarios = Usuarios::find()->where(['id' => $id])->one();
            $usuarios->categoria_id = 3;
            $usuarios->save();
            return;
        }
    }
    public static function aumentarPuntuacion($puntaje, $usuarios)
    {
        $puntuacion = Ranking::find()->where(['usuariosid' => Yii::$app->user->identity->id])->one();

        if (($puntuacion->puntuacion + $puntaje->puntaje) >= 100) {
            $puntuacion->puntuacion = 100;
            $puntuacion->save();
            Yii::$app->session->setFlash('success', 'Ha conseguido la mayor puntuación posible. Enhorabuena eres totalmente #Ecofriendly.');
            return;
        }
        if ($puntuacion->puntuacion < 30 && $puntuacion->puntuacion + $puntaje->puntaje > 30) {
            $puntuacion->puntuacion = $puntuacion->puntuacion + $puntaje->puntaje;
            $puntuacion->save();
            $usuarios->categoria_id = 2;
            $usuarios->save();
            Yii::$app->session->setFlash('success', 'Enhorabuena, ha subido de categoría en #Ecofriendly.');
            return;
        } elseif ($puntuacion->puntuacion < 60 && $puntuacion->puntuacion + $puntaje->puntaje > 60) {
            $puntuacion->puntuacion = $puntuacion->puntuacion + $puntaje->puntaje;
            $puntuacion->save();
            $usuarios->categoria_id = 3;
            $usuarios->save();
            Yii::$app->session->setFlash('success', 'Enhorabuena, ha subido de categoría en #Ecofriendly.');
            return;
        }
        $puntuacion->puntuacion = $puntuacion->puntuacion + $puntaje->puntaje;
        $puntuacion->save();
        Yii::$app->session->setFlash('success', 'Su Puntuación ha mejorado, sigue así para subir en el ranking.');
        return;
    }
}
