<?php

namespace backend\controllers;

use Yii;
use \PHPExcel;
use \PHPExcel_IOFactory;
use \PHPExcel_Settings;
use \PHPExcel_Style_Fill;
use \PHPExcel_Style_Alignment;
use \PHPExcel_Writer_IWriter;
use \PHPExcel_Worksheet;
use yii\helpers\ArrayHelper;
use backend\models\PurchaseOrderDetails;
use backend\models\PurchaseOrderDetailsSearch;
use backend\models\PurchaseOrder;
use backend\models\PurchaseOrderSearch;
use backend\models\PoStatus;
use backend\models\Product;
use backend\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;
use yii\base\UserException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * PurchaseOrderDetailsController implements the CRUD actions for PurchaseOrderDetails model.
 */
class PurchaseOrderDetailsController extends BackendController
{

    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }*/


    /**
     * Lists all PurchaseOrderDetails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PurchaseOrderDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PurchaseOrderDetails model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PurchaseOrderDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PurchaseOrderDetails();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PurchaseOrderDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Adds new products to PurchaseOrder model.
     * If creation is successful, the browser will display the PO with table of products.
     * @return mixed
     */
    public function actionAddProductsToPo($id)
    {
        if (!$po_model = PurchaseOrder::findOne($id)) {
            throw new \yii\web\NotFoundHttpException();
        }
        $po_detail_model = new PurchaseOrderDetails();
        $product_model = new Product();
        // getting the list of all purchase order statuses
        // for choosing from dropdown Select2 widget
        $po_status_list = ArrayHelper::map(PoStatus::find()->all(), 'id', 'status_name');
        // getting the list of all product SKUs
        $sku_list = ArrayHelper::map(Product::find()->all(), 'id', 'sku');
        // logging the user who creates and updates purchase order
        $po_model->created_by = Yii::$app->user->id;
        $po_model->updated_by = Yii::$app->user->id;

        // getting the list of all products for populating
        // the Select2 dropdown
        $product_list = ArrayHelper::map(Product::find()->all(), 'id', 'name');
        
        $poDetailsSearchModel = new PurchaseOrderDetailsSearch();
        $poDetailsDataProvider = $poDetailsSearchModel->searchById(Yii::$app->request->queryParams, $id);

        // var_dump(Yii::$app->request->post());

        $po_detail_model->po_id = $id;

        if ($po_detail_model->load(Yii::$app->request->post())) {
            $existing_po_model = PurchaseOrderDetails::find()->where(['po_id' => $id, 'product_id' => $po_detail_model->product_id])->one();
            if (!empty($existing_po_model) && $existing_po_model !== null) {
                $existing_po_model->quantity = $existing_po_model->quantity + $po_detail_model->quantity;
                // var_dump(Yii::$app->request->post());
                /*var_dump($po_detail_model->attributes);
                var_dump($existing_po_model->attributes);
                die();*/
                if ($existing_po_model->save()) {
                    return $this->redirect(['add-products-to-po', 'id' => $po_model->id]);
                }
            } else {
                if ($po_detail_model->save()) {
                    return $this->redirect(['add-products-to-po', 'id' => $po_model->id]);
                }
            }

            return $this->render('add-products-to-po', [
                'poDetailsSearchModel' => $poDetailsSearchModel,
                'poDetailsDataProvider' => $poDetailsDataProvider,
                'po_model' => $po_model,
                'po_detail_model' => $po_detail_model,
                'po_status_list' => $po_status_list,
                'product_model' => $product_model,
                'product_list' => $product_list,
                'sku_list' => $sku_list,
            ]);

        } else {
            return $this->render('add-products-to-po', [
                'poDetailsSearchModel' => $poDetailsSearchModel,
                'poDetailsDataProvider' => $poDetailsDataProvider,
                'po_model' => $po_model,
                'po_detail_model' => $po_detail_model,
                'po_status_list' => $po_status_list,
                'product_model' => $product_model,
                'product_list' => $product_list,
                'sku_list' => $sku_list,
            ]);
        }
    }


    /**
     * Adds new products to PurchaseOrder model.
     * If creation is successful, the browser will display the PO with table of products.
     * @return mixed
     */
    public function actionImportProductsToPo($po_id)
    {
        // create temporary model
        $temp_model = new PurchaseOrderDetails();
        // get uploaded file
        $temp_model->import_file = UploadedFile::getInstance($temp_model, 'import_file');

        // let's try identifying and initializing the PHPExcel object
        // in case the uploaded file exists
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
            for ($row = 2; $row  <= $highest_row; $row ++) { 
                // get the data from the row into array
                $row_data = $sheet->rangeToArray('A'.$row.':'.$highest_column.$row, null, true, false);
                // create a new model
                $model = new PurchaseOrderDetails();
                // assign to the model appropriate fields
                $model->po_id = $po_id;
                // next 2 fields we take from the row array
                $model->product_id = $model->getProdIdBySku($row_data[0][0]);
                if (!$model->product_id) {
                    // throw new UserException("<p style='font-size: 1.5em';>Could not get data from the product_id column</p>", 1);
                    $import_errors[$row] = [
                        'product_id' => [
                            'SKU you have entered in the Excel spreadsheet does not exist in the Products database!'
                        ],
                    ];
                }
                $model->quantity = $row_data[0][1];

                if ($model->validate()) {
                    // check if model already exists
                    $existing_po_model = PurchaseOrderDetails::find()->where(['po_id' => $po_id, 'product_id' => $model->product_id])->one();
                    // if it exists, sum up the quantity of the products
                    if (!empty($existing_po_model) && $existing_po_model !== null) {
                        $existing_po_model->quantity = $existing_po_model->quantity + $model->quantity;
                        if ($existing_po_model->save()) {
                            continue;
                        } else {
                            throw new UserException("<p style='font-size: 1.5em';>Could not save the model while importing the sku #" . $row_data[0][0] . ". Please contact the administrator for the help with this error.</p>", 1);
                        }
                    // otherwise save the new PurchaseOrderDetail model
                    } else {
                        $model->save();
                    }
                } else {
                    if (isset($model->errors['product_id'])) {
                        $model->clearErrors('product_id');
                        $model->addError('product_id', 'This SKU does not exist. Check your Excel file for typos!');
                    } 

                    if (isset($model->errors['quantity'])) {
                        $old_error = $model->errors['quantity'];
                        $model->clearErrors('quantity');
                        $model->addError('quantity', $old_error[0] . ' Please check your Excel file for typos!');
                    }

                    $import_errors[$row] = $model->errors;

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
        // return back to the Add Products to PO # form
        return $this->redirect(['add-products-to-po', 'id' => $model->po_id]);
    }

    /**
     * Deletes an existing PurchaseOrderDetails model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $po_id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['add-products-to-po', 'id' => $po_id]);
    }

    /**
     * Finds the PurchaseOrderDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PurchaseOrderDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PurchaseOrderDetails::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
