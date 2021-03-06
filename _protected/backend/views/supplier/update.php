<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Supplier */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Supplier',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="supplier-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'country_list' => $country_list,
    ]) ?>

</div>
