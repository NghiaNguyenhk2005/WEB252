<?php include __DIR__ . '/../components/header.php'; ?>

<section class="py-5" style="min-height:80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:52px;height:52px;">
                        <i class="bi bi-person-gear text-primary fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">Thông tin cá nhân</h4>
                        <p class="text-muted small mb-0">Quản lý hồ sơ và bảo mật tài khoản</p>
                    </div>
                </div>

                <?php if (!empty($success)): ?>
                    <div class="alert alert-success rounded-3 fw-semibold small">
                        <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger rounded-3 fw-semibold small">
                        <i class="bi bi-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <div class="row g-4">
                    <!-- Update Info -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-4"><i class="bi bi-pencil-square me-2 text-primary"></i>Cập nhật thông tin</h6>
                                <form method="POST" action="<?= BASE_PATH ?>/profile" enctype="multipart/form-data">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="action" value="update_info">
                                    <div class="text-center mb-4">
                                        <div class="position-relative d-inline-block">
                                            <?php if (!empty($user['avatar'])): ?>
                                                <img src="<?= BASE_PATH ?>/<?= htmlspecialchars($user['avatar']) ?>"
                                                     id="avatarPreview"
                                                     class="rounded-circle border border-3 border-primary"
                                                     style="width:90px;height:90px;object-fit:cover;">
                                            <?php else: ?>
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center border border-3 border-primary"
                                                     id="avatarPreview"
                                                     style="width:90px;height:90px;font-size:2rem;font-weight:700;">
                                                    <?= strtoupper(substr($user['username'], 0, 1)) ?>
                                                </div>
                                            <?php endif; ?>
                                            <label for="avatarInput"
                                                   class="position-absolute bottom-0 end-0 bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                                   style="width:28px;height:28px;cursor:pointer;">
                                                <i class="bi bi-camera-fill text-white" style="font-size:.7rem;"></i>
                                            </label>
                                        </div>
                                        <input type="file" id="avatarInput" name="avatar" class="d-none" accept="image/*">
                                        <p class="text-muted small mt-2 mb-0">Nhấn vào biểu tượng máy ảnh để đổi ảnh</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Tên hiển thị</label>
                                        <input type="text" name="username" class="form-control rounded-3"
                                               value="<?= htmlspecialchars($user['username']) ?>" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold small">Email</label>
                                        <input type="email" class="form-control rounded-3 bg-light"
                                               value="<?= htmlspecialchars($user['email']) ?>" disabled>
                                        <small class="text-muted">Email không thể thay đổi.</small>
                                    </div>
                                    <button type="submit" class="btn btn-gradient w-100 rounded-pill py-2 fw-bold">
                                        <i class="bi bi-save me-2"></i>Lưu thay đổi
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Change Password -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-4"><i class="bi bi-shield-lock me-2 text-warning"></i>Đổi mật khẩu</h6>
                                <form method="POST" action="<?= BASE_PATH ?>/profile" id="pwdForm">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="action" value="change_password">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Mật khẩu hiện tại</label>
                                        <input type="password" name="current_password" class="form-control rounded-3" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Mật khẩu mới</label>
                                        <input type="password" name="new_password" id="newPwd" class="form-control rounded-3" required minlength="6">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold small">Xác nhận mật khẩu mới</label>
                                        <input type="password" name="confirm_password" id="confirmPwd" class="form-control rounded-3" required>
                                        <small id="pwdMatch" class="d-none text-danger fw-semibold mt-1 d-block">
                                            <i class="bi bi-x-circle me-1"></i>Mật khẩu không khớp
                                        </small>
                                    </div>
                                    <button type="submit" class="btn btn-outline-warning w-100 rounded-pill py-2 fw-bold">
                                        <i class="bi bi-lock-fill me-2"></i>Đổi mật khẩu
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('avatarInput').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const prev = document.getElementById('avatarPreview');
        if (prev.tagName === 'IMG') {
            prev.src = e.target.result;
        } else {
            const img = document.createElement('img');
            img.id = 'avatarPreview';
            img.src = e.target.result;
            img.className = 'rounded-circle border border-3 border-primary';
            img.style.cssText = 'width:90px;height:90px;object-fit:cover;';
            prev.replaceWith(img);
        }
    };
    reader.readAsDataURL(file);
});
document.getElementById('confirmPwd').addEventListener('input', function() {
    const match = document.getElementById('pwdMatch');
    (this.value && this.value !== document.getElementById('newPwd').value)
        ? match.classList.remove('d-none') : match.classList.add('d-none');
});
document.getElementById('pwdForm').addEventListener('submit', function(e) {
    if (document.getElementById('newPwd').value !== document.getElementById('confirmPwd').value) {
        e.preventDefault();
        document.getElementById('pwdMatch').classList.remove('d-none');
    }
});
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>
