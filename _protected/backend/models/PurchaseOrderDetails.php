<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "purchase_order_details".
 *
 * @property integer $id
 * @property integer $po_id
 * @property integer $product_id
 * @property integer $quantity
 *
 * @property Product $product
 * @property PurchaseOrder $po
 */
class PurchaseOrderDetails extends \yii\db\ActiveRecord
{
    public $import_file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_order_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['po_id', 'product_id', 'quantity'], 'required'],
            [['po_id', 'product_id', 'quantity'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'po_id' => Yii::t('backend', 'Po ID'),
            'product_id' => Yii::t('backend', 'Product ID'),
            'quantity' => Yii::t('backend', 'Quantity'),
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
    public function getProdIdBySku($sku)
    {
        $product_model = Product::find()->where(['sku' => $sku])->one();

        if ($product_model !== null) {
            return $product_model->id;
        }

        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPo()
    {
        return $this->hasOne(PurchaseOrder::className(), ['id' => 'po_id']);
    }

    /**
     * @inheritdoc
     * @return PurchaseOrderDetailsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PurchaseOrderDetailsQuery(get_called_class());
    }
}
