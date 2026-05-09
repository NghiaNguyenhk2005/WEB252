<?php require_once 'views/client/components/header.php'; ?>

<div class="container my-5 py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="card-body">
                    <h2 class="fw-bold mb-4 text-center">Đăng ký</h2>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger border-0 rounded-pill small py-2 text-center mb-4"><?= $error ?></div>
                    <?php endif; ?>

                    <form action="index.php?url=register" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Tên đăng nhập</label>
                            <input type="text" name="username" class="form-control rounded-pill px-3" placeholder="user123" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control rounded-pill px-3" placeholder="email@example.com" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Mật khẩu</label>
                            <input type="password" name="password" class="form-control rounded-pill px-3" placeholder="********" required>
                        </div>
                        <button type="submit" class="btn btn-gradient w-100 rounded-pill py-2 mb-3">Đăng ký</button>
                        <p class="text-center text-muted mb-0">Đã có tài khoản? <a href="index.php?url=login" class="text-primary text-decoration-none">Đăng nhập</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/client/components/footer.php'; ?>