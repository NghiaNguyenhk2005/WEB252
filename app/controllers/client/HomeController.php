<?php

/**
 * Xử lý luồng dữ liệu cho Trang chủ
 */
class HomeController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function index() {
        // Nạp các Model cần thiết
        require_once "app/models/SliderModel.php";
        require_once "app/models/ProductModel.php";
        require_once "app/models/PostModel.php";
        require_once "app/models/ServiceModel.php";

        $sliderModel = new SliderModel($this->conn);
        $productModel = new ProductModel($this->conn);
        $postModel = new PostModel($this->conn);
        $serviceModel = new ServiceModel($this->conn);

        // Lấy dữ liệu hiển thị
        $sliders = $sliderModel->getActiveSliders();
        $services = $serviceModel->where('status', 1)->limit(3)->get();
        $latestProducts = $productModel->orderBy('created_at', 'DESC')->limit(4)->get();
        $latestPosts = $postModel->where('status', 1)->orderBy('created_at', 'DESC')->limit(3)->get();

        require_once "views/client/home.php";
    }
}