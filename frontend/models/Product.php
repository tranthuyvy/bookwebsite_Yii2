<?php

namespace frontend\models;
use frontend\models\Author;
use Yii;
use yii\data\Pagination;
use yii\db\Expression;

/**
 * This is the model class for table "product".
 *
 * @property int $product_id
 * @property string $product_name
 * @property string $product_image
 * @property float $product_price
 * @property string|null $product_description
 * @property int $group_id
 * @property int $supplier_id
 * @property int $author_id
 * @property int $status
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_name', 'product_image', 'product_price', 'group_id', 'supplier_id', 'author_id', 'user_id', 'created_at', 'updated_at'], 'required'],
            [['product_price'], 'number'],
            [['product_description'], 'string'],
            [['group_id', 'supplier_id', 'author_id', 'status', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['product_name', 'product_image'], 'string', 'max' => 10000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'product_name' => 'Product Name',
            'product_image' => 'Product Image',
            'product_price' => 'Product Price',
            'product_description' => 'Product Description',
            'group_id' => 'Group ID',
            'supplier_id' => 'Supplier ID',
            'author_id' => 'Author ID',
            'status' => 'Status',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getAllProduct($status =1){
        $page = $this->getPageAllProduct();
        $data_all = Product::find()
            ->where(['status'=>$status])
            ->distinct()
            ->asArray()
            ->offset($page->offset)
            ->limit($page->limit)
            ->all();
        return $data_all;
    }

    public function getRandomProduct($limit = 12, $status = 1)
    {
        $data = Product::find()
            ->where(['status' => $status])
            ->orderBy(new Expression('RAND()'))
            ->limit($limit)
            ->distinct()
            ->asArray()
            ->all();
        return $data;
    }

    public function getBestSellerProduct($limit = 12, $status = 1)
    {
        $dataBestSeller = Product::find()
            ->where(['status' => $status])
            ->orderBy(new Expression('RAND()'))
            ->limit($limit)
            ->distinct()
            ->asArray()
            ->all();

        return $dataBestSeller;
    }

    public function getSuggestProduct($limit = 5, $status = 1)
    {
        $dataSuggestion = Product::find()
            ->where(['status' => $status])
            ->orderBy(new Expression('RAND()'))
            ->limit($limit)
            ->distinct()
            ->asArray()
            ->all();

        return $dataSuggestion;
    }

    public function getProductByAuthorId($id){
        $page = $this->getPageAuthorProduct($id);
        $data_author = Product::find()
            ->asArray()
            ->where('author_id=:author_id', ['author_id'=>$id])
            ->offset($page->offset)
            ->limit($page->limit)
            ->all();
        return $data_author;
    }

    public function getProductBySupplierId($id){
        $page = $this->getPageSupplierProduct($id);
        $data_supplier = Product::find()
            ->asArray()
            ->where('supplier_id=:supplier_id', ['supplier_id'=>$id])
            ->offset($page->offset)
            ->limit($page->limit)
            ->all();
        return $data_supplier;
    }

    public function getProductById($id){
        $data_detail = Product::find()
            ->asArray()
            ->where('product_id=:id', ['id' => $id])
            ->one();
        return $data_detail;
    }

    public static function getAuthorName($author_id)
    {
        $author = Author::findOne(['author_id' => $author_id]);

        return $author ? $author->author_name : null;
    }

    public static function getRelatedProduct($group_id, $product_id, $limit = 5)
    {
        $relatedProducts = Product::find()
            ->where(['group_id' => $group_id])
            ->andWhere(['not', ['product_id' => $product_id]])
            ->limit($limit)
            ->asArray()
            ->all();
        foreach ($relatedProducts as &$product) {
            $product['author_name'] = Product::getAuthorName($product['author_id']);
        }
        return $relatedProducts;
    }

    public function getProductByGroupId($group_id){
        $page = $this->getPageGroupProduct($group_id);
        $data = Product::find()
            ->asArray()
            ->where('group_id=:group_id', ['group_id'=>$group_id])
            ->offset($page->offset)
            ->limit($page->limit)
            ->all();
        return $data;
    }

    function getPageGroupProduct($group_id)
    {
        $data = Product::find()
            ->asArray()
            ->where('group_id=:group_id',['group_id'=>$group_id])
            ->all();
        $pages = new Pagination(['totalCount'=> count($data), 'pageSize'=>'8']);
        return $pages;
    }

    function getPageAuthorProduct($author_id)
    {
        $data_author = Product::find()
            ->asArray()
            ->where('author_id=:author_id',['author_id'=>$author_id])
            ->all();
        $page_author = new Pagination(['totalCount'=> count($data_author), 'pageSize'=>'8']);
        return $page_author;
    }
    function getPageSupplierProduct($supplier_id)
    {
        $data_supplier = Product::find()
            ->asArray()
            ->where('supplier_id=:supplier_id',['supplier_id'=>$supplier_id])
            ->all();
        $page_supplier = new Pagination(['totalCount'=> count($data_supplier), 'pageSize'=>'8']);
        return $page_supplier;
    }
    function getPageAllProduct()
    {
        $data_all = Product::find()
            ->asArray()
            ->all();
        $page_all = new Pagination(['totalCount'=> count($data_all), 'pageSize'=>'8']);
        return $page_all;
    }
}
