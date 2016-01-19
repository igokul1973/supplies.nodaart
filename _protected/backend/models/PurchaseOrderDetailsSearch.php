<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
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

}
