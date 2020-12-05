<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "konbatas_cms".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $photo
 * @property string|null $content
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Cms extends \yii\db\ActiveRecord
{
    public $picture;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'konbatas_cms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'picture', 'content'], 'required','on'=>'addcms'],
            [['title', 'content'], 'required','on'=>'updatecms'],
            [['picture'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpeg,jpg,png,pdf'],
            [['title', 'photo', 'content'], 'string'],
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
            'title' => 'Title',
            'photo' => 'Photo',
            'picture'=>'Picture',
            'content' => 'Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
