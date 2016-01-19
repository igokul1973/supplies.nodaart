<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseOrderDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Purchase Order Details');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-order-details-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('backend', 'Create Purchase Order Details'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'resizableColumns' => true,
        'persistResize' => true,
        'floatHeader' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'po_id',
            [
                'label' => 'SKU',
                'value' => 'product.sku'
            ],
            'quantity',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>

</div>
