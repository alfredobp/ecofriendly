<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RetosUsuarios;

/**
 * RetosUsuariosSearch represents the model behind the search form of `app\models\RetosUsuarios`.
 */
class RetosUsuariosSearch extends RetosUsuarios
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idreto', 'usuario_id'], 'integer'],
            [['fecha_aceptacion', 'fecha_culminacion'], 'safe'],
            [['culminado'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = RetosUsuarios::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'idreto' => $this->idreto,
            'usuario_id' => $this->usuario_id,
            'fecha_aceptacion' => $this->fecha_aceptacion,
            'fecha_culminacion' => $this->fecha_culminacion,
            'culminado' => $this->culminado,
        ]);

        return $dataProvider;
    }
}
