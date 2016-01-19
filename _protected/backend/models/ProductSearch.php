<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Product;

/**
 * ProductSearch represents the model behind the search form about `backend\models\Product`.
 */
class ProductSearch extends Product
{

    // adding public attributes that will be used to store the data to be searched
    public $suppliers;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_category_id', 'width', 'height', 'depth', 'length', 'color_id', 'weight'], 'integer'],
            [['sku', 'short_descr', 'long_descr', 'notes', 'supplier_sku', 'name', 'suppliers'], 'safe'],
            [['supplier_price', 'wholesale_price'], 'number'],
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
        $query = Product::find();

        // custom code below in order to include search on $suppliers
        $query->joinWith(['suppliers']); // end of custom code

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'supplier_price' => $this->supplier_price,
            'wholesale_price' => $this->wholesale_price,
            'width' => $this->width,
            'height' => $this->height,
            'depth' => $this->depth,
            'length' => $this->length,
            'color_id' => $this->color_id,
            'product_category_id' => $this->product_category_id,
            'weight' => $this->weight,
        ]);

        $query->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'product.name', $this->name])
            ->andFilterWhere(['like', 'short_descr', $this->short_descr])
            ->andFilterWhere(['like', 'long_descr', $this->long_descr])
            ->andFilterWhere(['like', 'notes', $this->notes])
            ->andFilterWhere(['like', 'supplier_sku', $this->supplier_sku])
            ->andFilterWhere(['supplier.id' => $this->suppliers]);

        return $dataProvider;
    }
}
