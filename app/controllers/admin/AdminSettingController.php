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
        $globalSettings = $this->settingModel->getAllSettings();
        $sliders        = $this->sliderModel->getAll();
        $this->view('admin/settings/index', [
            'globalSettings' => $globalSettings,
            'sliders'        => $sliders,
        ]);
    }

    public function update() {
        AuthMiddleware::admin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/settings');
        }

        $adminId = $_SESSION['user']['id'];

        $textFields = [
            'site_name'       => htmlspecialchars(trim($_POST['site_name'] ?? '')),
            'company_phone'   => htmlspecialchars(trim($_POST['company_phone'] ?? '')),
            'company_email'   => filter_var($_POST['company_email'] ?? '', FILTER_SANITIZE_EMAIL),
            'company_address' => htmlspecialchars(trim($_POST['company_address'] ?? '')),
        ];

        foreach ($textFields as $key => $value) {
            if ($value !== '') {
                $this->settingModel->updateByKey($key, $value, $adminId);
            }
        }

        // Logo upload
        if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
            $ext     = strtolower(pathinfo($_FILES['site_logo']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];
            if (in_array($ext, $allowed)) {
                $dir = 'uploads/system/';
                if (!is_dir($dir)) mkdir($dir, 0777, true);
                $filename = 'logo_' . time() . '.' . $ext;
                if (move_uploaded_file($_FILES['site_logo']['tmp_name'], $dir . $filename)) {
                    $this->settingModel->updateByKey('site_logo', $dir . $filename, $adminId);
                }
            }
        }

        $this->redirect('/admin/settings?success=1');
    }

    // ── Slider CRUD ──────────────────────────────────────────

    public function sliderCreate() {
        AuthMiddleware::admin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/settings');
        }

        $adminId  = $_SESSION['user']['id'];
        $title    = htmlspecialchars(trim($_POST['title'] ?? ''));
        $subtitle = htmlspecialchars(trim($_POST['subtitle'] ?? ''));
        $btnText  = htmlspecialchars(trim($_POST['button_text'] ?? ''));
        $btnLink  = htmlspecialchars(trim($_POST['button_link'] ?? ''));
        $order    = (int)($_POST['display_order'] ?? 0);

        $imageUrl = '';
        if (isset($_FILES['slider_image']) && $_FILES['slider_image']['error'] === UPLOAD_ERR_OK) {
            $ext     = strtolower(pathinfo($_FILES['slider_image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            if (in_array($ext, $allowed)) {
                $dir = 'uploads/sliders/';
                if (!is_dir($dir)) mkdir($dir, 0777, true);
                $filename = 'slide_' . time() . '.' . $ext;
                if (move_uploaded_file($_FILES['slider_image']['tmp_name'], $dir . $filename)) {
                    $imageUrl = $dir . $filename;
                }
            }
        }

        if ($imageUrl) {
            $this->sliderModel->create([
                'image_url'     => $imageUrl,
                'title'         => $title,
                'subtitle'      => $subtitle,
                'button_text'   => $btnText,
                'button_link'   => $btnLink,
                'display_order' => $order,
                'status'        => 1,
                'author_id'     => $adminId,
            ]);
        }

        $this->redirect('/admin/settings?success=1#sliders');
    }

    public function sliderDelete($id) {
        AuthMiddleware::admin();
        $this->sliderModel->delete((int)$id);
        $this->redirect('/admin/settings?deleted=1#sliders');
    }

    public function sliderToggle($id) {
        AuthMiddleware::admin();
        $slider = $this->sliderModel->where('id', (int)$id)->first();
        if ($slider) {
            $newStatus = $slider['status'] == 1 ? 0 : 1;
            $this->sliderModel->toggleStatus((int)$id, $newStatus);
        }
        $this->redirect('/admin/settings?success=1#sliders');
    }
}
