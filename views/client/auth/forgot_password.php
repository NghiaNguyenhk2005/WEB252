<?php require_once 'views/client/components/header.php'; ?>

<div class="container my-5 py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="card-body text-center">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-4" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-shield-lock fs-1"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Quên mật khẩu</h2>
                    <p class="text-muted mb-4 small">Vui lòng nhập Tên người dùng và Email đã đăng ký để xác minh danh tính.</p>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger border-0 rounded-pill small py-2"><?= $error ?></div>
                    <?php endif; ?>

                    <form action="index.php?url=forgot-password" method="POST" class="text-start">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Tên người dùng</label>
                            <input type="text" name="username" class="form-control rounded-pill px-3" placeholder="Nhập tên đăng nhập" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Địa chỉ Email</label>
                            <input type="email" name="email" class="form-control rounded-pill px-3" placeholder="email@example.com" required>
                        </div>
                        <button type="submit" class="btn btn-gradient w-100 rounded-pill py-2 mb-3 shadow">Tiếp tục</button>
                        <p class="text-center text-muted mb-0 small">Nhớ lại mật khẩu? <a href="index.php?url=login" class="text-primary text-decoration-none">Đăng nhập</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/client/components/footer.php'; ?>