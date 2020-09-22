<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "konbatas_countries".
 *
 * @property int $ID
 * @property string|null $code
 * @property string $name
 * @property string $dial_code
 * @property string|null $currency_name
 * @property string $currency_symbol
 * @property string|null $currency_code
 *
 * @property States[] $states
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'konbatas_countries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code','name', 'currency_name', 'currency_code'], 'required'],
            [['code'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 150],
            [['dial_code'], 'string', 'max' => 20],
            [['currency_name', 'currency_symbol', 'currency_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'dial_code' => 'Dial Code',
            'currency_name' => 'Currency Name',
            'currency_symbol' => 'Currency Symbol',
            'currency_code' => 'Currency Code',
        ];
    }

    /**
     * Gets query for [[States]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStates()
    {
        return $this->hasMany(States::className(), ['country_id' => 'ID']);
    }
}
