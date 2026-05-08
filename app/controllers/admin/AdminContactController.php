<?php
class AdminContactController extends BaseController {
    private $contactModel;
    private const PER_PAGE = 15;

    public function __construct($conn) {
        AuthMiddleware::admin();
        $this->contactModel = new ContactModel($conn);
    }

    public function index() {
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $offset = ($page - 1) * self::PER_PAGE;
        $total  = $this->contactModel->countAll();
        $pages  = (int)ceil($total / self::PER_PAGE);

        $contacts = $this->contactModel->getAll(self::PER_PAGE, $offset);

        $this->view('admin/contacts/index', [
            'contacts' => $contacts,
            'page'     => $page,
            'pages'    => $pages,
            'total'    => $total,
        ]);
    }

    public function updateStatus($id) {
        AuthMiddleware::admin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? 'read';
            $this->contactModel->updateStatus((int)$id, $status);
        }
        $this->redirect('/admin/contacts?success=1');
    }

    public function delete($id) {
        AuthMiddleware::admin();
        $this->contactModel->delete((int)$id);
        $this->redirect('/admin/contacts?deleted=1');
    }
}
