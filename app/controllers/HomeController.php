<?php
require_once __DIR__ . '/../core/SEO.php';
require_once __DIR__ . '/../core/SEOTrait.php';

class HomeController extends BaseController {
    use SEOTrait;
    
    private $sliderModel;
    private $conn;

    public function __construct($conn) {
        $this->conn        = $conn;
        $this->sliderModel = new SliderModel($conn);
    }

    public function index() {
        global $globalSettings;
        
        // Set SEO for homepage
        $this->setPageSEO('home');
        
        // Get active sliders
        $activeSliders = $this->sliderModel->getActive();

        // Latest products — null-safe if table empty
        $latestProducts = null;
        $res = $this->conn->query(
            "SELECT * FROM products WHERE deleted_at IS NULL ORDER BY created_at DESC LIMIT 4"
        );
        if ($res && $res->num_rows > 0) $latestProducts = $res;

        // Latest posts — null-safe if table empty
        $latestPosts = null;
        $res = $this->conn->query(
            "SELECT * FROM posts WHERE status = 1 AND deleted_at IS NULL ORDER BY created_at DESC LIMIT 3"
        );
        if ($res && $res->num_rows > 0) $latestPosts = $res;

        $this->view('client/home', [
            'globalSettings' => $globalSettings,
            'activeSliders'  => $activeSliders,
            'latestProducts' => $latestProducts,
            'latestPosts'    => $latestPosts,
        ]);
    }
}