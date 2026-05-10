<?php

/**
 * Hiển thị danh sách và chi tiết các giải pháp doanh nghiệp
 */
class ServiceController {
    private $serviceModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->serviceModel = new ServiceModel($this->conn);
    }

    public function index() {
        $services = $this->serviceModel->where('status', 1)->get();
        require_once "views/client/services/index.php";
    }

    public function show($slug) {
        $service = $this->serviceModel->where('slug', $slug)->where('status', 1)->first();
        if (!$service) {
            header("Location: index.php?url=services");
            exit;
        }
        require_once "views/client/services/detail.php";
    }
}