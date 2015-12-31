<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PoStatus */

$this->title = Yii::t('backend', 'Create Po Status');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Po Statuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="po-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
