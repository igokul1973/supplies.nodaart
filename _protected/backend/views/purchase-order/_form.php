<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-order-form">

    <? $form = ActiveForm::begin([
        'layout' => 'horizontal',
        // 'enableAjaxValidation' => true,
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-3',
                'wrapper' => 'col-sm-10',
                'error' => '',
            ],
        ],
    ]);

    // Renders list of all suppliers
    echo $form->field($model, 'status_id')->widget(Select2::classname(), [
        'data' => $po_status_list,
        'options' => [
            'placeholder' => 'Choose the status ...',
            'ajax' => true,
            'multiple' => false,
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => false,
        ],
    ]);
    ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?//= $form->field($model, 'created_by')->textInput() ?>

    <?//= $form->field($model, 'updated_by')->textInput() ?>

    <?//= $form->field($model, 'created_at')->textInput() ?>

    <?//= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
