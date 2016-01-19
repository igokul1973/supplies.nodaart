<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PoStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Purchase Order Statuses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="po-status-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('backend', 'Create PO Status'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'resizableColumns' => true,
        'persistResize' => true,
        'floatHeader' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            [
                'attribute' => 'status_name',
                'format' => 'text',
                'hidden' => false
            ],

            [
                'class' => 'kartik\grid\ActionColumn',
                'dropdown' => false,
                'hAlign' => 'center'
            ],
        ],
    ]); ?>

</div>
