<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Postare;

/**
 * PostareSearch represents the model behind the search form of `app\models\Postare`.
 */
class PostareSearch extends Postare
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'subiect_id', 'creat_de'], 'integer'],
            [['continut', 'data_creare'], 'safe'],
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
        $query = Postare::find();

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
            'subiect_id' => $this->subiect_id,
            'data_creare' => $this->data_creare,
            'creat_de' => $this->creat_de,
        ]);

        $query->andFilterWhere(['like', 'continut', $this->continut]);

        return $dataProvider;
    }
}
