<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "konbatas_states".
 *
 * @property int $ID
 * @property string $name
 * @property int $country_id
 * @property string|null $tax
 *
 * @property Countries $country
 */
class States extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'konbatas_states';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'name', 'country_id'], 'required'],
            [['ID', 'country_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['tax'], 'string', 'max' => 50],
            [['ID'], 'unique'],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['country_id' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'name' => 'Name',
            'country_id' => 'Country',
            'tax' => 'Tax',
        ];
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
}
