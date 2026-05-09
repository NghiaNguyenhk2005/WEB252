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
                'name' => $_POST['name'],
                'slug' => $_POST['slug'] ?: strtolower(str_replace(' ', '-', $_POST['name'])),
                'icon' => $_POST['icon'],
                'short_description' => $_POST['short_description'],
                'detailed_content' => $_POST['detailed_content']
            ];
            $this->serviceModel->create($data);
            header("Location: index.php?url=admin/services");
            exit;
        }
    }

    public function delete($id) {
        $this->serviceModel->delete($id);
        header("Location: index.php?url=admin/services");
        exit;
    }
}