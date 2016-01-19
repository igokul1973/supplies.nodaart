<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseOrderDetails */

$this->title = Yii::t('backend', 'Create Purchase Order Details');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Purchase Order Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-order-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
