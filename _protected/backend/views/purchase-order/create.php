<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseOrder */

$this->title = Yii::t('backend', 'Create Purchase Order');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Purchase Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'po_status_list' => $po_status_list,
    ]) ?>

</div>
