<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use kartik\widgets\FileInput;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', [
            'model' => $searchModel,
            'supplier_list' => $supplier_list,
            'color_list' => $color_list,
            'prod_cat_list' => $prod_cat_list,
        ]
        ); ?>

    <p>
        <?= Html::a(Yii::t('backend', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <? $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'action' => ['import-products'],
        // 'enableAjaxValidation' => true,
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-3',
                'wrapper' => 'col-sm-10',
                'error' => '',
            ],
        ],
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
    ]);

    // Список файлов для подгрузки
    echo $form->field($model, 'import_file')->widget(FileInput::classname(), [
        'options' => [
            'multiple' => false
        ],
        'pluginOptions'=>[
            'allowedFileExtensions' => [
                'xls',
                'xlsx',
            ],
            'overwriteInitial'=>false,
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => false
        ],
    ]);
    ?>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            <?//= Html::a(Yii::t('backend', 'Import products using file'), ['import-products-to-po', 'po_id' => $po_model->id], ['title' => 'Import products using Excel file', 'data-confirm' => 'Are you sure to import using Excel file? Beware!', 'class' => 'btn btn-info']) ?>
            <?= Html::submitButton(Yii::t('backend', 'Import products using file'), ['class' => 'btn btn-info']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_listView', /*function ($model, $key, $index, $widget) {

            return Html::a(Html::encode($model->id), ['view', 'id' => $model->id]);

        },*/
    ]) ?>

</div>
