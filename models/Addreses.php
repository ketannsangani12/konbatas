<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "konbatas_addreses".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $mobile_no
 * @property string|null $address_type
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Addreses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'konbatas_addreses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name','address' ,'city', 'state', 'mobile_no','address_type'], 'required', 'on' => 'add'],
            [['user_id'], 'integer'],
            [['address'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['first_name', 'last_name', 'city', 'state', 'mobile_no','suburb'], 'string', 'max' => 255],
            [['address_type'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'address' => 'Address',
            'city' => 'City',
            'suburb'=>'Suburb',
            'state' => 'State',
            'mobile_no' => 'Mobile No',
            'address_type' => 'Address Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
