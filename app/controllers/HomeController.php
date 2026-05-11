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
    public function about() {
        // Fetch fresh settings directly from database
        $settingModel = new SettingModel($this->conn);
        $settings = $settingModel->getAllSettings();
        
        // Debug: Check what we're getting
        // echo '<pre>'; print_r($settings); echo '</pre>'; exit;
        
        $aboutContent = [
            'title' => $settings['about_title'] ?? 'Về chúng tôi',
            'subtitle' => $settings['about_subtitle'] ?? 'Kiến tạo giải pháp công nghệ đột phá cho doanh nghiệp Việt Nam',
            'company_name' => $settings['about_company_name'] ?? 'TechSaaS',
            'content' => $settings['about_content'] ?? '<p>Chúng tôi cung cấp các giải pháp SaaS (Software as a Service) hiện đại, giúp doanh nghiệp tối ưu hóa quy trình vận hành và tăng trưởng bền vững.</p><p>Với đội ngũ chuyên gia giàu kinh nghiệm, chúng tôi cam kết mang đến những sản phẩm chất lượng cao, bảo mật tuyệt đối và hỗ trợ khách hàng 24/7.</p>',
            'mission' => $settings['about_mission'] ?? 'Kiến tạo giải pháp công nghệ đột phá, giúp doanh nghiệp Việt Nam vươn tầm quốc tế.',
            'vision' => $settings['about_vision'] ?? 'Trở thành nhà cung cấp giải pháp SaaS hàng đầu Đông Nam Á vào năm 2030.',
            'stat_customers' => $settings['about_stat_customers'] ?? '500',
            'stat_experts' => $settings['about_stat_experts'] ?? '50',
            'stat_support' => $settings['about_stat_support'] ?? '24/7',
            'stat_uptime' => $settings['about_stat_uptime'] ?? '99.9',
            'values' => json_decode($settings['about_values'] ?? '[]', true)
        ];
        
        // If values is empty, set defaults
        if (empty($aboutContent['values'])) {
            $aboutContent['values'] = [
                ['icon' => 'fa-solid fa-rocket', 'title' => 'Đổi mới sáng tạo', 'desc' => 'Không ngừng cải tiến và phát triển các giải pháp công nghệ tiên tiến nhất'],
                ['icon' => 'fa-solid fa-handshake', 'title' => 'Đồng hành cùng khách hàng', 'desc' => 'Lắng nghe và thấu hiểu để mang lại giá trị tốt nhất'],
                ['icon' => 'fa-solid fa-shield', 'title' => 'An toàn - Bảo mật', 'desc' => 'Bảo vệ dữ liệu khách hàng là ưu tiên hàng đầu'],
                ['icon' => 'fa-solid fa-chart-line', 'title' => 'Phát triển bền vững', 'desc' => 'Hướng đến sự phtr lâu dài cùng đối tác']
            ];
        }
        
        require_once "views/client/about.php";
    }
}