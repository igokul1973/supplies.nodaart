<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\bootstrap\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Typeahead;
use kartik\widgets\Select2;
use kartik\checkbox\CheckboxX;
use kartik\widgets\SwitchInput;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-list-view row">
    <div class="hidden-xs col-sm-6 col-md-5 col-lg-4">
        <img src=<?= $model->mainProductPicture; ?> width="150" height="150">
    </div>
    <div class="col-xs-24 col-sm-18 col-md-19 col-lg-20">
        <div class="row">
            <div class="col-xs-5 col-sm-7 col-md-6 col-lg-4">
                SKU: 
            </div>
            <div class="col-xs-19 col-sm-17 col-md-18 col-lg-20">
                <?= Html::a(Yii::t('backend', $model->sku), ['view?id=' . $model->id], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-5 col-sm-7 col-md-6 col-lg-4">
                Name:
            </div>
            <div class="col-xs-19 col-sm-17 col-md-18 col-lg-20">
                <?= $model->name; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-5 col-sm-7 col-md-6 col-lg-4">
                Color:
            </div>
            <div class="col-xs-19 col-sm-17 col-md-18 col-lg-20">
                <?= $model->color !== null ? $model->color->color : ''; ?>
            </div>
        </div>
        <div class="row">
            <div class="hidden-xs col-xs-7 col-sm-7 col-md-6 col-lg-4">
                Short description:
            </div>
            <div class="hidden-xs col-xs-17 col-sm-17 col-md-18 col-lg-20">
                <?= HtmlPurifier::process($model->short_descr); ?>
            </div>
        </div>
        <div class="row">
            <div class="hidden-xs col-sm-7 col-md-6 col-lg-4">
                Supplier:
            </div>
            <div class="hidden-xs col-sm-17 col-md-18 col-lg-20">
                <?= $model->suppliersList; ?>
            </div>
        </div>
        <div class="row">
            <div class="hidden-xs col-sm-7 col-md-6 col-lg-4">
                </div>
            <div class="hidden-xs col-sm-17 col-md-18 col-lg-20">
                <?= Html::a(Yii::t('app', 'Update'), ['product/update/'.$model->id], ['class' => 'btn btn-info']) ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['product/delete/'.$model->id], ['class' => 'btn btn-danger', 'title' => 'Delete', 'aria-label' => 'Delete', 'data-confirm' => 'Are you sure you want to delete this item?', 'data-method' => 'post']) ?>
            </div>
        </div>
    </div>
</div>
