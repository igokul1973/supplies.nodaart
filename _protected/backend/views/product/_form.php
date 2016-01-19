<?php

use yii\helpers\Html;
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

<div class="product-form">

    <? $form = ActiveForm::begin([
        'layout' => 'horizontal',
        // 'enableAjaxValidation' => true,
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-4',
                'wrapper' => 'col-sm-10',
                'error' => '',
            ],
        ],
        'options' => [
            'enctype'=>'multipart/form-data',
        ],
    ]);
    ?>

    <?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>

    <?
    // Renders list of all product categories
    echo $form->field($model, 'product_category_id')->widget(Select2::classname(), [
        'data' => $prod_category_list,
        'options' => [
            'placeholder' => 'Choose product category ...',
            'ajax' => true,
            'multiple' => false,
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => false,
        ],
    ]);
    ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


    <?
    if (Yii::$app->controller->action->id == 'create') {
        // Список файлов для подгрузки
        echo $form->field($product_picture_model, 'pictures[]')->widget(FileInput::classname(), [
            'options' => [
                // 'accept'=>'image/*',
                'multiple' => true
            ],
            'pluginOptions'=>[
                'allowedFileExtensions' => [
                    'jpg',
                    'jpeg',
                    'gif',
                    'png',
                    'pdf',
                    'doc',
                    'docx',
                    'xls',
                    'xlsx',
                ]
            ],
        ]);
    } else if (Yii::$app->controller->action->id == 'update') {

        ?>

        <div class="form-group contract-files">
        <label for="contract-files-list" class="control-label col-sm-4">Uploaded images</label>    
            <div class="col-sm-10">
                <div class="panel panel-default">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>File name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <?

                        foreach ($image_list as $image_arr) {
                            $file_link = Html::a( $image_arr['file_name'], 'download?file=' . $image_arr['file_name'], [ 'download' => true, 'name' => $image_arr['id'] ] );
                            echo '<tr>';
                            echo '<td>' . $file_link . '</td>';
                            echo '<td><a href="../product-picture/' . $image_arr['id'] . '" class="removeFile" data-id=' . $image_arr['id'] . '>Удалить</a></td>';
                            echo '</tr>';
                        }

                        ?>
                    </table>
                </div>
                </div>
        </div>
        <?
        // Список файлов для подгрузки
        echo $form->field($product_picture_model, 'pictures[]')->widget(FileInput::classname(), [
            'options' => [
                // 'accept'=>'image/*',
                'multiple' => true
            ],
            'pluginOptions'=>[
                'allowedFileExtensions' => [
                    'jpg',
                    'jpeg',
                    'gif',
                    'png',
                    'pdf',
                    'doc',
                    'docx',
                    'xls',
                    'xlsx',
                ],
                /*'initialPreview'=>$initialPreview,[
                    Html::img("/images/moon.jpg", ['class'=>'file-preview-image', 'alt'=>'The Moon', 'title'=>'The Moon']),
                    Html::img("/images/earth.jpg",  ['class'=>'file-preview-image', 'alt'=>'The Earth', 'title'=>'The Earth']),
                ],*/
                // 'initialCaption'=>"Существующие файлы",
                'overwriteInitial'=>false,
                'showCaption' => true,
                'showRemove' => false,
                'showUpload' => false
            ],
        ]);
    }
    ?>



    <?= $form->field($model, 'short_descr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'long_descr')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'supplier_sku')->textInput(['maxlength' => true]) ?>

    <?
    // Renders list of all suppliers
    echo $form->field($model, 'suppliers')->widget(Select2::classname(), [
        'data' => $supplier_list,
        'options' => [
            'placeholder' => 'Choose the supplier ...',
            'ajax' => true,
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => true,
        ],
    ]);
    ?>

    <?= $form->field($model, 'supplier_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wholesale_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'width')->textInput() ?>

    <?= $form->field($model, 'height')->textInput() ?>

    <?= $form->field($model, 'depth')->textInput() ?>

    <?= $form->field($model, 'length')->textInput() ?>

    <?
    // Renders list of all colors
    echo $form->field($model, 'color_id')->widget(Select2::classname(), [
        'data' => $color_list,
        'options' => ['placeholder' => 'Choose the color ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <div class="col-sm-5 col-sm-offset-2">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create product') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
