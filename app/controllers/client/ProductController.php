<?php

require_once __DIR__ . '/../../core/SEO.php';
require_once __DIR__ . '/../../core/SEOTrait.php';

/**
 * Quản lý danh sách và chi tiết sản phẩm phía khách hàng
 */
class ProductController
{
    use SEOTrait;
    
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
        global $globalSettings;
        
        $categoryId = $_GET['category'] ?? null;
        $categoryName = "Sản phẩm của chúng tôi";
        
        // Set SEO for products listing page
        if ($categoryId) {
            $currentCat = $this->categoryModel->where('id', $categoryId)->first();
            $categoryName = $currentCat['name'] ?? $categoryName;
            $this->setPageSEO('products_category', ['name' => $categoryName]);
        } else {
            $this->setPageSEO('products');
        }
        
        $limit = 6;
        $page = $_GET['page'] ?? 1;
        $offset = ($page - 1) * $limit;

        if ($categoryId) {
            $this->productModel->where('category_id', $categoryId);
            $totalItems = $this->productModel->count();
            $products = $this->productModel->where('category_id', $categoryId)->limit($limit, $offset)->get();
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
        global $globalSettings;
        
        $product = $this->productModel->where('slug', $slug)->first();
        
        if (!$product) {
            header("Location: " . BASE_PATH . "/products");
            exit;
        }
        
        // Get category name for SEO
        $category = $this->categoryModel->where('id', $product['category_id'])->first();
        $product['category_name'] = $category['name'] ?? '';
        
        // Set SEO for product detail page
        $this->setPageSEO('product', $product);

        require_once "app/models/ProductCommentModel.php";
        $commentModel = new ProductCommentModel($this->conn);
        $comments = $commentModel->getCommentsByProductId($product['id']);
        
        // Calculate average rating
        $stmt = $this->conn->prepare("
            SELECT AVG(rating) as avg_rating, COUNT(*) as total
            FROM product_comments 
            WHERE product_id = ? AND rating IS NOT NULL
        ");
        $stmt->bind_param("i", $product['id']);
        $stmt->execute();
        $ratingData = $stmt->get_result()->fetch_assoc();
        
        $avgRating = round($ratingData['avg_rating'] ?? 0, 1);
        $totalReviews = $ratingData['total'] ?? 0;
        
        // Get rating counts for each star
        $ratingCounts = [];
        for ($i = 1; $i <= 5; $i++) {
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) as count FROM product_comments 
                WHERE product_id = ? AND rating = ?
            ");
            $stmt->bind_param("ii", $product['id'], $i);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $ratingCounts[$i] = $result['count'];
        }

        require_once "views/client/products/detail.php";
    }
}