<?php

/**
 * Quản lý tin nhắn liên hệ phía Admin
 */
class AdminContactController {
    private $contactModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        AuthMiddleware::admin();
        require_once "app/models/ContactModel.php";
        $this->contactModel = new ContactModel($this->conn);
    }

    public function index() {
        $contacts = $this->contactModel->orderBy("created_at", "DESC")->get();
        require_once "views/admin/contacts/index.php";
    }

    /**
     * Cập nhật trạng thái tin nhắn (Mới, Đã đọc, Đã phản hồi)
     */
    public function updateStatus() {
        $id = $_POST['id'];
        $status = $_POST['status'] ?? 'read'; 
        
        $this->contactModel->update($id, [
            'status' => $status
class AdminContactController extends BaseController {
    private $contactModel;
    private const PER_PAGE = 15;

    public function __construct($conn) {
        AuthMiddleware::admin();
        $this->contactModel = new ContactModel($conn);
    }

    public function index() {
        global $globalSettings;
        $page     = max(1, (int)($_GET['page'] ?? 1));
        $offset   = ($page - 1) * self::PER_PAGE;
        $total    = $this->contactModel->countAll();
        $pages    = (int)ceil($total / self::PER_PAGE);
        $contacts = $this->contactModel->getAll(self::PER_PAGE, $offset);

        $this->view('admin/contacts/index', [
            'globalSettings' => $globalSettings,
            'contacts'       => $contacts,
            'page'           => $page,
            'pages'          => $pages,
            'total'          => $total,
        ]);
    }

        header("Location: index.php?url=admin/contacts&success=1");
        exit;
    }

    public function delete($id) {
        $this->contactModel->delete($id);
        header("Location: index.php?url=admin/contacts&deleted=1");
        exit;
    public function updateStatus($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->verifyCsrf();
            $status = $_POST['status'] ?? 'read';
            $this->contactModel->updateStatus((int)$id, $status);
        }
        $this->redirect('/admin/contacts?success=1');
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->verifyCsrf();
        }
        $this->contactModel->delete((int)$id);
        $this->redirect('/admin/contacts?deleted=1');
    }
}
