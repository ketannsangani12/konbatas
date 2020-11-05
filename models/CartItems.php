<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "konbatas_cart_items".
 *
 * @property int $id
 * @property int|null $cart_id
 * @property int|null $product_id
 * @property int|null $quantity
 * @property float|null $price
 * @property float|null $total_price
 * @property string|null $currency
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Carts $cart
 * @property Products $product
 */
class CartItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'konbatas_cart_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cart_id', 'product_id', 'quantity'], 'integer'],
            [['price', 'total_price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['currency'], 'string', 'max' => 20],
            [['cart_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carts::className(), 'targetAttribute' => ['cart_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cart_id' => 'Cart ID',
            'product_id' => 'Product',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'total_price' => 'Total Price',
            'currency' => 'Currency',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Cart]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCart()
    {
        return $this->hasOne(Carts::className(), ['id' => 'cart_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
}
