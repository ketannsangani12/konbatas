<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "konbatas_carts".
 *
 * @property int $id
 * @property string|null $order_no
 * @property int|null $seller_id
 * @property int|null $buyer_id
 * @property string|null $currency
 * @property float|null $latitude
 * @property float|null $longitude
 * @property int|null $country_id
 * @property int|null $state_id
 * @property string|null $address
 * @property float|null $subtotal
 * @property float|null $delivery_fee
 * @property float|null $tax
 * @property float|null $total
 * @property string|null $type
 * @property string|null $status
 * @property string|null $order_placed
 * @property string|null $payment_date
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property CartItems[] $cartItems
 * @property Users $buyer
 * @property Countries $country
 * @property Users $seller
 * @property States $state
 */
class Carts extends \yii\db\ActiveRecord
{
    public $items;
    public $receipt;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'konbatas_carts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['currency','latitude','longitude','country_id','tax','items','delivery_fee'], 'required' ,'on' => 'addcart'],
            [['status'], 'required' ,'on' => 'acceptorreject'],
            [['status','receipt'], 'required' ,'on' => 'deliverorder'],
            [['type','address'], 'required' ,'on' => 'placeorder'],
            [['receipt'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpeg,jpg,png,pdf'],
            [['seller_id', 'buyer_id', 'country_id', 'state_id'], 'integer'],
            [['latitude', 'longitude', 'subtotal', 'delivery_fee', 'tax', 'total'], 'number'],
            [['address', 'type', 'status'], 'string'],
            [['order_placed', 'payment_date', 'created_at', 'updated_at'], 'safe'],
            [['order_no'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 50],
            [['buyer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['buyer_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['country_id' => 'ID']],
            [['seller_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['seller_id' => 'id']],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => States::className(), 'targetAttribute' => ['state_id' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => 'Order No',
            'seller_id' => 'Seller ',
            'buyer_id' => 'Buyer',
            'currency' => 'Currency',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'country_id' => 'Country',
            'state_id' => 'State',
            'address' => 'Address',
            'address_id'=>'Address',
            'subtotal' => 'Subtotal',
            'delivery_fee' => 'Delivery Fee',
            'ceramic_content'=>'Ceramic Content',
            'tax' => 'Tax',
            'total' => 'Total',
            'type' => 'Type',
            'status' => 'Status',
            'items' =>'Items',
            'Document'=>'Payment Receipt',
            'receipt' => 'Receipt',
            'order_placed' => 'Order Placed',
            'payment_date' => 'Payment Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartitems()
    {
        return $this->hasMany(CartItems::className(), ['cart_id' => 'id']);
    }

    /**
     * Gets query for [[Buyer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuyer()
    {
        return $this->hasOne(Users::className(), ['id' => 'buyer_id']);
    }

    /**
     * Gets query for [[Country]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['ID' => 'country_id']);
    }

    public function getPickupaddress()
    {
        return $this->hasOne(Addreses::className(), ['id' => 'address_id']);
    }

    /**
     * Gets query for [[Seller]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeller()
    {
        return $this->hasOne(Users::className(), ['id' => 'seller_id']);
    }

    /**
     * Gets query for [[State]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(States::className(), ['ID' => 'state_id']);
    }
}
