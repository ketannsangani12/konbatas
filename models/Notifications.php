<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "konbatas_notifications".
 *
 * @property int $id
 * @property int|null $sender_id
 * @property int|null $receiver_id
 * @property int|null $transaction_id
 * @property string|null $subject
 * @property string|null $text
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Notifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'konbatas_notifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sender_id', 'receiver_id', 'transaction_id'], 'integer'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender_id' => 'Sender ID',
            'receiver_id' => 'Receiver ID',
            'transaction_id' => 'Transaction ID',
            'subject' => 'Subject',
            'text' => 'Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
