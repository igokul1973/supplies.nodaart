<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $sku
 * @property string $short_descr
 * @property string $long_descr
 * @property string $notes
 * @property string $supplier_sku
 * @property integer $supplier_id
 * @property string $supplier_price
 * @property string $wholesale_price
 * @property integer $width
 * @property integer $height
 * @property integer $depth
 * @property integer $length
 * @property integer $color_id
 * @property integer $weight
 *
 * @property Supplier $supplier
 * @property Color $color
 * @property ProductPicture[] $productPictures
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sku', 'supplier_id'], 'required'],
            [['long_descr', 'notes'], 'string'],
            [['supplier_id', 'width', 'height', 'depth', 'length', 'color_id', 'weight'], 'integer'],
            [['supplier_price', 'wholesale_price'], 'number'],
            [['sku', 'supplier_sku'], 'string', 'max' => 12],
            [['short_descr'], 'string', 'max' => 255],
            [['sku'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'sku' => Yii::t('backend', 'SKU'),
            'short_descr' => Yii::t('backend', 'Short Description'),
            'long_descr' => Yii::t('backend', 'Long Description'),
            'notes' => Yii::t('backend', 'Notes'),
            'supplier_sku' => Yii::t('backend', 'Supplier SKU or Product #'),
            'supplier_id' => Yii::t('backend', 'Supplier ID'),
            'supplier_price' => Yii::t('backend', 'Supplier Price'),
            'wholesale_price' => Yii::t('backend', 'Wholesale Price'),
            'width' => Yii::t('backend', 'Width'),
            'height' => Yii::t('backend', 'Height'),
            'depth' => Yii::t('backend', 'Depth'),
            'length' => Yii::t('backend', 'Length'),
            'color_id' => Yii::t('backend', 'Color ID'),
            'weight' => Yii::t('backend', 'Weight'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(Color::className(), ['id' => 'color_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPictures()
    {
        return $this->hasMany(ProductPicture::className(), ['product_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }
}
