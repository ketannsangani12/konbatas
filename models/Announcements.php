<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "konbatas_announcements".
 *
 * @property int $id
 * @property string $type
 * @property string $subject
 * @property string $description
 * @property string|null $datetime
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Announcements extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'konbatas_announcements';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject', 'description'], 'required'],
            [['description'], 'string'],
            [['datetime', 'created_at', 'updated_at'], 'safe'],
            [['type'], 'string', 'max' => 20],
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
            'type' => 'Type',
            'subject' => 'Subject',
            'description' => 'Description',
            'datetime' => 'Datetime',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
