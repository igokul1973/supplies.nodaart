<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property integer $id
 * @property string $name
 * @property string $main_email
 * @property string $alt_email
 * @property string $main_phone
 * @property string $mobile_phone
 * @property string $street_1
 * @property string $street_2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $contact_name
 * @property string $notes
 *
 * @property Product[] $products
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'main_phone'], 'required'],
            [['notes'], 'string'],
            [['name', 'city', 'state'], 'string', 'max' => 50],
            [['main_email', 'alt_email', 'contact_name'], 'string', 'max' => 60],
            [['main_phone', 'mobile_phone', 'zip'], 'string', 'max' => 12],
            [['street_1'], 'string', 'max' => 200],
            [['street_2'], 'string', 'max' => 100]
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
            'main_email' => Yii::t('backend', 'Main Email'),
            'alt_email' => Yii::t('backend', 'Alt Email'),
            'main_phone' => Yii::t('backend', 'Main Phone'),
            'mobile_phone' => Yii::t('backend', 'Mobile Phone'),
            'street_1' => Yii::t('backend', 'Street 1'),
            'street_2' => Yii::t('backend', 'Street 2'),
            'city' => Yii::t('backend', 'City'),
            'state' => Yii::t('backend', 'State'),
            'zip' => Yii::t('backend', 'Zip'),
            'contact_name' => Yii::t('backend', 'Contact Name'),
            'notes' => Yii::t('backend', 'Notes'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['supplier_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return SupplierQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SupplierQuery(get_called_class());
    }
}
