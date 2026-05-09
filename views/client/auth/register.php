<?php include __DIR__ . '/../components/header.php'; ?>

<section class="py-5" style="min-height:80vh;display:flex;align-items:center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 p-2">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width:56px;height:56px;">
                                <i class="bi bi-person-plus-fill text-success fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-1">Tạo tài khoản</h4>
                            <p class="text-muted small">Tham gia <?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?> ngay hôm nay</p>
                        </div>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger rounded-3 py-2 small fw-semibold">
                                <i class="bi bi-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="<?= BASE_PATH ?>/register" id="regForm" novalidate>
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Tên hiển thị</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                                    <input type="text" name="username" class="form-control border-start-0 ps-0"
                                           placeholder="Nguyễn Văn A"
                                           value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                                           required minlength="2" maxlength="50">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0 ps-0"
                                           placeholder="you@example.com"
                                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                           required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                    <input type="password" name="password" id="regPwd"
                                           class="form-control border-start-0 ps-0 border-end-0"
                                           placeholder="Tối thiểu 6 ký tự" required minlength="6">
                                    <span class="input-group-text bg-light" style="cursor:pointer;"
                                          onclick="togglePwd('regPwd',this)">
                                        <i class="bi bi-eye text-muted"></i>
                                    </span>
                                </div>
                                <div class="mt-2" id="strengthBar" style="display:none;">
                                    <div class="progress" style="height:4px;border-radius:4px;">
                                        <div class="progress-bar" id="strengthFill" style="width:0%;transition:width .3s;"></div>
                                    </div>
                                    <small class="text-muted" id="strengthLabel"></small>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold small">Xác nhận mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock-fill text-muted"></i></span>
                                    <input type="password" name="confirm_password" id="confirmPwd"
                                           class="form-control border-start-0 ps-0"
                                           placeholder="Nhập lại mật khẩu" required>
                                </div>
                                <small id="pwdMatch" class="d-none text-danger fw-semibold">
                                    <i class="bi bi-x-circle me-1"></i>Mật khẩu không khớp
                                </small>
                            </div>
                            <button type="submit" class="btn btn-gradient w-100 rounded-pill py-2 fw-bold">
                                Tạo tài khoản
                            </button>
                        </form>

                        <p class="text-center text-muted small mt-4 mb-0">
                            Đã có tài khoản?
                            <a href="<?= BASE_PATH ?>/login" class="text-primary fw-semibold text-decoration-none">Đăng nhập</a>
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
document.getElementById('regPwd').addEventListener('input', function() {
    const v = this.value;
    const bar = document.getElementById('strengthBar');
    const fill = document.getElementById('strengthFill');
    const label = document.getElementById('strengthLabel');
    if (!v) { bar.style.display = 'none'; return; }
    bar.style.display = 'block';
    let score = 0;
    if (v.length >= 6) score++;
    if (v.length >= 10) score++;
    if (/[A-Z]/.test(v)) score++;
    if (/[0-9]/.test(v)) score++;
    if (/[^A-Za-z0-9]/.test(v)) score++;
    const levels = [
        {w:'20%',cls:'bg-danger',  txt:'Rất yếu'},
        {w:'40%',cls:'bg-warning', txt:'Yếu'},
        {w:'60%',cls:'bg-info',    txt:'Trung bình'},
        {w:'80%',cls:'bg-primary', txt:'Mạnh'},
        {w:'100%',cls:'bg-success',txt:'Rất mạnh'},
    ];
    const l = levels[Math.min(score - 1, 4)] || levels[0];
    fill.style.width = l.w;
    fill.className   = 'progress-bar ' + l.cls;
    label.textContent = l.txt;
});
document.getElementById('confirmPwd').addEventListener('input', function() {
    const match = document.getElementById('pwdMatch');
    (this.value && this.value !== document.getElementById('regPwd').value)
        ? match.classList.remove('d-none')
        : match.classList.add('d-none');
});
document.getElementById('regForm').addEventListener('submit', function(e) {
    if (document.getElementById('regPwd').value !== document.getElementById('confirmPwd').value) {
        e.preventDefault();
        document.getElementById('pwdMatch').classList.remove('d-none');
    }
});
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>
