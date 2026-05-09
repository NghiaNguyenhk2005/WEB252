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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { $this->redirect('/admin/settings'); }
        $this->verifyCsrf();

        $adminId    = (int)$_SESSION['user']['id'];
        $textFields = [
            'site_name'       => htmlspecialchars(trim($_POST['site_name'] ?? '')),
            'company_phone'   => htmlspecialchars(trim($_POST['company_phone'] ?? '')),
            'company_email'   => filter_var($_POST['company_email'] ?? '', FILTER_SANITIZE_EMAIL),
            'company_address' => htmlspecialchars(trim($_POST['company_address'] ?? '')),
        ];
        foreach ($textFields as $key => $value) {
            if ($value !== '') $this->settingModel->updateByKey($key, $value, $adminId);
        }

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

    public function sliderCreate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { $this->redirect('/admin/settings'); }
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
                'title'         => htmlspecialchars(trim($_POST['title'] ?? '')),
                'subtitle'      => htmlspecialchars(trim($_POST['subtitle'] ?? '')),
                'button_text'   => htmlspecialchars(trim($_POST['button_text'] ?? '')),
                'button_link'   => htmlspecialchars(trim($_POST['button_link'] ?? '')),
                'display_order' => (int)($_POST['display_order'] ?? 0),
                'status'        => 1,
                'author_id'     => $adminId,
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
        }
        $this->redirect('/admin/settings?success=1#sliders');
    }

    public function sliderDelete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $this->verifyCsrf();
        $this->sliderModel->delete((int)$id);
        $this->redirect('/admin/settings?deleted=1#sliders');
    }

    public function sliderToggle($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $this->verifyCsrf();
        $slider = $this->sliderModel->where('id', (int)$id)->first();
        if ($slider) {
            $this->sliderModel->toggleStatus((int)$id, $slider['status'] == 1 ? 0 : 1);
        }
        $this->redirect('/admin/settings?success=1#sliders');
    }
}
