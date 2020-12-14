<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tls_devices".
 *
 * @property int $id
 * @property int $user_id
 * @property int $merchant_id
 * @property string $device_token
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Merchants $merchant
 * @property Users $user
 */
class Devices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'konbatas_devices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['device_token', 'user_id'], 'required', 'on' => 'saveuserdevice'],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['device_token'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'device_token' => 'Device Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
