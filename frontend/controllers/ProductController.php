<?php

namespace frontend\controllers;

use frontend\models\Product;
use frontend\models\Review;
use Yii;

class ProductController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionListproduct($id){
        $data = new Product();
        $data = $data->getProductByGroupId($id);

        foreach ($data as &$product) {
            $productModel = new Product();
            $productModel->attributes = $product;

            $productReviews = Review::find()
                ->where(['product_id' => $product['product_id']])
                ->all();

            $averageRating = 0;
            if (!empty($productReviews)) {
                $totalRating = 0;
                foreach ($productReviews as $review) {
                    $totalRating += $review->rating;
                }
                $averageRating = $totalRating / count($productReviews);
            }

            $product['average_rating'] = $averageRating;
        }

        $page = new Product();
        $page = $page->getPageGroupProduct($id);

        return $this->render('listProduct', [
            'data' => $data,
            'page' => $page
        ]);
    }

    public function actionListproductbyauthor($id)
    {
        $data_author = new Product();
        $data_author = $data_author->getProductByAuthorId($id);

        foreach ($data_author as &$product) {
            $productModel = new Product();
            $productModel->attributes = $product;

            $productReviews = Review::find()
                ->where(['product_id' => $product['product_id']])
                ->all();

            $averageRating = 0;
            if (!empty($productReviews)) {
                $totalRating = 0;
                foreach ($productReviews as $review) {
                    $totalRating += $review->rating;
                }
                $averageRating = $totalRating / count($productReviews);
            }

            $product['average_rating'] = $averageRating;
        }

        $page_author = new Product();
        $page_author = $page_author->getPageAuthorProduct($id);

        return $this->render('listProductByAuthor', [
            "data_author" => $data_author,
            'page_author' => $page_author
        ]);
    }

    public function  actionListproductbysupplier($id){
        $data_supplier = new Product();
        $data_supplier = $data_supplier->getProductBySupplierId($id);

        foreach ($data_supplier as &$product) {
            $productModel = new Product();
            $productModel->attributes = $product;

            $productReviews = Review::find()
                ->where(['product_id' => $product['product_id']])
                ->all();

            $averageRating = 0;
            if (!empty($productReviews)) {
                $totalRating = 0;
                foreach ($productReviews as $review) {
                    $totalRating += $review->rating;
                }
                $averageRating = $totalRating / count($productReviews);
            }

            $product['average_rating'] = $averageRating;
        }

        $page_supplier = new Product();
        $page_supplier = $page_supplier->getPageSupplierProduct($id);

        return $this->render('listProductBySupplier', [
           "data_supplier" => $data_supplier,
            'page_supplier' => $page_supplier
        ]);
    }

    public function actionDetail($id)
    {
//        $data_detail = Product::getProductById($id);
        $data_detail = new Product();
        $data_detail = $data_detail->getProductById($id);

//        $author_name = Product::getAuthorName($data_detail['author_id']);
        $author_name = new Product();
        $author_name = $author_name->getAuthorName($data_detail['author_id']);


        $relatedProducts = new Product();
        $relatedProducts = $relatedProducts->getRelatedProduct($data_detail['group_id'], $id);

        $productReviews = Review::find()
            ->where(['product_id' => $id])
            ->orderBy(['created_at' => SORT_DESC])
            ->with('user')
            ->all();

        $averageRating = 0;
        if (!empty($productReviews)) {
            $totalRating = 0;
            foreach ($productReviews as $review) {
                $totalRating += $review->rating;
            }
            $averageRating = $totalRating / count($productReviews);
        }

        return $this->render('detail', [
            'data_detail' => $data_detail,
            'author_name' => $author_name,
            'relatedProducts' => $relatedProducts,
            'productReviews' => $productReviews,
            'averageRating' => $averageRating,
        ]);
    }

    public function actionAllproduct(){
        $data_all = new Product();
        $data_all = $data_all->getAllProduct();

        foreach ($data_all as &$product) {
            $productModel = new Product();
            $productModel->attributes = $product;

            $productReviews = Review::find()
                ->where(['product_id' => $product['product_id']])
                ->all();

            $averageRating = 0;
            if (!empty($productReviews)) {
                $totalRating = 0;
                foreach ($productReviews as $review) {
                    $totalRating += $review->rating;
                }
                $averageRating = $totalRating / count($productReviews);
            }

            $product['average_rating'] = $averageRating;
        }

        $page_all = new Product();
        $page_all = $page_all->getPageAllProduct();

        return $this->render('allproduct',[
            'data_all' => $data_all,
            'page_all' => $page_all,
        ]);
    }

    public function actionSearch(){
        $searchQuery =  Yii::$app->request->get('searchQuery');

        $product_search = Product::find()
            ->where(['like', 'product_name', $searchQuery])
            ->orWhere(['like', 'author.author_name', $searchQuery])
            ->orWhere(['like', 'group.group_name', $searchQuery])
            ->leftJoin('author', 'author.author_id = product.author_id')
            ->leftJoin('group', 'group.group_id = product.group_id')
            ->asArray()
            ->all();

        foreach ($product_search as &$product) {
            $productModel = new Product();
            $productModel->attributes = $product;

            $productReviews = Review::find()
                ->where(['product_id' => $product['product_id']])
                ->all();

            $averageRating = 0;
            if (!empty($productReviews)) {
                $totalRating = 0;
                foreach ($productReviews as $review) {
                    $totalRating += $review->rating;
                }
                $averageRating = $totalRating / count($productReviews);
            }

            $product['average_rating'] = $averageRating;
        }

        return $this->render('search', [
            'searchQuery' => $searchQuery,
            'product_search' => $product_search,
        ]);

    }
}
