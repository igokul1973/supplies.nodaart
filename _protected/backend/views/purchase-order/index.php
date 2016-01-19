<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Purchase Orders');

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('backend', 'Create Purchase Order'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            // 'status_id',
            [
                'attribute' => 'status_id',
                'value' => 'status.status_name'
            ],
            'note:ntext',
            // 'created_by',
            [
                'attribute' => 'updated_by',
                'value' => 'updatedBy.profile.fullName',
            ],
            // 'updated_by',
            // 'created_at',
            // 'updated_at',

            [
                'class' => 'kartik\grid\ActionColumn',
                'dropdown' => false,
                'hAlign' => 'center',
                'buttons' => [
                    'update' => function($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['purchase-order-details/add-products-to-po', 'id' => $model->id], ['title' => 'Update', 'data-pjax' => '0']);
                    },
                ]
            ],
        ],
    ]); ?>

</div>
