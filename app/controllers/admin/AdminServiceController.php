<?php

class AdminServiceController {
    private $serviceModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        AuthMiddleware::admin();
        $this->serviceModel = new ServiceModel($this->conn);
    }

    public function index() {
        $services = $this->serviceModel->get();
        require_once "views/admin/services/index.php";
    }

    public function create() {
        require_once "views/admin/services/create.php";
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => htmlspecialchars($_POST['name']),
                'slug' => $_POST['slug'] ?: strtolower(str_replace(' ', '-', $_POST['name'])),
                'icon' => htmlspecialchars($_POST['icon']),
                'short_description' => htmlspecialchars($_POST['short_description']),
                'detailed_content' => $_POST['detailed_content'],
                'status' => 1
            ];
            $this->serviceModel->create($data);
            header("Location: " . BASE_PATH . "/admin/services?success=created");
            exit;
        }
    }

    // Edit method - get ID from GET parameter
    public function edit() {
        $id = (int)($_GET['id'] ?? 0);
        
        if (!$id) {
            die('Service ID required');
        }
        
        // Get service by ID
        $stmt = $this->conn->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $service = $stmt->get_result()->fetch_assoc();

        if (!$service) {
            die('Service not found');
        }

        require_once "views/admin/services/edit.php";
    }

    // Update method - get ID from POST data
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_PATH . "/admin/services");
            exit;
        }

        // Get ID from POST data
        $id = (int)($_POST['id'] ?? 0);
        
        if (!$id) {
            die('Service ID required');
        }

        // Get old service
        $stmt = $this->conn->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $oldService = $stmt->get_result()->fetch_assoc();

        if (!$oldService) {
            die('Service not found');
        }

        // Prepare data for update
        $name = htmlspecialchars($_POST['name']);
        $slug = $_POST['slug'] ?: strtolower(str_replace(' ', '-', $name));
        $icon = htmlspecialchars($_POST['icon']);
        $short_description = htmlspecialchars($_POST['short_description']);
        $detailed_content = $_POST['detailed_content'];
        $status = isset($_POST['status']) ? (int)$_POST['status'] : 1;

        // Update query
        $sql = "UPDATE services SET name = ?, slug = ?, icon = ?, short_description = ?, detailed_content = ?, status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssii", $name, $slug, $icon, $short_description, $detailed_content, $status, $id);
        
        if ($stmt->execute()) {
            header("Location: " . BASE_PATH . "/admin/services?success=updated");
        } else {
            header("Location: " . BASE_PATH . "/admin/services?error=update_failed");
        }
        exit;
    }

    // Delete method - get ID from POST data
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_PATH . "/admin/services");
            exit;
        }

        // Get ID from POST data
        $id = (int)($_POST['id'] ?? 0);
        
        if (!$id) {
            $_SESSION['error'] = 'Missing service ID';
            header("Location: " . BASE_PATH . "/admin/services");
            exit;
        }

        // Delete the service
        $result = $this->serviceModel->delete($id);
        
        if ($result) {
            $_SESSION['success'] = 'Service deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete service';
        }

        header("Location: " . BASE_PATH . "/admin/services");
        exit;
    }
}