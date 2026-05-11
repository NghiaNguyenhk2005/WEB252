<?php
class AdminProductController {
    private $productModel;
    private $categoryModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        AuthMiddleware::admin();
        $this->productModel  = new ProductModel($this->conn);
        $this->categoryModel = new CategoryModel($this->conn);
    }

    public function index() {
        global $globalSettings;
        $products = $this->productModel->get();
        require_once __DIR__ . '/../../../views/admin/products/index.php';
    }

    public function create() {
        global $globalSettings;
        $categories = $this->categoryModel->get();
        require_once __DIR__ . '/../../views/admin/products/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'        => htmlspecialchars($_POST['name']),
                'slug'        => $_POST['slug'] ?: strtolower(str_replace(' ', '-', $_POST['name'])),
                'price'       => $_POST['price'],
                'stock'       => $_POST['stock'],
                'description' => $_POST['description'],
                'category_id' => $_POST['category_id'],
                'created_at'  => date('Y-m-d H:i:s'),
            ];
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $data['image'] = $this->uploadImage($_FILES['image']);
            }
            $this->productModel->create($data);
        }
        // FIX: was "index.php?url=admin/products" → goes to homepage
        header("Location: " . BASE_PATH . "/admin/products");
        exit;
    }

    public function edit($id) {
        global $globalSettings;
        $product    = $this->productModel->where('id', (int)$id)->first();
        $categories = $this->categoryModel->get();
        require_once __DIR__ . '/../../views/admin/products/edit.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'        => htmlspecialchars($_POST['name'] ?? ''),
                'price'       => $_POST['price'] ?? 0,
                'stock'       => $_POST['stock'] ?? 0,
                'description' => $_POST['description'] ?? '',
                'category_id' => $_POST['category_id'] ?? null,
            ];
            if (!empty($_POST['slug'])) {
                $data['slug'] = $_POST['slug'];
            }
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $data['image'] = $this->uploadImage($_FILES['image']);
            }
            $this->productModel->update((int)$id, $data);
        }
        header("Location: " . BASE_PATH . "/admin/products");
        exit;
    }

    public function delete($id) {
        $this->productModel->softDelete((int)$id);
        // FIX: was "index.php?url=admin/products"
        header("Location: " . BASE_PATH . "/admin/products");
        exit;
    }

    private function uploadImage($file) {
        $dir = dirname(__DIR__, 2) . '/uploads/products/';
        if (!is_dir($dir)) mkdir($dir, 0777, true);
        $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed  = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (!in_array($ext, $allowed)) return null;
        $filename = time() . '_' . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $dir . $filename)) {
            return 'uploads/products/' . $filename;
        }
        return null;
    }
}
