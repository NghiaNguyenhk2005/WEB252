<?php

/**
 * Quản lý Sản phẩm phía Admin
 */
class AdminProductController
{
    private $productModel;
    private $categoryModel;
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
        AuthMiddleware::admin(); // Chỉ Admin mới được truy cập
        $this->productModel = new ProductModel($this->conn);
        $this->categoryModel = new CategoryModel($this->conn);
    }

    public function index()
    {
        $products = $this->productModel->get();
        require_once "views/admin/products/index.php";
    }

    public function create()
    {
        $categories = $this->categoryModel->get();
        require_once "views/admin/products/create.php";
    }

    /**
     * Lưu sản phẩm mới và xử lý upload ảnh
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => htmlspecialchars($_POST['name']),
                'slug' => $_POST['slug'] ?: strtolower(str_replace(' ', '-', $_POST['name'])),
                'price' => $_POST['price'],
                'stock' => $_POST['stock'],
                'description' => $_POST['description'],
                'category_id' => $_POST['category_id']
            ];

            // Xử lý upload hình ảnh nội bộ
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $data['image'] = $this->uploadImage($_FILES['image']);
            }

            $this->productModel->create($data);
            header("Location: index.php?url=admin/products");
            exit;
        }
    }

    public function delete($id)
    {
        $this->productModel->delete($id);
        header("Location: index.php?url=admin/products");
        exit;
    }

    /**
     * Hàm hỗ trợ upload ảnh vào thư mục server
     */
    private function uploadImage($file)
    {
        $targetDir = "uploads/products/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName = time() . "_" . basename($file["name"]);
        $targetFilePath = $targetDir . $fileName;
        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return $targetFilePath;
        }
        return null;
    }
}