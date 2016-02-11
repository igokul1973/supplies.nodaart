<?php

namespace backend\models;

use Yii;
use backend\models\ProductCategory;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product".
 *
 * @property object $input_file
 * @property integer $id
 * @property string $sku
 * @property integer $product_category_id
 * @property string $name
 * @property integer $size
 * @property string $short_descr
 * @property string $short_descr
 * @property string $long_descr
 * @property string $notes
 * @property string $supplier_sku
 * @property string $supplier_price
 * @property string $wholesale_price
 * @property integer $width
 * @property integer $height
 * @property integer $depth
 * @property integer $length
 * @property integer $color_id
 * @property integer $weight
 *
 * @property Color $color
 * @property ProductPicture[] $productPictures
 * @property ProductToSupplier[] $productToSuppliers
 * @property PurchaseOrder[] $purchaseOrders
 */
class Product extends \yii\db\ActiveRecord
{

    public $import_file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sku', 'product_category_id', 'name'], 'required'],
            [['long_descr', 'notes'], 'string'],
            [['supplier_price', 'wholesale_price'], 'number'],
            [['size', 'product_category_id', 'width', 'height', 'depth', 'length', 'color_id', 'weight'], 'integer'],
            [['sku', 'supplier_sku'], 'string', 'max' => 12],
            [['name', 'short_descr'], 'string', 'max' => 255],
            [['sku'], 'unique']
        ];
    }

    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'sku' => Yii::t('backend', 'SKU'),
            'product_category_id' => 'Product category',
            'name' => Yii::t('backend', 'Product name'),
            'size' => Yii::t('backend', 'Size'),
            'short_descr' => Yii::t('backend', 'Short Description'),
            'long_descr' => Yii::t('backend', 'Long Description'),
            'notes' => Yii::t('backend', 'Notes'),
            'supplier_sku' => Yii::t('backend', 'Supplier SKU or Product #'),
            'supplier_price' => Yii::t('backend', 'Supplier Price'),
            'suppliers' => Yii::t('backend', 'Suppliers'),
            'wholesale_price' => Yii::t('backend', 'Wholesale Price'),
            'width' => Yii::t('backend', 'Width'),
            'height' => Yii::t('backend', 'Height'),
            'depth' => Yii::t('backend', 'Depth'),
            'length' => Yii::t('backend', 'Length'),
            'color_id' => Yii::t('backend', 'Color'),
            'weight' => Yii::t('backend', 'Weight'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'product_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryIdByName($cat_name)
    {
        $cat_model = ProductCategory::find()->where(['name' => $cat_name])->one();
        if ($cat_model !== null) {
           return $cat_model->id;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(Color::className(), ['id' => 'color_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColorIdByName($color_name)
    {
        // if $color_name is NOT empty, that is not equal NULL
        if(!is_null($color_name)) {
            // get the color model by color name
            $color_model = Color::find()->where(['color' => $color_name])->one();
            // if found then return color $id property
            if ($color_model !== null) {
               return $color_model->id;
            }
            // else return FALSE, that is $color_id will not be validated
            // because the name was wrong (non-existent in database or
            // written in Excel with typos
            return false;
        }
        // if the $color_name is empty then we return NULL
        // without triggering validation errors
        return null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPictures()
    {
        return $this->hasMany(ProductPicture::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainProductPicture()
    {
        if (!empty($this->productPictures) && $this->productPictures !== null) {
            return $picture_path = $this->productPictures[0]->file_url . $this->productPictures[0]->file_name;
        }
            
        return $picture_path = 'http://placehold.it/150x150';

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductToSuppliers()
    {
        return $this->hasMany(ProductToSupplier::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuppliers()
    {
        return $this->hasMany(Supplier::className(), ['id' => 'supplier_id'])
                    ->via('productToSuppliers');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupplierIdByName($name)
    {
        if ($name !== null) {
            $supplier_model = Supplier::find()->where(['name' => $name])->one();
            if ($supplier_model !== null) {
               return $supplier_model->id;
            }
            return false;
        }
        return null;
    }

    /**
     * List of suppliers for usage in view
     * @return \yii\db\ActiveQuery
     */
    public function getSuppliersList()
    {
        
        $suppliersListArray = [];
        foreach ($this->suppliers as $supplier) {
            array_push($suppliersListArray, $supplier->name);
        }
        return implode(", ", $suppliersListArray);
    }


    public function getImageList ($product_picture_models)
    {
       // здесь мы создаем массив данных существующих подгруженных файлов
       // для использования в видах Update и View
       $imageList = [];
       if (!empty($product_picture_models) || $product_picture_models !== NULL) {
           foreach ($product_picture_models as $existing_picture_models) {
               // var_dump($existingFileModel->attributes);
               $file_path = $existing_picture_models->file_url . $existing_picture_models->file_name;
               $file_name = $existing_picture_models->file_name;
               $pictureArr = [
                   'id' => $existing_picture_models->id,
                   'file_name' => $file_name,
                   'file_path' => $file_path 
               ];
               array_push($imageList, $pictureArr);
           }
       }

       return $imageList;
    }
 
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::className(), ['product_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

}
