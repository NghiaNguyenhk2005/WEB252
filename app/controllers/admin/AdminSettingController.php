<?php
class AdminSettingController extends BaseController {
    private $settingModel;
    private $sliderModel;

    public function __construct($conn) {
        AuthMiddleware::admin();
        $this->settingModel = new SettingModel($conn);
        $this->sliderModel  = new SliderModel($conn);
    }

    public function index() {
        global $globalSettings;
        $globalSettings = $this->settingModel->getAllSettings();
        $sliders        = $this->sliderModel->getAll();
        $this->view('admin/settings/index', [
            'globalSettings' => $globalSettings,
            'sliders'        => $sliders,
        ]);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/settings');
        }
        $this->verifyCsrf();

        $adminId    = (int)$_SESSION['user']['id'];
        $textFields = [
            'site_name'       => htmlspecialchars(trim($_POST['site_name']       ?? '')),
            'company_phone'   => htmlspecialchars(trim($_POST['company_phone']   ?? '')),
            'company_email'   => filter_var($_POST['company_email'] ?? '', FILTER_SANITIZE_EMAIL),
            'company_address' => htmlspecialchars(trim($_POST['company_address'] ?? '')),
        ];
        foreach ($textFields as $key => $value) {
            if ($value !== '') {
                $this->settingModel->updateByKey($key, $value, $adminId);
            }
        }

        // Logo upload — absolute path
        if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
            $ext     = strtolower(pathinfo($_FILES['site_logo']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];
            if (in_array($ext, $allowed)) {
                $dir = dirname(__DIR__, 2) . '/uploads/system/';
                if (!is_dir($dir)) mkdir($dir, 0777, true);
                $filename = 'logo_' . time() . '.' . $ext;
                if (move_uploaded_file($_FILES['site_logo']['tmp_name'], $dir . $filename)) {
                    $this->settingModel->updateByKey('site_logo', 'uploads/system/' . $filename, $adminId);
                }
            }
        }

        $this->redirect('/admin/settings?success=1');
    }

    // ── Slider CRUD ───────────────────────────────────────────

    public function sliderCreate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/settings');
        }
        $this->verifyCsrf();

        $adminId  = (int)$_SESSION['user']['id'];
        $imageUrl = '';

        if (isset($_FILES['slider_image']) && $_FILES['slider_image']['error'] === UPLOAD_ERR_OK) {
            $ext     = strtolower(pathinfo($_FILES['slider_image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            if (in_array($ext, $allowed)) {
                $dir = dirname(__DIR__, 2) . '/uploads/sliders/';
                if (!is_dir($dir)) mkdir($dir, 0777, true);
                $filename = 'slide_' . time() . '.' . $ext;
                if (move_uploaded_file($_FILES['slider_image']['tmp_name'], $dir . $filename)) {
                    $imageUrl = 'uploads/sliders/' . $filename;
                }
            }
        }

        if ($imageUrl) {
            $this->sliderModel->create([
                'image_url'     => $imageUrl,
                'title'         => htmlspecialchars(trim($_POST['title']       ?? '')),
                'subtitle'      => htmlspecialchars(trim($_POST['subtitle']    ?? '')),
                'button_text'   => htmlspecialchars(trim($_POST['button_text'] ?? '')),
                'button_link'   => htmlspecialchars(trim($_POST['button_link'] ?? '')),
                'display_order' => (int)($_POST['display_order'] ?? 0),
                'status'        => 1,
                'author_id'     => $adminId,
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
        }

        $this->redirect('/admin/settings?success=1');
    }

    public function sliderDelete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $this->verifyCsrf();
        $this->sliderModel->delete((int)$id);
        $this->redirect('/admin/settings?deleted=1');
    }

    public function sliderToggle($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $this->verifyCsrf();
        $slider = $this->sliderModel->where('id', (int)$id)->first();
        if ($slider) {
            $this->sliderModel->toggleStatus((int)$id, $slider['status'] == 1 ? 0 : 1);
        }
        $this->redirect('/admin/settings?success=1');
    }

    public function about() {
        global $globalSettings;
        
        // Get about settings
        $aboutSettings = [
            'title' => $this->settingModel->getByKey('about_title') ?? 'Về chúng tôi',
            'subtitle' => $this->settingModel->getByKey('about_subtitle') ?? '',
            'company_name' => $this->settingModel->getByKey('about_company_name') ?? 'TechSaaS',
            'content' => $this->settingModel->getByKey('about_content') ?? '',
            'mission' => $this->settingModel->getByKey('about_mission') ?? '',
            'vision' => $this->settingModel->getByKey('about_vision') ?? '',
            'stat_customers' => $this->settingModel->getByKey('about_stat_customers') ?? '500+',
            'stat_experts' => $this->settingModel->getByKey('about_stat_experts') ?? '50+',
            'stat_uptime' => $this->settingModel->getByKey('about_stat_uptime') ?? '99.9%',
            'values' => json_decode($this->settingModel->getByKey('about_values') ?? '[]', true)
        ];
        
        require_once "views/admin/settings/about.php";
    }
    public function updateAbout() {
        // Log for debugging
        error_log('=== updateAbout method called ===');
        error_log('POST data: ' . print_r($_POST, true));
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_PATH . "/admin/settings");
            exit;
        }

        $adminId = (int)$_SESSION['user']['id'];

        // Update all about settings
        $this->settingModel->updateByKey('about_title', $_POST['title'] ?? 'Về chúng tôi', $adminId);
        $this->settingModel->updateByKey('about_subtitle', $_POST['subtitle'] ?? '', $adminId);
        $this->settingModel->updateByKey('about_company_name', $_POST['company_name'] ?? 'TechSaaS', $adminId);
        $this->settingModel->updateByKey('about_content', $_POST['content'] ?? '', $adminId);
        $this->settingModel->updateByKey('about_mission', $_POST['mission'] ?? '', $adminId);
        $this->settingModel->updateByKey('about_vision', $_POST['vision'] ?? '', $adminId);
        
        // Statistics
        $this->settingModel->updateByKey('about_stat_customers', $_POST['stat_customers'] ?? '500+', $adminId);
        $this->settingModel->updateByKey('about_stat_experts', $_POST['stat_experts'] ?? '50+', $adminId);
        $this->settingModel->updateByKey('about_stat_support', $_POST['stat_support'] ?? '24/7', $adminId);
        $this->settingModel->updateByKey('about_stat_uptime', $_POST['stat_uptime'] ?? '99.9%', $adminId);
        
        // Values (JSON)
        if (isset($_POST['value_title']) && is_array($_POST['value_title'])) {
            $values = [];
            for ($i = 0; $i < count($_POST['value_title']); $i++) {
                if (!empty($_POST['value_title'][$i])) {
                    $values[] = [
                        'icon' => $_POST['value_icon'][$i] ?? 'fa-solid fa-rocket',
                        'title' => $_POST['value_title'][$i],
                        'desc' => $_POST['value_desc'][$i] ?? ''
                    ];
                }
            }
            $this->settingModel->updateByKey('about_values', json_encode($values, JSON_UNESCAPED_UNICODE), $adminId);
        }

        error_log('About settings updated successfully');
        $_SESSION['success'] = 'Cập nhật nội dung Giới thiệu thành công!';
        header("Location: " . BASE_PATH . "/admin/settings?success=1#about");
        exit;
    }
}
