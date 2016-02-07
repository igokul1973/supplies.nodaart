<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use kartik\export\ExportMenu;
use kartik\widgets\FileInput;
use yii\imagine\Image;



/* @var $this yii\web\View */
/* @var $productSearchModel backend\models\PurchaseOrderSearch */
/* @var $productDataProvider yii\data\ActiveproductDataProvider */

$this->title = Yii::t('backend', 'Add Products to PO # ') . $po_model->id;

$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Purchase Orders'), 'url' => ['purchase-order/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-order-add-products">
    <? // die(var_dump($po_model->id)); ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $productSearchModel]); ?>

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

        // Renders list of all SKUs
        echo $form->field($po_detail_model, 'product_id')->widget(Select2::classname(), [
            'data' => $sku_list,
            'options' => [
                'id' => 'purchaseorderdetails-sku',
                'placeholder' => 'Choose by SKU ...',
                'ajax' => true,
                'multiple' => false,
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'tags' => false,
            ],
        ])->label('Product SKU');

        // Renders list of all products
        /*echo $form->field($po_detail_model, 'product_id')->widget(Select2::classname(), [
            'data' => $product_list,
            'options' => [
                'placeholder' => 'Choose the product ...',
                'ajax' => true,
                'multiple' => false,
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'tags' => false,
            ],
        ]);*/
        ?>

        <?= $form->field($po_detail_model, 'quantity')->textInput() ?>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                <?= Html::submitButton(Yii::t('backend', 'Add chosen product'), ['class' => $product_model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>


    <?php ActiveForm::end(); ?>

    <? $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'action' => ['import-products-to-po', 'po_id' => $po_model->id],
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
    echo $form->field($po_detail_model, 'import_file')->widget(FileInput::classname(), [
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


    <?

    $isFa = false;

    $exportConfig =
    [
        ExportMenu::FORMAT_HTML => false,
        ExportMenu::FORMAT_CSV => false,
        ExportMenu::FORMAT_TEXT => false,
        ExportMenu::FORMAT_PDF => false,
        ExportMenu::FORMAT_EXCEL => false,
        ExportMenu::FORMAT_EXCEL_X => [
            'label' => Yii::t('backend', 'Excel 2007+'),
            'icon' => $isFa ? 'file-excel-o' : 'floppy-remove',
            'iconOptions' => ['class' => 'text-success'],
            'linkOptions' => [],
            'options' => ['title' => Yii::t('backend', 'Microsoft Excel 2007+ (xlsx)')],
            'alertMsg' => Yii::t('backend', 'The EXCEL 2007+ (xlsx) export file will be generated for download.'),
            'mime' => 'application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'extension' => 'xlsx',
            'writer' => 'Excel2007'
        ],
    ];

    ?>

    <?
    $excelColumns = [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        [
            'attribute' => 'picture_path',
            'value' => 'picture_path',
            'format' => ['image',['width'=>'150','height'=>'150']],
            'hAlign' => 'center',
        ],
        [
            'attribute' => 'sku',
            'value' => 'sku',
            'label' => 'SKU',
            'format' => 'text',
        ],
        'quantity',
        [
            'attribute' => 'product_name',
            'value' => 'product_name',
        ],
    ];

    $gridColumns =   
    [
        ['class' => 'yii\grid\SerialColumn'],

        // 'id',
        [
            'label' => 'Product picture',
            'value' => 'product.mainProductPicture',
            'format' => ['image',['width'=>'150','height'=>'150']],
            'hAlign' => 'center'
        ],
        [
            'attribute' => 'sku',
            'value' => 'product.sku',
            'label' => 'SKU',
            'format' => 'text',
        ],
        'quantity',
        [
            'attribute' => 'product_name',
            'value' => 'product.name',
            'label' => 'Product name'
        ],
        // 'updated_by',
        // 'created_at',
        // 'updated_at',

        [
            'class' => 'kartik\grid\ActionColumn',
            'dropdown' => false,
            'hAlign' => 'center',
            'buttons' => [
                'view' => function($url, $model) {
                    return false;

                },
                'update' => function($url, $model) {
                    return false;

                },
                'delete' => function($url, $model) use ($po_model) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete?id=' . $model->id . '&po_id=' . $po_model->id], ['title' => 'Delete', 'data-confirm' => 'Are you sure to delete this item?', 'data-method' => 'post', 'data-pjax' => '0']);

                }
            ]
        ],
    ];

    $fullExportMenu = ExportMenu::widget([
        'dataProvider' => $excelDataProvider,
        'columns' => $excelColumns,
        'target' => ExportMenu::TARGET_BLANK,
        'fontAwesome' => true,
        'pjaxContainerId' => 'kv-pjax-container',
        'enableFormatter' => false,
        'exportConfig' => $exportConfig,
        'selectedColumns' => [0, 2, 3, 4, 5],
        'noExportColumns' => [1, 6],
        'dropdownOptions' => [
            'label' => 'Full',
            'class' => 'btn btn-default',
            'itemsBefore' => [
                '<li class="dropdown-header">Export All Data</li>',
            ],
        ],
        'filename' => 'Purchase order #' . $po_model->id . ' - ' . date('Y-m-d'),
        'onRenderDataCell' => function($cell, $content, $model, $key, $index, $grid) {
            // var_dump($cell->getParent()->getParent());

            $row_number = $cell->getRow();
            $active_sheet = $cell->getParent()->getParent();

            if ($cell->getColumn() == 'B') {
                if ($content !== '') {
                    $filename = basename($content);
                    // var_dump($filename);
                    $base_dir = Yii::getAlias('@webRoot');
                    $objDrawing = new PHPExcel_Worksheet_Drawing();
                    Image::thumbnail($base_dir . $content, 300, 300)->save($base_dir . '/uploads/prod_pics/thumbs/' . $filename, ['quality' => 100]);
                    $objDrawing->setPath($base_dir . '/uploads/prod_pics/thumbs/' . $filename);
                    $objDrawing->setCoordinates('B'.$row_number);
                    // $objDrawing->setHeight(250);
                    $objDrawing->setOffsetX(12);
                    $objDrawing->setOffsetY(15);
                    
                    $objDrawing->setWorksheet($active_sheet);
                    $image_index = $objDrawing->getImageIndex();
                    $active_sheet->getRowDimension($row_number)->setRowHeight(250);
                    $active_sheet->setCellValue('B'.$row_number, '');
                }

            }
            if ($cell->getColumn() == 'C') {
                $active_sheet->getStyle('C'.$row_number)
                        ->getNumberFormat()
                        ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
                // this way (see line above and line below) text containing 'e',
                // such as '3423e3' will not be interpreted by Excel as 
                // a scientific number, such as '3423300'
                $active_sheet->setCellValueExplicit('C'.$row_number, $content);
            
            }
        },
        'onRenderSheet' => function($sheet, $grid) {
            $sheet->getColumnDimension('B')->setAutoSize(false);
            $sheet->getColumnDimension('B')->setWidth(40);
        },
    ]);


    ?>

    <?= GridView::widget([
        'dataProvider' => $poDetailsDataProvider,
        'filterModel' => $poDetailsSearchModel,
        'resizableColumns' => true,
        'persistResize' => true,
        'floatHeader' => false,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Library</h3>',
        ],
        'toggleDataOptions' => [
            'all' => [
                'class' => 'btn btn-default',
                'title' => 'Show all on one page',
                'label' => 'Show all on one page',
            ],
            'page' => [
                'class' => 'btn btn-default',
                'title' => 'Show pages',
                'label' => 'Show pages',
            ],
        ],
        // set a label for default menu
        /*'export' => [
            'label' => 'Page',
            'fontAwesome' => true,
        ],*/
        // your toolbar can include the additional full export menu
        'toolbar' => [
            // '{export}',
            '{toggleData}',
            $fullExportMenu,
            ['content'=>
                /*Html::button('<i class="glyphicon glyphicon-plus"></i>', [
                    'type'=>'button', 
                    'title'=>Yii::t('backend', 'Add Book'), 
                    'class'=>'btn btn-success'
                ]) . ' '.*/
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['view', 'id' => $po_model->id], [
                    'data-pjax'=>0, 
                    'class' => 'btn btn-default', 
                    'title'=>Yii::t('backend', 'Reset Grid')
                ])
            ],
        ],
        'toggleDataContainer' => ['class' => 'btn-group'],
        'columns' => $gridColumns,

    ]); ?>

</div>
