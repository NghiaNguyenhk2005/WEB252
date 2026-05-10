<?php include __DIR__ . '/../components/header.php'; ?>

<section class="py-5" style="min-height:80vh;display:flex;align-items:center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

                <?php if (isset($_GET['registered'])): ?>
                    <div class="alert alert-success rounded-3 mb-4 text-center fw-semibold">
                        <i class="bi bi-check-circle me-2"></i>Đăng ký thành công! Hãy đăng nhập.
                    </div>
                <?php endif; ?>
                <?php if (isset($_GET['reset_success'])): ?>
                    <div class="alert alert-success rounded-3 mb-4 text-center fw-semibold">
                        <i class="bi bi-check-circle me-2"></i>Mật khẩu đã được cập nhật thành công!
                    </div>
                <?php endif; ?>

                <div class="card border-0 shadow-lg rounded-4 p-2">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width:56px;height:56px;">
                                <i class="bi bi-person-fill text-primary fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-1">Đăng nhập</h4>
                            <p class="text-muted small">Chào mừng trở lại!</p>
                        </div>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger rounded-3 py-2 small fw-semibold">
                                <i class="bi bi-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="<?= BASE_PATH ?>/login" novalidate>
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope text-muted"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control border-start-0 ps-0"
                                           placeholder="you@example.com"
                                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-semibold small">Mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input type="password" name="password" id="loginPwd"
                                           class="form-control border-start-0 ps-0 border-end-0"
                                           placeholder="••••••••" required>
                                    <span class="input-group-text bg-light" style="cursor:pointer;"
                                          onclick="togglePwd('loginPwd',this)">
                                        <i class="bi bi-eye text-muted"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-4 text-end">
                                <a href="<?= BASE_PATH ?>/forgot-password" class="small text-muted text-decoration-none">
                                    Quên mật khẩu?
                                </a>
                            </div>
                            <button type="submit" class="btn btn-gradient w-100 rounded-pill py-2 fw-bold">
                                Đăng nhập
                            </button>
                        </form>

                        <p class="text-center text-muted small mt-4 mb-0">
                            Chưa có tài khoản?
                            <a href="<?= BASE_PATH ?>/register" class="text-primary fw-semibold text-decoration-none">Đăng ký ngay</a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
function togglePwd(id, btn) {
    const input = document.getElementById(id);
    const icon  = btn.querySelector('i');
    input.type  = input.type === 'password' ? 'text' : 'password';
    icon.className = input.type === 'password' ? 'bi bi-eye text-muted' : 'bi bi-eye-slash text-muted';
}
document.querySelector('form').addEventListener('submit', function(e) {
    const email = this.querySelector('[name=email]').value.trim();
    const pwd   = this.querySelector('[name=password]').value;
    if (!email || !pwd) { e.preventDefault(); alert('Vui lòng điền đầy đủ thông tin.'); }
});
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>
