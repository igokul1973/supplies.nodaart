<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Supplier */

$this->title = Yii::t('backend', 'Create Supplier');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>