<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AccionesRetos;

/**
 * AccionesRetosSearch represents the model behind the search form of `app\models\AccionesRetos`.
 */
class AccionesRetosSearch extends AccionesRetos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cat_id', 'puntaje'], 'integer'],
            [['titulo', 'descripcion', 'fecha_aceptacion', 'fecha_culminacion'], 'safe'],
            [['aceptado', 'culminado'], 'boolean'],
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
        $query = AccionesRetos::find();

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
            'cat_id' => $this->cat_id,
            'puntaje' => $this->puntaje,
            'fecha_aceptacion' => $this->fecha_aceptacion,
            'fecha_culminacion' => $this->fecha_culminacion,
            'aceptado' => $this->aceptado,
            'culminado' => $this->culminado,
        ]);

        $query->andFilterWhere(['ilike', 'titulo', $this->titulo])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
