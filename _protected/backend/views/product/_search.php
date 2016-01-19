<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <? $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        // 'enableAjaxValidation' => true,
    ]);
    ?>


    <?php /*$form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]);*/ ?>

    <?= $form->field($model, 'sku') ?>


    <?
    // Renders list of all colors
    echo $form->field($model, 'product_category_id')->widget(Select2::classname(), [
        'data' => $prod_cat_list,
        'options' => [
            'placeholder' => 'Choose the category ...',
            'ajax' => true,
            'multiple' => false,
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => false,
        ],
    ]);
    ?>

    <?= $form->field($model, 'name') ?>

    <?
    // Renders list of all colors
    echo $form->field($model, 'color_id')->widget(Select2::classname(), [
        'data' => $color_list,
        'options' => [
            'placeholder' => 'Choose the color ...',
            'ajax' => true,
            'multiple' => false,
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => false,
        ],
    ]);
    ?>

    <?
    // Renders list of all suppliers
    echo $form->field($model, 'suppliers')->widget(Select2::classname(), [
        'data' => $supplier_list,
        'options' => [
            'placeholder' => 'Choose the suppliers ...',
            'ajax' => true,
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => true,
        ],
    ]);
    ?>

    <?//= $form->field($model, 'short_descr') ?>

    <?//= $form->field($model, 'long_descr') ?>

    <?//= $form->field($model, 'notes') ?>

    <?php // echo $form->field($model, 'supplier_sku') ?>

    <?php // echo $form->field($model, 'supplier_price') ?>

    <?php // echo $form->field($model, 'wholesale_price') ?>

    <?php // echo $form->field($model, 'width') ?>

    <?php // echo $form->field($model, 'height') ?>

    <?php // echo $form->field($model, 'depth') ?>

    <?php // echo $form->field($model, 'length') ?>


    <?php // echo $form->field($model, 'weight') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
