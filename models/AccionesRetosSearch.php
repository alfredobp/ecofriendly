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
            [['titulo', 'e.cat_nombre', 'descripcion'], 'safe'],
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
        $query = AccionesRetos::find()
            ->joinWith('ecoreto e');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // add conditions that should always apply here
        $dataProvider->sort->attributes['ecoreto.cat_nombre'] = [
            'asc' => ['e.cat_nombre' => SORT_ASC],
            'desc' => ['e.cat_nombre' => SORT_DESC],
        ];
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
        ]);

        $query->andFilterWhere(['ilike', 'titulo', $this->titulo])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion]);

        $query->andFilterWhere(['ilike', 'ecoreto.cat_nombre', $this->getAttribute('ecoreto.cat_nombre'),]);

        return $dataProvider;
    }
}
