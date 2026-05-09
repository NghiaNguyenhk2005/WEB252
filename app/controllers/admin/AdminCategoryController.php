<?php

/**
 * Quản lý Danh mục phía Admin
 */
class AdminCategoryController
{
    private $categoryModel;
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
        AuthMiddleware::admin();
        $this->categoryModel = new CategoryModel($this->conn);
    }

    public function index()
    {
        $categories = $this->categoryModel->get();
        require_once "views/admin/categories/index.php";
    }

    /**
     * Lưu danh mục mới
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => htmlspecialchars($_POST['name']),
                'slug' => $_POST['slug'] ?: strtolower(str_replace(' ', '-', $_POST['name'])),
                'parent_id' => $_POST['parent_id'] ?: null
            ];
            $this->categoryModel->create($data);
            header("Location: index.php?url=admin/categories");
            exit;
        }
    }

    public function delete($id)
    {
        $this->categoryModel->delete($id);
        header("Location: index.php?url=admin/categories");
        exit;
    }
}