<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Supplier */

$this->title = Yii::t('backend', 'Create Suppliers');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'country_list' => $country_list
    ]) ?>

</div>
