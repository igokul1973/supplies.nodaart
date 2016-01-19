<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[PurchaseOrderDetails]].
 *
 * @see PurchaseOrderDetails
 */
class PurchaseOrderDetailsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return PurchaseOrderDetails[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PurchaseOrderDetails|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}