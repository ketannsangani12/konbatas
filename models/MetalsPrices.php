<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "konbatas_metals_prices".
 *
 * @property int $id
 * @property float|null $platinum_price
 * @property float|null $palladium_price
 * @property float|null $rhodium_price
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class MetalsPrices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'konbatas_metals_prices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['platinum_price', 'palladium_price', 'rhodium_price'], 'required'],
            [['platinum_price', 'palladium_price', 'rhodium_price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'platinum_price' => 'Platinum Price',
            'palladium_price' => 'Palladium Price',
            'rhodium_price' => 'Rhodium Price',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
