<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\widgets\FileInput;
use yii\imagine\Image;


/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseOrder */

$this->title = 'Purchase Order #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Purchase Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('backend', 'Create'), ['create'], ['class' => 'btn btn-info']) ?>
        <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend', 'Add products to PO'), ['purchase-order-details/add-products-to-po', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'status_id',
                'value' => $model->status->status_name
            ],
            'note:ntext',
            [
                'attribute' => 'created_by',
                'value' => $model->createdBy->profile->fullName
            ],
            [
                'attribute' => 'updated_by',
                'value' => $model->updatedBy->profile->fullName
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

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

    $gridColumns = [
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
        [
            'attribute' => 'product_name',
            'value' => 'product.name',
            'label' => 'Product name'
        ],
        'quantity',
        // 'updated_by',
        // 'created_at',
        // 'updated_at',
        // ['class' => 'yii\grid\ActionColumn'],
    ];

    $fullExportMenu = ExportMenu::widget([
        'dataProvider' => $poDataProvider,
        'columns' => $gridColumns,
        'target' => ExportMenu::TARGET_BLANK,
        'fontAwesome' => true,
        'pjaxContainerId' => 'kv-pjax-container',
        'enableFormatter' => false,
        'exportConfig' => $exportConfig,
        'selectedColumns' => [0, 1, 2, 3, 4],
        'noExportColumns' => [5],
        'dropdownOptions' => [
            'label' => 'Full',
            'class' => 'btn btn-default',
            'itemsBefore' => [
                '<li class="dropdown-header">Export All Data</li>',
            ],
        ],
        'filename' => 'Purchase order #' . $model->id . ' - ' . date('Y-m-d'),
        'onRenderDataCell' => function($cell, $content, $model, $key, $index, $grid) {
            // var_dump($cell->getParent()->getParent());
            $row_number = $cell->getRow();
            $active_sheet = $cell->getParent()->getParent();
            if ($cell->getColumn() == 'B') {
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
                $active_sheet->getRowDimension($row_number)->setRowHeight(250);
                $active_sheet->setCellValue('B'.$row_number, '');
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
        'dataProvider' => $poDataProvider,
        'filterModel' => $poSearchModel,
        'resizableColumns' => true,
        'persistResize' => true,
        'floatHeader' => false,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Library</h3>',
        ],
        // set a label for default menu
        /*'export' => [
            'label' => 'Page',
            'fontAwesome' => true,
        ],*/
        // your toolbar can include the additional full export menu
        'toolbar' => [
            // '{export}',
            $fullExportMenu,
            ['content'=>
                /*Html::button('<i class="glyphicon glyphicon-plus"></i>', [
                    'type'=>'button', 
                    'title'=>Yii::t('backend', 'Add Book'), 
                    'class'=>'btn btn-success'
                ]) . ' '.*/
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['add-products-to-po', 'id' => $model->id], [
                    'data-pjax'=>0, 
                    'class' => 'btn btn-default', 
                    'title'=>Yii::t('backend', 'Reset Grid')
                ])
            ],
        ],
        'columns' => $gridColumns,

    ]); ?>
</div>
