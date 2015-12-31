<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[PoStatus]].
 *
 * @see PoStatus
 */
class PoStatusQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return PoStatus[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PoStatus|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}