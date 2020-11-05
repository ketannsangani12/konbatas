<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Carts;

/**
 * CartsSearch represents the model behind the search form of `app\models\Carts`.
 */
class CartsSearch extends Carts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'seller_id', 'buyer_id', 'country_id', 'state_id'], 'integer'],
            [['order_no', 'currency', 'address', 'type', 'status', 'order_placed', 'payment_date', 'created_at', 'updated_at'], 'safe'],
            [['latitude', 'longitude', 'subtotal', 'delivery_fee', 'tax', 'total'], 'number'],
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
        $query = Carts::find();

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
            'seller_id' => $this->seller_id,
            'buyer_id' => $this->buyer_id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'country_id' => $this->country_id,
            'state_id' => $this->state_id,
            'subtotal' => $this->subtotal,
            'delivery_fee' => $this->delivery_fee,
            'tax' => $this->tax,
            'total' => $this->total,
            'order_placed' => $this->order_placed,
            'payment_date' => $this->payment_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'order_no', $this->order_no])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
