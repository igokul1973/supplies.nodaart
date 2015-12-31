<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Supplier]].
 *
 * @see Supplier
 */
class SupplierQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Supplier[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Supplier|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}