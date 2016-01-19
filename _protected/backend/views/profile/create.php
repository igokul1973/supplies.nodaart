<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Profile */

$this->title = Yii::t('backend', 'Create Profile');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
