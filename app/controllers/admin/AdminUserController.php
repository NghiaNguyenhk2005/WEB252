<?php
class AdminUserController extends BaseController {
    private $userModel;
    private const PER_PAGE = 15;

    public function __construct($conn) {
        AuthMiddleware::admin();
        $this->userModel = new UserModel($conn);
    }

    public function index() {
        global $globalSettings;
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $offset = ($page - 1) * self::PER_PAGE;
        $total  = $this->userModel->countAll();
        $pages  = (int)ceil($total / self::PER_PAGE);
        $users  = $this->userModel->getAllWithRoles(self::PER_PAGE, $offset);

        $this->view('admin/users/index', [
            'globalSettings' => $globalSettings,
            'users'          => $users,
            'page'           => $page,
            'pages'          => $pages,
            'total'          => $total,
        ]);
    }

    public function toggleStatus($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->verifyCsrf();
            $status = (int)($_POST['status'] ?? 1);
            $this->userModel->setStatus((int)$id, $status);
        }
        $this->redirect('/admin/users?success=1');
    }

    public function resetPassword($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->verifyCsrf();
            $newPass = $_POST['new_password'] ?? '';
            if (strlen($newPass) >= 6) {
                $this->userModel->resetPassword((int)$id, $newPass);
                $this->redirect('/admin/users?reset=1');
            } else {
                $this->redirect('/admin/users?error=password_short');
            }
        }
        $this->redirect('/admin/users');
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->verifyCsrf();
        }
        $this->userModel->delete((int)$id);
        $this->redirect('/admin/users?deleted=1');
    }
}
