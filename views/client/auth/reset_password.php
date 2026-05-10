<?php require_once 'views/client/components/header.php'; ?>

<div class="container my-5 py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="card-body">
                    <h2 class="fw-bold mb-3 text-center">Đặt lại mật khẩu</h2>
                    <p class="text-muted mb-4 text-center small">Xác minh thành công. Vui lòng nhập mật khẩu mới của bạn.</p>
                    
                    <form action="index.php?url=reset-password" method="POST">
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Mật khẩu mới</label>
                            <input type="password" name="password" class="form-control rounded-pill px-3" placeholder="********" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Xác nhận mật khẩu mới</label>
                            <input type="password" name="confirm_password" class="form-control rounded-pill px-3" placeholder="********" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 mb-3 shadow">Cập nhật mật khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/client/components/footer.php'; ?>