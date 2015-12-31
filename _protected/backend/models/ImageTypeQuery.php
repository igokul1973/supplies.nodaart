<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[ImageType]].
 *
 * @see ImageType
 */
class ImageTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ImageType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ImageType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}