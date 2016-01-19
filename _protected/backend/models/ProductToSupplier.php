<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_to_supplier".
 *
 * @property integer $product_id
 * @property integer $supplier_id
 *
 * @property Supplier $supplier
 * @property Product $product
 */
class ProductToSupplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_to_supplier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'supplier_id'], 'required'],
            [['product_id', 'supplier_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('backend', 'Product ID'),
            'supplier_id' => Yii::t('backend', 'Supplier ID'),
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
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @inheritdoc
     * @return ProductToSupplierQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductToSupplierQuery(get_called_class());
    }
}
