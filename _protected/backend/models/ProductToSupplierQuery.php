<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[ProductToSupplier]].
 *
 * @see ProductToSupplier
 */
class ProductToSupplierQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ProductToSupplier[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProductToSupplier|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}