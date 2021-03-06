<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[PurchaseOrder]].
 *
 * @see PurchaseOrder
 */
class PurchaseOrderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return PurchaseOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PurchaseOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}