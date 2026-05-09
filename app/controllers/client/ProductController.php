<?php

/**
 * Quản lý danh sách và chi tiết sản phẩm phía khách hàng
 */
class ProductController
{
    private $productModel;
    private $categoryModel;
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->productModel = new ProductModel($this->conn);
        $this->categoryModel = new CategoryModel($this->conn);
    }

    /**
     * Hiển thị danh sách sản phẩm theo danh mục và phân trang
     */
    public function index()
    {
        $categoryId = $_GET['category'] ?? null;
        $categoryName = "Sản phẩm của chúng tôi";
        
        $limit = 6;
        $page = $_GET['page'] ?? 1;
        $offset = ($page - 1) * $limit;

        if ($categoryId) {
            $this->productModel->where('category_id', $categoryId);
            $totalItems = $this->productModel->count();
            $products = $this->productModel->where('category_id', $categoryId)->limit($limit, $offset)->get();
            $currentCat = $this->categoryModel->where('id', $categoryId)->first();
            $categoryName = $currentCat['name'] ?? $categoryName;
        } else {
            $totalItems = $this->productModel->count();
            $products = $this->productModel->limit($limit, $offset)->get();
        }

        $totalPages = ceil($totalItems / $limit);
        $categories = $this->categoryModel->get();
        
        require_once "views/client/products/index.php";
    }

    /**
     * Hiển thị chi tiết sản phẩm và các đánh giá
     */
    public function show($slug)
    {
        $product = $this->productModel->where('slug', $slug)->first();
        
        if (!$product) {
            header("Location: index.php?url=products");
            exit;
        }

        require_once "app/models/ProductCommentModel.php";
        $commentModel = new ProductCommentModel($this->conn);
        $comments = $commentModel->getCommentsByProductId($product['id']);

        require_once "views/client/products/detail.php";
    }
}