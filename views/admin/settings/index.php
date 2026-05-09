<?php require_once 'views/admin/partials/header.php'; ?>

<div class="main-content-inner p-4">
    <div class="row">
        <div class="col-lg-12 mt-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-center mb-5 pb-3 border-bottom">
                        <div>
                            <h4 class="fw-bold mb-1">Cấu hình Hệ thống</h4>
                            <p class="text-muted small mb-0">Thiết lập các thông tin cơ bản và nhận diện thương hiệu.</p>
                        </div>
                    </div>
                    
                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success border-0 rounded-4 p-3 mb-4 animate__animated animate__fadeIn">
                            <i class="bi bi-check-circle-fill me-2"></i> Cập nhật cấu hình thành công!
                        </div>
                    <?php endif; ?>

                    <form action="index.php?url=admin/settings/update" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <!-- Left Column: Branding -->
                            <div class="col-lg-6 border-right-md">
                                <div class="px-md-3">
                                    <h5 class="fw-bold mb-4 text-primary"><i class="ti-palette me-2"></i>Thương hiệu</h5>
                                    
                                    <div class="form-group mb-4">
                                        <label class="small fw-bold text-uppercase text-muted">Tên Website</label>
                                        <input type="text" class="form-control rounded-3 border-light-gray shadow-xs" name="site_name" value="<?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?>" required>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="small fw-bold text-uppercase text-muted">Logo hiện tại</label>
                                        <div class="mt-2 p-4 bg-light rounded-4 text-center border-dashed">
                                            <?php if(!empty($globalSettings['site_logo'])): ?>
                                                <img src="<?= $globalSettings['site_logo'] ?>" height="60" class="img-fluid" id="logo-preview">
                                            <?php else: ?>
                                                <div class="py-3 text-muted">
                                                    <i class="ti-image display-4 d-block mb-2 opacity-25"></i>
                                                    Chưa có logo
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mt-3">
                                            <label class="btn btn-outline-primary btn-sm rounded-pill px-4 cursor-pointer">
                                                <i class="ti-upload me-2"></i>Thay đổi Logo
                                                <input type="file" class="d-none" name="site_logo" onchange="previewImage(this)">
                                            </label>
                                            <p class="extra-small text-muted mt-2">Định dạng hỗ trợ: PNG, JPG, SVG. Tối đa 2MB.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Contact -->
                            <div class="col-lg-6 mt-5 mt-lg-0">
                                <div class="px-md-3">
                                    <h5 class="fw-bold mb-4 text-primary"><i class="ti-headphone-alt me-2"></i>Thông tin liên hệ</h5>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label class="small fw-bold text-uppercase text-muted">Số điện thoại Hotline</label>
                                                <input type="text" class="form-control rounded-3 border-light-gray shadow-xs" name="company_phone" value="<?= htmlspecialchars($globalSettings['company_phone'] ?? '') ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label class="small fw-bold text-uppercase text-muted">Email liên hệ</label>
                                                <input type="email" class="form-control rounded-3 border-light-gray shadow-xs" name="company_email" value="<?= htmlspecialchars($globalSettings['company_email'] ?? '') ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="small fw-bold text-uppercase text-muted">Địa chỉ văn phòng</label>
                                        <textarea class="form-control rounded-3 border-light-gray shadow-xs" name="company_address" rows="4"><?= htmlspecialchars($globalSettings['company_address'] ?? '') ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-top mt-5 pt-4 text-right">
                            <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 shadow font-weight-bold">
                                <i class="ti-save me-2"></i>Lưu tất cả thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('logo-preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php require_once 'views/admin/partials/footer.php'; ?>