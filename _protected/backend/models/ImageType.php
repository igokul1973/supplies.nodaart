<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "image_type".
 *
 * @property integer $id
 * @property string $name
 *
 * @property ProductPicture[] $productPictures
 */
class ImageType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'name' => Yii::t('backend', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPictures()
    {
        return $this->hasMany(ProductPicture::className(), ['image_type' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ImageTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ImageTypeQuery(get_called_class());
    }
}
