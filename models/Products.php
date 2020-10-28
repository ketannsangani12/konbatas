<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "konbatas_products".
 *
 * @property int $id
 * @property int|null $category_id
 * @property string|null $brand
 * @property string|null $part_number
 * @property string|null $secondary_part_number
 * @property string|null $description
 * @property float|null $platinum_price
 * @property float|null $gold_price
 * @property float|null $green_price
 * @property float|null $converter_value
 * @property float|null $converter_ceramic_weight
 * @property float|null $platinum_ppt
 * @property float|null $palladium_ppt
 * @property float|null $rhodium_ppt
 * @property string|null $type
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Categories $category
 */
class Products extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'konbatas_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file'],'required','on'=>'import'],
            [['category_id','part_number', 'secondary_part_number','description','platinum_price', 'gold_price', 'green_price', 'converter_value', 'converter_ceramic_weight', 'platinum_ppt', 'palladium_ppt', 'rhodium_ppt'],'required','on'=>'updateproduct'],
            [['file'], 'file',  'extensions' => 'xls, xlsx'],
            [['category_id'], 'integer'],
            [['description', 'status'], 'string'],
            [['platinum_price', 'gold_price', 'green_price', 'converter_value', 'converter_ceramic_weight', 'platinum_ppt', 'palladium_ppt', 'rhodium_ppt'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['brand', 'part_number', 'secondary_part_number', 'type'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category',
            'brand' => 'Brand',
            'part_number' => 'Part Number',
            'secondary_part_number' => 'Secondary Part Number',
            'description' => 'Description',
            'platinum_price' => 'Platinum Price',
            'gold_price' => 'Gold Price',
            'green_price' => 'Green Price',
            'converter_value' => 'Converter Value',
            'converter_ceramic_weight' => 'Converter Ceramic Weight',
            'platinum_ppt' => 'Platinum Ppm',
            'palladium_ppt' => 'Palladium Ppm',
            'rhodium_ppt' => 'Rhodium Ppm',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'file'=>'Excel File'
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    public function getImages()
    {
        return $this->hasMany(Images::className(), ['product_id' => 'id']);
    }


    public function getPictures()
    {
        return $this->hasOne(Images::className(), ['product_id' => 'id'])->orderBy(['id'=>SORT_ASC]);
    }
}
