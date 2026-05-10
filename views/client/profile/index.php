<?php require_once 'views/client/components/header.php'; ?>

<div class="container my-5 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="bg-primary p-4 text-white text-center">
                    <h3 class="fw-bold mb-0">Hồ sơ cá nhân</h3>
                </div>
                <div class="card-body p-4 p-md-5">
                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success border-0 rounded-4 p-3 mb-4">Cập nhật thông tin thành công!</div>
                    <?php endif; ?>

                    <form action="index.php?url=profile/update" method="POST" enctype="multipart/form-data">
                        <div class="text-center mb-5">
                            <div class="position-relative d-inline-block">
                                <img src="<?= $user['avatar'] ?? 'assets/client/img/dashboard.jpg' ?>" class="rounded-circle shadow-sm border p-1" width="150" height="150" style="object-fit: cover;" id="avatar-preview">
                                <label for="avatar-input" class="position-absolute bottom-0 end-0 bg-white shadow-sm rounded-circle p-2 cursor-pointer border" style="width: 40px; height: 40px;">
                                    <i class="bi bi-camera-fill text-primary"></i>
                                    <input type="file" name="avatar" id="avatar-input" class="d-none" accept="image/*">
                                </label>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tên người dùng</label>
                                <input type="text" name="username" class="form-control rounded-pill px-3" value="<?= htmlspecialchars($user['username']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email (Không thể đổi)</label>
                                <input type="email" class="form-control rounded-pill px-3 bg-light" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                            </div>
                            <div class="col-12 mt-4">
                                <hr>
                                <label class="form-label fw-bold">Đổi mật khẩu (Để trống nếu không đổi)</label>
                                <input type="password" name="password" class="form-control rounded-pill px-3" placeholder="Nhập mật khẩu mới">
                            </div>
                        </div>

                        <div class="mt-5 text-center">
                            <button type="submit" class="btn btn-gradient btn-lg px-5 rounded-pill shadow">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('avatar-input').onchange = function (evt) {
        const [file] = this.files
        if (file) {
            document.getElementById('avatar-preview').src = URL.createObjectURL(file)
        }
    }
</script>

<?php require_once 'views/client/components/footer.php'; ?>