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
        require_once __DIR__ . '/../../../views/admin/products/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_PATH . "/admin/products");
            exit;
        }

        $name        = trim($_POST['name'] ?? '');
        $slug        = trim($_POST['slug'] ?? '');
        $price       = (float)($_POST['price'] ?? 0);
        $stock       = (int)($_POST['stock'] ?? 0);
        $category_id = (int)($_POST['category_id'] ?? 0);
        $description = trim($_POST['description'] ?? '');

        // AUTO CREATE SLUG
        if (empty($slug)) {
            $slug = strtolower(
                trim(
                    preg_replace('/[^A-Za-z0-9]+/', '-', $name),
                    '-'
                )
            );
        }

        // DEFAULT IMAGE
        $image = '';

        // UPLOAD IMAGE
        if (
            isset($_FILES['image']) &&
            !empty($_FILES['image']['name'])
        ) {
            $uploadDir = 'uploads/products/';

            // CREATE FOLDER IF NOT EXISTS
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $ext = strtolower(
                pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)
            );

            $fileName = time() . '_' . uniqid() . '.' . $ext;

            $target = $uploadDir . $fileName;

            if (
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    $target
                )
            ) {
                $image = $target;
            }
        }

        // INSERT PRODUCT
        $sql = "
            INSERT INTO products (
                name,
                slug,
                price,
                stock,
                category_id,
                image,
                description,
                created_at
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die('SQL Prepare Error: ' . $this->conn->error);
        }

        $stmt->bind_param(
            "ssdiiss",
            $name,
            $slug,
            $price,
            $stock,
            $category_id,
            $image,
            $description
        );

        if (!$stmt->execute()) {
            die('SQL Execute Error: ' . $stmt->error);
        }

        header("Location: " . BASE_PATH . "/admin/products?success=created");
        exit;
    }

    public function edit() {
        // Get ID from GET parameter (for displaying the form)
        $id = (int)($_GET['id'] ?? 0);
        
        if (!$id) {
            die('Product ID required');
        }
        
        // Get product details
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();

        if (!$product) {
            die('Product not found');
        }

        // Get categories for dropdown
        $categoriesResult = $this->categoryModel->get();
        $categories = [];
        while($row = $categoriesResult->fetch_assoc()) {
            $categories[] = $row;
        }

        require_once __DIR__ . '/../../../views/admin/products/edit.php';
    }
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_PATH . "/admin/products");
            exit;
        }

        // Get ID from POST data
        $id = (int)($_POST['id'] ?? 0);
        
        if (!$id) {
            die('Product ID required');
        }

        // GET OLD PRODUCT
        $sqlOld = "SELECT * FROM products WHERE id = ? LIMIT 1";
        $stmtOld = $this->conn->prepare($sqlOld);

        if (!$stmtOld) {
            die('Prepare Error: ' . $this->conn->error);
        }

        $stmtOld->bind_param("i", $id);
        $stmtOld->execute();
        $oldProduct = $stmtOld->get_result()->fetch_assoc();

        if (!$oldProduct) {
            die('Product not found');
        }

        // FORM DATA
        $name        = trim($_POST['name'] ?? '');
        $slug        = trim($_POST['slug'] ?? '');
        $price       = (float)($_POST['price'] ?? 0);
        $stock       = (int)($_POST['stock'] ?? 0);
        $category_id = (int)($_POST['category_id'] ?? 0);
        $description = trim($_POST['description'] ?? '');

        // AUTO SLUG
        if (empty($slug)) {
            $slug = strtolower(
                trim(
                    preg_replace('/[^A-Za-z0-9]+/', '-', $name),
                    '-'
                )
            );
        }

        // KEEP OLD IMAGE
        $image = $oldProduct['image'];

        // UPLOAD NEW IMAGE
        if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
            $uploadDir = 'uploads/products/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $fileName = time() . '_' . uniqid() . '.' . $ext;
            $target = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                // DELETE OLD IMAGE
                if (!empty($oldProduct['image']) && file_exists($oldProduct['image'])) {
                    unlink($oldProduct['image']);
                }
                $image = $target;
            }
        }

        // UPDATE QUERY
        $sql = "UPDATE products SET name = ?, slug = ?, price = ?, stock = ?, category_id = ?, image = ?, description = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die('Prepare Error: ' . $this->conn->error);
        }

        $stmt->bind_param("ssdiissi", $name, $slug, $price, $stock, $category_id, $image, $description, $id);

        if (!$stmt->execute()) {
            die('Execute Error: ' . $stmt->error);
        }

        header("Location: " . BASE_PATH . "/admin/products?success=updated");
        exit;
    }
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_PATH . "/admin/products");
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);

        if (!$id) {
            $_SESSION['error'] = 'Missing product ID';
            header("Location: " . BASE_PATH . "/admin/products");
            exit;
        }

        // Get product image
        $stmt = $this->conn->prepare("SELECT image FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();
        
        // 1. Delete from cart_items
        $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // 2. Update order_items to set product_id = NULL (preserve order history)
        $stmt = $this->conn->prepare("UPDATE order_items SET product_id = NULL WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // 3. Delete from product_comments
        $stmt = $this->conn->prepare("DELETE FROM product_comments WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // 4. Delete image file
        if ($product && !empty($product['image']) && file_exists($product['image'])) {
            unlink($product['image']);
        }
        
        // 5. Delete product
        $result = $this->productModel->delete($id);
        
        if ($result) {
            $_SESSION['success'] = 'Product deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete product';
        }

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
?>