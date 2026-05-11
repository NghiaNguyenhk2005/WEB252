<?php

require_once __DIR__ . '/../../core/SEO.php';
require_once __DIR__ . '/../../core/SEOTrait.php';

/**
 * Hiển thị danh sách và chi tiết các giải pháp doanh nghiệp
 */
class ServiceController {
    use SEOTrait;
    
    private $serviceModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->serviceModel = new ServiceModel($this->conn);
    }

    public function index() {
        global $globalSettings;
        
        // Set SEO for services listing page
        $this->setPageSEO('services');
        
        $services = $this->serviceModel->where('status', 1)->get();
        require_once "views/client/services/index.php";
    }

    public function show($slug) {
        global $globalSettings;
        
        $service = $this->serviceModel->where('slug', $slug)->where('status', 1)->first();
        
        if (!$service) {
            header("Location: " . BASE_PATH . "/services");
            exit;
        }
        
        // Set SEO for service detail page
        $this->setPageSEO('service', $service);
        
        require_once "views/client/services/detail.php";
    }
}