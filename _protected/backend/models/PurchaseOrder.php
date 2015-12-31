<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "purchase_order".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $quantity
 * @property integer $status_id
 * @property string $note
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property PoStatus $status
 * @property Product $product
 */
class PurchaseOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'quantity', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['product_id', 'quantity', 'status_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['note'], 'string']
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
            'quantity' => Yii::t('backend', 'Quantity'),
            'status_id' => Yii::t('backend', 'Status ID'),
            'note' => Yii::t('backend', 'Note'),
            'created_by' => Yii::t('backend', 'Created By'),
            'updated_by' => Yii::t('backend', 'Updated By'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(PoStatus::className(), ['id' => 'status_id']);
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
     * @return PurchaseOrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PurchaseOrderQuery(get_called_class());
    }
}
