<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MensajesPrivados;

/**
 * MensajesPrivadosSearch represents the model behind the search form of `app\models\MensajesPrivados`.
 */
class MensajesPrivadosSearch extends MensajesPrivados
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'emisor_id', 'receptor_id'], 'integer'],
            [['asunto', 'contenido', 'created_at', 'visto_dat'], 'safe'],
            [['seen'], 'boolean'],
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
        $query = MensajesPrivados::find();

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
            'emisor_id' => $this->emisor_id,
            'receptor_id' => $this->receptor_id,
            'seen' => $this->seen,
            'created_at' => $this->created_at,
            'visto_dat' => $this->visto_dat,
        ]);

        $query->andFilterWhere(['ilike', 'asunto', $this->asunto])
            ->andFilterWhere(['ilike', 'contenido', $this->contenido]);

        return $dataProvider;
    }
}
