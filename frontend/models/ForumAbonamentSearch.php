<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ForumAbonament;

/**
 * ForumAbonamentSearch represents the model behind the search form of `app\models\ForumAbonament`.
 */
class ForumAbonamentSearch extends ForumAbonament
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ab_subiect_id'], 'integer'],
            [['ab_email'], 'safe'],
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
        $query = ForumAbonament::find();
        $query->andFilterWhere(['ab_email' => \Yii::$app->user->identity->email]);

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
            'ab_subiect_id' => $this->ab_subiect_id,
        ]);

        $query->andFilterWhere(['like', 'ab_email', $this->ab_email]);

        return $dataProvider;
    }
}
