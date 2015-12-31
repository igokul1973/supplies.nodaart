<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "po_status".
 *
 * @property integer $id
 * @property string $status_name
 *
 * @property PurchaseOrder[] $purchaseOrders
 */
class PoStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'po_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_name'], 'required'],
            [['status_name'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'status_name' => Yii::t('backend', 'Status Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::className(), ['status_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return PoStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PoStatusQuery(get_called_class());
    }
}
