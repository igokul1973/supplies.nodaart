<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[ProductPicture]].
 *
 * @see ProductPicture
 */
class ProductPictureQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ProductPicture[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProductPicture|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}