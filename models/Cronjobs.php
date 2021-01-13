<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "konbatas_cronjobs".
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $date
 * @property string|null $created_at
 */
class Cronjobs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'konbatas_cronjobs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'created_at'], 'safe'],
            [['type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'date' => 'Date',
            'created_at' => 'Created At',
        ];
    }
}
