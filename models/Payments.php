<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "konbatas_payments".
 *
 * @property int $id
 * @property int|null $user_id
 * @property float|null $amount
 * @property string|null $type
 * @property string|null $status
 * @property string|null $response
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Payments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'konbatas_payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount','status','type'], 'required', 'on' => 'payment'],
            [['user_id'], 'integer'],
            [['amount'], 'number'],
            [['status', 'response'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['type'], 'string', 'max' => 20],
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
            'amount' => 'Amount',
            'type' => 'Type',
            'status' => 'Status',
            'response' => 'Response',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
