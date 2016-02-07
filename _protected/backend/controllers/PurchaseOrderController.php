<?php

namespace backend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use backend\models\PurchaseOrder;
use backend\models\PurchaseOrderSearch;
use backend\models\PurchaseOrderDetails;
use backend\models\PurchaseOrderDetailsSearch;
use backend\models\PoStatus;
use backend\models\Product;
use backend\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;

/**
 * PurchaseOrderController implements the CRUD actions for PurchaseOrder model.
 */
class PurchaseOrderController extends BackendController
{

    /**
     * Lists all PurchaseOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PurchaseOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PurchaseOrder model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $poSearchModel = new PurchaseOrderDetailsSearch();
        $poDataProvider = $poSearchModel->searchById(Yii::$app->request->queryParams, $id);

        $excelDataProvider = $poSearchModel->searchForExcel($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'poSearchModel' => $poSearchModel,
            'poDataProvider' => $poDataProvider,
            'excelProvider' => $excelDataProvider,
        ]);
    }

    /**
     * Creates a new PurchaseOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PurchaseOrder();
        // getting the list of all purchase order statuses
        // for choosing from dropdown Select2 widget
        $po_status_list = ArrayHelper::map(PoStatus::find()->all(), 'id', 'status_name');
        // setting default order status - "in progress"
        $model->status_id = 1;
        // logging the user who creates and updates purchase order
        $model->created_by = Yii::$app->user->id;
        $model->updated_by = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/purchase-order-details/add-products-to-po', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'po_status_list' => $po_status_list,
            ]);
        }
    }

    /**
     * Updates an existing PurchaseOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // getting the list of all purchase order statuses
        // for choosing from dropdown Select2 widget
        $po_status_list = ArrayHelper::map(PoStatus::find()->all(), 'id', 'status_name');
        // logging the user who updates purchase order
        $model->updated_by = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'po_status_list' => $po_status_list,
            ]);
        }
    }

    /**
     * Deletes an existing PurchaseOrder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PurchaseOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PurchaseOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PurchaseOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
