<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Products;

/**
 * ProductsSearch represents the model behind the search form of `app\models\Products`.
 */
class ProductsSearch extends Products
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['brand', 'part_number', 'secondary_part_number', 'description', 'type', 'status', 'created_at', 'updated_at'], 'safe'],
            [['platinum_price', 'gold_price', 'green_price', 'converter_value', 'converter_ceramic_weight', 'platinum_ppt', 'palladium_ppt', 'rhodium_ppt'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Products::find()->where(['status'=>'Active']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
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
            'category_id' => $this->category_id,
            'platinum_price' => $this->platinum_price,
            'gold_price' => $this->gold_price,
            'green_price' => $this->green_price,
            'converter_value' => $this->converter_value,
            'converter_ceramic_weight' => $this->converter_ceramic_weight,
            'platinum_ppt' => $this->platinum_ppt,
            'palladium_ppt' => $this->palladium_ppt,
            'rhodium_ppt' => $this->rhodium_ppt,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'brand', $this->brand])
            ->andFilterWhere(['like', 'part_number', $this->part_number])
            ->andFilterWhere(['like', 'secondary_part_number', $this->secondary_part_number])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
