<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_picture".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $file_name
 * @property string $file_path
 * @property string $file_url
 * @property integer $image_type
 * @property string $notes
 *
 * @property Product $product
 * @property ImageType $imageType
 */
class ProductPicture extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_picture';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'file_name', 'file_path', 'file_url'], 'required'],
            [['product_id', 'image_type'], 'integer'],
            [['notes'], 'string'],
            [['file_name'], 'string', 'max' => 50],
            [['file_path', 'file_url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'product_id' => Yii::t('backend', 'Product ID'),
            'file_name' => Yii::t('backend', 'File Name'),
            'file_path' => Yii::t('backend', 'File Path'),
            'file_url' => Yii::t('backend', 'File Url'),
            'image_type' => Yii::t('backend', 'Image Type'),
            'notes' => Yii::t('backend', 'Notes'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageType()
    {
        return $this->hasOne(ImageType::className(), ['id' => 'image_type']);
    }

    /**
     * @inheritdoc
     * @return ProductPictureQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductPictureQuery(get_called_class());
    }
}
