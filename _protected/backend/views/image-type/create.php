<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ImageType */

$this->title = Yii::t('backend', 'Create Image Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Image Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
