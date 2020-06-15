<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notificaciones".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $seguidor_id
 * @property bool|null $leido
 * @property int $tipo_notificacion_id
 * @property string $created_at
 * @property int|null $id_evento
 *
 * @property TiposNotificaciones $tipoNotificacion
 * @property Usuarios $usuario
 */
class Notificaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notificaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'seguidor_id', 'tipo_notificacion_id'], 'required'],
            [['usuario_id', 'seguidor_id', 'tipo_notificacion_id', 'id_evento'], 'default', 'value' => null],
            [['usuario_id', 'seguidor_id', 'tipo_notificacion_id', 'id_evento'], 'integer'],
            [['leido'], 'boolean'],
            [['created_at'], 'safe'],
            [['tipo_notificacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposNotificaciones::className(), 'targetAttribute' => ['tipo_notificacion_id' => 'id']],
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
            'seguidor_id' => 'Seguidor ID',
            'leido' => 'Leido',
            'tipo_notificacion_id' => 'Tipo Notificacion ID',
            'url_evento' => 'Url Evento',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[TipoNotificacion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoNotificacion()
    {
        return $this->hasOne(TiposNotificaciones::className(), ['id' => 'tipo_notificacion_id']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }
/**
 * Marca una notificación como leida.
 *
 * @param [type] $id
 * @return void
 */
    public static function leerNotificacion($id)
    {
        $notificacionLeida = Notificaciones::find()->where(['id_evento' => $id])->one();
        $notificacionLeida->leido = true;
        return $notificacionLeida;
    }
    /**
     * Crea una nueva notificación cuando se produce alguno de los eventos predefinidos
     *
     * @param [type] $idEvento
     * @param [type] $due
     * @param [type] $tipo
     * @return void
     */
    public static function crearNotificacion($idEvento, $dueño, $tipo)
    {
        $notificacion = new Notificaciones();
        $notificacion->usuario_id = $dueño;
        $notificacion->seguidor_id = Yii::$app->user->identity->id;
        $notificacion->leido = false;
        $notificacion->tipo_notificacion_id = $tipo;
        $notificacion->id_evento = $idEvento;

        return $notificacion;
    }
}
