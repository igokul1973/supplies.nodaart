<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = 'Product SKU: ' . $model->sku;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('backend', 'Create'), ['create'], ['class' => 'btn btn-info']) ?>
        <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'condensed' => false,
        'bordered' => true,
        'attributes' => [
            // 'id',
            'sku',
            [
                'label' => 'Product picture',
                'value' => $model->mainProductPicture,
                'format' => ['image',['width'=>'150','height'=>'150']]
            ],
            [
                'attribute' => 'product_category_id',
                'value' => $model->productCategory->name,
            ],
            'name',
            'short_descr',
            'long_descr:ntext',
            'notes:ntext',
            [
                'label' => 'Suppliers',
                'value' => $model->suppliersList
            ],
            'supplier_sku',
            'supplier_price',
            'wholesale_price',
            'size',
            'width',
            'height',
            'depth',
            'length',
            'color_id',
            'weight',
        ],
    ]) ?>

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

                    foreach ($model->getImageList($model->productPictures) as $image_arr) {
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


</div>
