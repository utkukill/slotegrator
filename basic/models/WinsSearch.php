<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Wins;

/**
 * WinsSearch represents the model behind the search form of `app\models\Wins`.
 */
class WinsSearch extends Wins
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'win_type', 'win_balance_int', 'status'], 'integer'],
            [['win_balance_var'], 'safe'],
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
        $query = Wins::find();

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
            'user_id' => $this->user_id,
            'win_type' => $this->win_type,
            'win_balance_int' => $this->win_balance_int,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'win_balance_var', $this->win_balance_var]);

        return $dataProvider;
    }
}
