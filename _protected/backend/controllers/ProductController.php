<?php

namespace backend\controllers;

use Yii;
use yii\db\Transaction;
use yii\helpers\ArrayHelper;
use backend\models\Product;
use backend\models\ProductSearch;
use backend\models\ProductCategory;
use backend\models\ProductPicture;
use backend\models\Color;
use backend\models\Supplier;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\UserException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use \PHPExcel;
use \PHPExcel_IOFactory;
use \PHPExcel_Settings;
use \PHPExcel_Style_Fill;
use \PHPExcel_Style_Alignment;
use \PHPExcel_Writer_IWriter;
use \PHPExcel_Worksheet;


/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends BackendController
{

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Product();
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $prod_cat_list = ArrayHelper::map(ProductCategory::find()->all(), 'id', 'name');
        $supplier_list = ArrayHelper::map(Supplier::find()->all(), 'id', 'name');
        $color_list = ArrayHelper::map(Color::find()->all(), 'id', 'color');


        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'prod_cat_list' => $prod_cat_list,
            'supplier_list' => $supplier_list,
            'color_list' => $color_list,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $product_picture_model = new ProductPicture();
        $supplier_list = ArrayHelper::map(Supplier::find()->all(), 'id', 'name');
        $color_list = ArrayHelper::map(Color::find()->all(), 'id', 'color');
        $prod_category_list = ArrayHelper::map(ProductCategory::find()->all(), 'id', 'name');
        // logging the user who creates and updates Products
        $model->created_by = Yii::$app->user->id;
        $model->updated_by = Yii::$app->user->id;


        if ($model->load(Yii::$app->request->post())) {
            

            $product_pictures_uploaded = false;
            $product_picture_model->pictures = UploadedFile::getInstances($product_picture_model, 'pictures');
            if ($product_picture_model->upload()) {
                $product_pictures_uploaded = true;
            }

            if ($model->save()) {

                // saving models of uploaded images
                if ($product_pictures_uploaded) {
                    $model->unlinkAll('productPictures', true);
                    foreach ($product_picture_model->pictures as $picture) {
                        $product_picture_model = new ProductPicture();
                        $product_picture_model->file_name = $picture->baseName . '.' ./*'_' . $file->contract_id->contr_number . '.' .*/ $picture->extension;
                        $product_picture_model->file_path = Yii::$app->params['uploadPath'];
                        $product_picture_model->file_url = Yii::$app->params['uploadUrl'];
                        $product_picture_model->notes = NULL;
                        if ($product_picture_model->validate()) {
                            $model->link('productPictures', $product_picture_model);
                        } else {
                            echo $product_picture_model->addError('pictures', 'You have already uploaded image file with the name ' . $product_picture_model->file_name);
                            return $this->render('update', [
                                'model' => $model,
                                'product_picture_model' => $product_picture_model,
                                'supplier_list' => $supplier_list,
                                'color_list' => $color_list,
                                'prod_category_list' => $prod_category_list,
                            ]);
                        }                  
                                            }
                }
                // as well as saving models of suppliers
                $suppliers = Yii::$app->request->post()['Product']['suppliers'];
                if (is_array($suppliers) && count($suppliers) > 0) {
                    // go through each related record and add it to the juction table
                    // link() - is the function that maps related records, through junction
                    // table as well.
                    foreach ($suppliers as $supplier) {
                        $supplier = Supplier::findOne($supplier);
                        $model->link('suppliers', $supplier);
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'product_picture_model' => $product_picture_model,
                'supplier_list' => $supplier_list,
                'color_list' => $color_list,
                'prod_category_list' => $prod_category_list,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // getting models of existing pictures if they exist
        $product_picture_models = ProductPicture::findAll(['product_id' => $id]);

        // and getting a new Picture model in case we want to add
        // more pictures
        $product_picture_model = new ProductPicture();

        $supplier_models = Supplier::find()->all();
        $supplier_list = ArrayHelper::map($supplier_models, 'id', 'name');
        $color_list = ArrayHelper::map(Color::find()->all(), 'id', 'color');
        $prod_category_list = ArrayHelper::map(ProductCategory::find()->all(), 'id', 'name');
        // logging the user who updates Products
        $model->updated_by = Yii::$app->user->id;

        // get list of images for usage in Update view
        $image_list = $model->getImageList($product_picture_models);

        if ($model->load(Yii::$app->request->post())) {

            /*var_dump($model->suppliers);
            die(var_dump(Yii::$app->request->post()));*/

            $product_pictures_uploaded = false;
            $product_picture_model->pictures = UploadedFile::getInstances($product_picture_model, 'pictures');
            // var_dump($product_picture_model->pictures);
            foreach ($product_picture_model->pictures as $picture) {
                /*var_dump($picture->hasMethod('getExtension'));
                var_dump($picture->extension);
                var_dump($picture->name);*/
            }
            // die(var_dump($product_picture_model->attributes));

            if ($product_picture_model->upload()) {
                $product_pictures_uploaded = true;
            }

            if ($model->save()) {

                // saving models of uploaded images
                if ($product_pictures_uploaded) {
                    // $model->unlinkAll('productPictures', true);
                    foreach ($product_picture_model->pictures as $picture) {
                        $product_picture_model = new ProductPicture();
                        $product_picture_model->file_name = $picture->baseName . '.' . /*'_' . $file->contract_id->contr_number . '.' .*/ $picture->extension;
                        $product_picture_model->file_path = Yii::$app->params['uploadPath'];
                        $product_picture_model->file_url = Yii::$app->params['uploadUrl'];
                        $product_picture_model->notes = NULL;
                        if ($product_picture_model->validate()) {
                            $model->link('productPictures', $product_picture_model);
                        } else {
                            echo $product_picture_model->addError('pictures', 'You have already uploaded image file with the name ' . $product_picture_model->file_name);
                            return $this->render('update', [
                                'model' => $model,
                                'product_picture_model' => $product_picture_model,
                                'image_list' => $image_list,
                                'supplier_list' => $supplier_list,
                                'color_list' => $color_list,
                                'prod_category_list' => $prod_category_list,
                            ]);
                        }                  
                    }
                }


                $suppliers = Yii::$app->request->post()['Product']['suppliers'];
                if (is_array($suppliers) && count($suppliers) > 0) {
                    // remove all related suppliers from the junction table first
                    $model->unlinkAll('suppliers', true);

                    // then go through each related record and add it to the juction table
                    // link() - is the function that maps related records, through junction
                    // table as well.
                    foreach ($suppliers as $supplier) {
                        $supplier = Supplier::findOne($supplier);
                        $model->link('suppliers', $supplier);
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'product_picture_model' => $product_picture_model,
                'image_list' => $image_list,
                'supplier_list' => $supplier_list,
                'color_list' => $color_list,
                'prod_category_list' => $prod_category_list,
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        $picture_models = $model->productPictures;
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->delete();
            foreach ($picture_models as $picture_model) {
                $picture_model->deleteFile();
            }
            //.... other SQL executions
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            if ($e->errorInfo[0]) {
                throw new UserException('<p style="font-size: 1.5em;">You are trying to delete the product that is used in one of the existing purchase orders - it is NOT possible!</p><p style="font-size: 1.2em;">If it is really imperative to delete this product from database, first delete all purchase orders where this product participates.</p>');
            }
        }

        return $this->redirect(['index']);

    }


    /**
     * Imports new Products.
     * If creation is successful, the browser will redirect back 
     * to the Product index page.
     * @return mixed
     */
    public function actionImportProducts()
    {
        if (Yii::$app->request->post()) {
            // create temporary model
            $temp_model = new Product();
            // get uploaded file
            $temp_model->import_file = UploadedFile::getInstance($temp_model, 'import_file');

            // let's try identifying and initializing the PHPExcel object,
            // if the $import_file has been uploaded
            if ($temp_model->import_file !== null) {
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($temp_model->import_file->tempName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($temp_model->import_file->tempName);
                // if not initialized, throw the Exception
                } catch (Exception $e) {
                    throw $e;
                }
            } else {
                $message = "<p style='font-size: 1.5em;'>You have probably clicked on 'Import products using file' button without uploading the file first :-(.</p>
                    <p style='font-size: 1.3em;'>Please click the <a href='" . Yii::$app->request->referrer . "'>BACK</a> button in the browser and upload the file first.</p>";
                throw new UserException($message);
            }
            // let's get the sheet
            $sheet = $objPHPExcel->getSheet(0);
            // count the highest number of rows and columns that contain data
            $highest_row = $sheet->getHighestRow();
            $highest_column = $sheet->getHighestColumn();

            // initialize an array of errors
            $import_errors = [];

            $transaction = Product::getDb()->beginTransaction();
            try {
                // go through every row, starting from the second one (so that we
                // did not touch the header row and used only data that needs to be imported)
                for ($row = 3; $row  <= $highest_row; $row ++) { 
                    // get the data from the row into array
                    $row_data = $sheet->rangeToArray('A'.$row.':'.$highest_column.$row, null, true, false);
                    // var_dump($row_data);
                    // checking if Excel file's SKU column is not empty
                    if (!empty($row_data[0][0])) {
                        // checking if Product already exists in the database
                        if (Product::find()->oneBySku($row_data[0][0])->exists()) {
                            // if exists, then the Product will be updated
                            $model = Product::find()->oneBySku($row_data[0][0])->one();
                        } else {
                            // otherwise - create new Product model...
                            $model = new Product();
                            // ...and immediately assign new SKU. In the case with
                            // existing model SKU is already assigned
                            $model->sku = $row_data[0][0];
                        }
                    } else {
                        $model = new Product();
                        $model->addError('sku', 'You haven\'t supplied the SKU! Check your Excel file for typos!');
                        $import_errors[$row] = $model->errors;
                        continue;
                    }

                    // assign to the model the rest of appropriate fields from $row_data array
                    $model->product_category_id = $model->getCategoryIdByName($row_data[0][1]);
                    $model->name = $row_data[0][2];
                    $model->size = $row_data[0][3];
                    $model->short_descr = $row_data[0][4];
                    $model->long_descr = $row_data[0][5];
                    $model->notes = $row_data[0][6];
                    $supplier_id = $model->getSupplierIdByName($row_data[0][7]);
                    $model->supplier_sku = $row_data[0][8];
                    $model->supplier_price = $row_data[0][9];
                    $model->wholesale_price = $row_data[0][10];
                    $model->width = $row_data[0][11];
                    $model->height = $row_data[0][12];
                    $model->depth = $row_data[0][13];
                    $model->length = $row_data[0][14];
                    $model->color_id = $model->getColorIdByName($row_data[0][15]);
                    $model->weight = $row_data[0][16];
                    $model->created_by = Yii::$app->user->id;
                    $model->updated_by = Yii::$app->user->id;

 
                    if ($model->validate()) {
                        // save Product
                        $model->save();
                        // as well as save Supplier in related tables
                        if ($supplier_id !== null && $supplier_id !== false) {
                            $supplier = Supplier::findOne($supplier_id);
                            $model->link('suppliers', $supplier);
                        } 
                        // if Supplier does not validate...
                        if($supplier_id === false) {
                            // add error
                            $model->addError('supplier_id', 'The supplier\'s name does not exist! Check your Excel file for typos!');
                            $import_errors[$row] = $model->errors;
                        }
                    } else {
                        if (isset($model->errors['color_id'])) {
                            $model->clearErrors('color_id');
                            $model->addError('color_id', 'This color does not exist! Check your Excel file for typos!');
                        } else if(isset($model->errors['product_category_id'])) {
                            $model->clearErrors('product_category_id');
                            $model->addError('color_id', 'The category\'s name does not exist! Check your Excel file for typos!');
                        }
                        $import_errors[$row] = $model->errors;
                        
                        // var_dump($model->errors);
                        // var_dump($model->attributes);
                    }

                }
                // if there are errors - return page with list of errors
                // (we do not commit any transactions)
                if (!empty($import_errors)) {
                    return $this->render('import-products', [
                            // 'model' => $model,
                            'import_errors' => $import_errors
                        ]
                    );
                } else { 
                    // otherwise - commit all transactions
                    $transaction->commit();
                }
            } catch(\Exception $e) {
                // if any exception during transaction happens - 
                // roll back all transactions and throw the error
                $transaction->rollBack();
                throw $e;
            }

            // die();
            // return back to the Add Products to PO # form
            return $this->redirect(['index']);
        } else {
            return $this->render('import-products');
        }
    }


    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionDownload($file) {
        $path = Yii::$app->params['uploadPath'];
        $file = $path . '' . $file;
        if (file_exists($file)) {
            Yii::$app->response->sendFile($file);
        }
    }
}
