<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use backend\models\PurchaseOrderDetails;

/**
 * PurchaseOrderDetailsSearch represents the model behind the search form about `backend\models\PurchaseOrderDetails`.
 */
class PurchaseOrderDetailsSearch extends PurchaseOrderDetails
{

    // Adding additional related attributes for filtering and sorting
    public $product_name;
    public $sku;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'po_id', 'product_id', 'quantity'], 'integer'],
            [['product_name', 'sku'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PurchaseOrderDetails::find();

        // let's join the query with related Product table
        $query->joinWith(['product']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Important: here is how we set up the sorting
        // The key is the attribute name on our "ProductSearch" instance
        $dataProvider->sort->attributes['product_name'] = [
            // The tables are the ones our relation are configured to
            'asc' => ['product.name' => SORT_ASC],
            'desc' => ['product.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['sku'] = [
            // The tables are the ones our relation are configured to
            'asc' => ['product.sku' => SORT_ASC],
            'desc' => ['product.sku' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'po_id' => $this->po_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
        ]);

        $query->andFilterWhere(['like', 'product.sku', $this->sku])
            ->andFilterWhere(['like', 'product.name', $this->product_name]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchById($params, $id)
    {
        $query = PurchaseOrderDetails::find()->where(['po_id' => $id]);

        // let's join the query with related Product table
        $query->joinWith(['product']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Important: here is how we set up the sorting
        // The key is the attribute name on our "ProductSearch" instance
        $dataProvider->sort->attributes['product_name'] = [
            // The tables are the ones our relation are configured to
            'asc' => ['product.name' => SORT_ASC],
            'desc' => ['product.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['sku'] = [
            // The tables are the ones our relation are configured to
            'asc' => ['product.sku' => SORT_ASC],
            'desc' => ['product.sku' => SORT_DESC],
        ];
        // $query->addOrderBy(new \yii\db\Expression('LENGTH(product.sku), sku DESC'));

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'po_id' => $this->po_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
        ]);

        $query->andFilterWhere(['like', 'product.sku', $this->sku])
            ->andFilterWhere(['like', 'product.name', $this->product_name]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance for Excel export
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchForExcel($id)
    {

        $poSearchModelsForExcel = PurchaseOrderDetails::find()->where(['po_id' => $id])->all();

        $all_skus = [];
        $temp_array = [];
        $data_provider_array = [];

        foreach ($poSearchModelsForExcel as $model) {
            $sku = $model->product->sku;
                if (strpos($sku, "-")) {
                    list ($main_sku, $size) = explode("-", $sku);
                    if (ctype_digit($size)) {
                        // var_dump($skus_array);
                            $temp_array[$main_sku][] = [
                                'id' => $model->id,
                                'picture_path' => $model->product->mainProductPicture,
                                'sku' => $main_sku,
                                'size' => $size,
                                'quantity' => $model->quantity,
                                'product_name' => $model->product->name,
                            ];    
                    }
                } else {
                    $temp_array[$sku][] = [
                        'id' => $model->id,
                        'picture_path' => $model->product->mainProductPicture,
                        'sku' => $sku,
                        'quantity' => $model->quantity,
                        'product_name' => $model->product->name,
                    ];

                }
        }

        // Получение списка столбцов
        foreach ($temp_array as $key => $row) {
            // let's sort the arrays by the 'size' value
            foreach ($temp_array[$key] as $key2 => $row2) {
                if (count($temp_array[$key]) > 1) {
                    usort($temp_array[$key], function($a,$b){return $a['size']-$b['size'];});
                }
            }

            foreach ($temp_array[$key] as $key2 => $value) {
                if (array_key_exists('size', $value)) {
                    if ($key2 == 0) {
                        $data_provider_array[] = [
                            'id' => $value['id'],
                            'picture_path' => $value['picture_path'],
                            'sku' => $value['sku'],
                            'quantity' => '',
                            'product_name' => $value['product_name'],
                        ];
                        $data_provider_array[] = [
                            'id' => $value['id'],
                            'picture_path' => '',
                            'sku' => 'Size ' . $value['size'],
                            'quantity' => $value['quantity'],
                            'product_name' => '',
                        ];
                    } else {
                        $data_provider_array[] = [
                            'id' => $value['id'],
                            'picture_path' => '',
                            'sku' => 'Size ' . $value['size'],
                            'quantity' => $value['quantity'],
                            'product_name' => '',
                        ];
                    }
                } else {
                    $data_provider_array[] = [
                        'id' => $value['id'],
                        'picture_path' => $value['picture_path'],
                        'sku' => $value['sku'],
                        'quantity' => $value['quantity'],
                        'product_name' => $value['product_name'],
                    ];

                }
            }
        }


        // die(var_dump($data_provider_array));

        $provider = new ArrayDataProvider([
            'allModels' => $data_provider_array,
            'sort' => [
                'attributes' => ['product_id'],

            ],
            'pagination' => [
                'pageSize' => 1000,
            ],
        ]);


        $dataProvider->sort->attributes['sku'] = [
            // The tables are the ones our relation are configured to
            'asc' => ['sku' => SORT_ASC],
            'desc' => ['sku' => SORT_DESC],
        ];




        return $provider;
    }



}
