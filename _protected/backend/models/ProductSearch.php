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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'supplier_id', 'width', 'height', 'depth', 'length', 'color_id', 'weight'], 'integer'],
            [['sku', 'short_descr', 'long_descr', 'notes', 'supplier_sku'], 'safe'],
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
            'supplier_id' => $this->supplier_id,
            'supplier_price' => $this->supplier_price,
            'wholesale_price' => $this->wholesale_price,
            'width' => $this->width,
            'height' => $this->height,
            'depth' => $this->depth,
            'length' => $this->length,
            'color_id' => $this->color_id,
            'weight' => $this->weight,
        ]);

        $query->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'short_descr', $this->short_descr])
            ->andFilterWhere(['like', 'long_descr', $this->long_descr])
            ->andFilterWhere(['like', 'notes', $this->notes])
            ->andFilterWhere(['like', 'supplier_sku', $this->supplier_sku]);

        return $dataProvider;
    }
}
