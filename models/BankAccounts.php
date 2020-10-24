<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "konbatas_bank_accounts".
 *
 * @property int $id
 * @property int $user_id
 * @property string $account_number
 * @property string $account_name
 * @property string $bank_name
 * @property string $swift_code
 * @property string $document_image
 * @property string $address
 * @property string $suburb
 * @property string $city
 * @property string $state
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $user
 */
class BankAccounts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'konbatas_bank_accounts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['account_number','account_name','bank_name','swift_code','address','suburb','city','state'], 'required' ,'on' => 'addbankaccount'],
            [['account_number'], 'unique','on'=>'addbankaccount'],
            [['user_id','account_number','account_name','bank_name','swift_code','document_image','address','suburb','city','state'], 'required'],
            [['user_id'], 'integer'],
            [['document_image'],'file'],
            [['created_at', 'updated_at'], 'safe'],
            [['account_number'], 'string', 'max' => 51],
            [['account_name', 'bank_name', 'swift_code', 'document_image', 'address', 'suburb', 'city', 'state'], 'string', 'max' => 255],
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
            'account_number' => 'Account Number',
            'account_name' => 'Account Name',
            'bank_name' => 'Bank Name',
            'swift_code' => 'Swift Code',
            'document_image' => 'Document Image',
            'address' => 'Address',
            'suburb' => 'Suburb',
            'city' => 'City',
            'state' => 'State',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
