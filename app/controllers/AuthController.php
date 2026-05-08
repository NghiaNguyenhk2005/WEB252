<?php
class AuthController extends BaseController {
    private $authModel;

    public function __construct($conn) {
        $this->authModel = new AuthModel($conn);
    }

    // ─── REGISTER ────────────────────────────────────────────
    public function register() {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars(trim($_POST['username'] ?? ''));
            $email    = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            $confirm  = $_POST['confirm_password'] ?? '';

            // Server-side validation
            if (empty($username) || empty($email) || empty($password)) {
                $error = 'Vui lòng điền đầy đủ thông tin.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Email không hợp lệ.';
            } elseif (strlen($password) < 6) {
                $error = 'Mật khẩu phải có ít nhất 6 ký tự.';
            } elseif ($password !== $confirm) {
                $error = 'Xác nhận mật khẩu không khớp.';
            } elseif ($this->authModel->findByEmail($email)) {
                $error = 'Email này đã được đăng ký.';
            } else {
                $this->authModel->createUser([
                    'username'   => $username,
                    'email'      => $email,
                    'password'   => $password,
                    'status'     => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                $this->redirect('/login?registered=1');
            }
        }

        $this->view('client/auth/register', ['error' => $error]);
    }

    // ─── LOGIN ────────────────────────────────────────────────
    public function login() {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = 'Vui lòng nhập email và mật khẩu.';
            } else {
                $user = $this->authModel->findByEmail($email);

                if ($user && password_verify($password, $user['password'])) {
                    if ($user['status'] == 0) {
                        $error = 'Tài khoản của bạn đã bị khoá.';
                    } else {
                        // Get role
                        $roleResult = $this->authModel->conn->query(
                            "SELECT r.name FROM roles r
                             INNER JOIN user_roles ur ON r.id = ur.role_id
                             WHERE ur.user_id = {$user['id']}
                             LIMIT 1"
                        );
                        $roleRow = $roleResult ? $roleResult->fetch_assoc() : null;
                        $user['role'] = $roleRow['name'] ?? 'member';

                        $_SESSION['user'] = $user;

                        if ($user['role'] === 'admin') {
                            $this->redirect('/admin/contacts');
                        } else {
                            $this->redirect('/');
                        }
                    }
                } else {
                    $error = 'Email hoặc mật khẩu không đúng.';
                }
            }
        }

        $this->view('client/auth/login', ['error' => $error]);
    }

    // ─── LOGOUT ───────────────────────────────────────────────
    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }

    // ─── PROFILE ──────────────────────────────────────────────
    public function profile() {
        AuthMiddleware::check();
        $error   = '';
        $success = '';
        $user    = $this->authModel->findById($_SESSION['user']['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            if ($action === 'update_info') {
                $username = htmlspecialchars(trim($_POST['username'] ?? ''));
                if (empty($username)) {
                    $error = 'Tên không được để trống.';
                } else {
                    // Handle avatar upload
                    $avatarPath = $user['avatar'];
                    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                        $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
                        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                        if (in_array($ext, $allowed)) {
                            $dir = 'uploads/avatars/';
                            if (!is_dir($dir)) mkdir($dir, 0777, true);
                            $filename = 'avatar_' . $_SESSION['user']['id'] . '_' . time() . '.' . $ext;
                            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $dir . $filename)) {
                                $avatarPath = $dir . $filename;
                            }
                        }
                    }

                    $this->authModel->update($_SESSION['user']['id'], [
                        'username' => $username,
                        'avatar'   => $avatarPath,
                    ]);

                    // Refresh session
                    $_SESSION['user']['username'] = $username;
                    $_SESSION['user']['avatar']   = $avatarPath;
                    $user = $this->authModel->findById($_SESSION['user']['id']);
                    $success = 'Cập nhật thông tin thành công.';
                }

            } elseif ($action === 'change_password') {
                $current = $_POST['current_password'] ?? '';
                $new     = $_POST['new_password'] ?? '';
                $confirm = $_POST['confirm_password'] ?? '';

                if (!password_verify($current, $user['password'])) {
                    $error = 'Mật khẩu hiện tại không đúng.';
                } elseif (strlen($new) < 6) {
                    $error = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
                } elseif ($new !== $confirm) {
                    $error = 'Xác nhận mật khẩu không khớp.';
                } else {
                    $this->authModel->update($_SESSION['user']['id'], [
                        'password' => password_hash($new, PASSWORD_DEFAULT),
                    ]);
                    $success = 'Đổi mật khẩu thành công.';
                }
            }
        }

        $this->view('client/auth/profile', [
            'user'    => $user,
            'error'   => $error,
            'success' => $success,
        ]);
    }
}
