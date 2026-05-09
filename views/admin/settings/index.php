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
<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="srt-page-header">
    <div>
        <h4><i class="fa-solid fa-gear me-2" style="color:var(--accent);"></i>Cài đặt & Slider</h4>
        <nav aria-label="breadcrumb"><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_PATH ?>/admin/contacts" class="text-decoration-none">Admin</a></li>
            <li class="breadcrumb-item active">Cài đặt</li>
        </ol></nav>
    </div>
</div>

<?php if (isset($_GET['success'])): ?><div class="srt-alert srt-alert-success"><i class="fa-solid fa-check-circle me-2"></i>Lưu thành công.</div><?php endif; ?>
<?php if (isset($_GET['deleted'])): ?><div class="srt-alert srt-alert-success"><i class="fa-solid fa-trash me-2"></i>Đã xoá slider.</div><?php endif; ?>

<!-- General settings -->
<div class="srt-card mb-4">
    <div class="srt-card-header"><span><i class="fa-solid fa-sliders me-2"></i>Thông tin chung</span></div>
    <div class="srt-card-body">
        <form method="POST" action="<?= BASE_PATH ?>/admin/settings/update" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Tên website</label>
                    <input type="text" name="site_name" class="form-control rounded-3" value="<?= htmlspecialchars($globalSettings['site_name'] ?? '') ?>" placeholder="TechSaaS" maxlength="100">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Logo</label>
                    <div class="d-flex align-items-center gap-3">
                        <?php if (!empty($globalSettings['site_logo'])): ?>
                            <img src="<?= BASE_PATH ?>/<?= htmlspecialchars($globalSettings['site_logo']) ?>" alt="Logo" style="height:40px;object-fit:contain;border-radius:6px;background:#f8f9fc;padding:4px;border:1px solid #eee;">
                        <?php else: ?>
                            <div style="width:60px;height:40px;background:#f0f4ff;border-radius:6px;display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-image" style="color:#aaa;"></i></div>
                        <?php endif; ?>
                        <input type="file" name="site_logo" class="form-control rounded-3" accept="image/*" style="max-width:300px;">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Số điện thoại</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-phone"></i></span>
                        <input type="text" name="company_phone" class="form-control" value="<?= htmlspecialchars($globalSettings['company_phone'] ?? '') ?>" placeholder="0123 456 789" maxlength="20">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Email liên hệ</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" name="company_email" class="form-control" value="<?= htmlspecialchars($globalSettings['company_email'] ?? '') ?>" placeholder="contact@techsaas.vn" maxlength="100">
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold small">Địa chỉ công ty</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-location-dot"></i></span>
                        <input type="text" name="company_address" class="form-control" value="<?= htmlspecialchars($globalSettings['company_address'] ?? '') ?>" placeholder="123 Đường ABC, Quận 1, TP. HCM" maxlength="255">
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn-srt-primary" style="padding:9px 24px;border-radius:8px;font-size:.9rem;">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Lưu cài đặt
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Slider management -->
<div class="srt-card" id="sliders">
    <div class="srt-card-header">
        <span><i class="fa-solid fa-images me-2"></i>Quản lý Slider</span>
        <button class="btn-srt-primary btn-srt-sm" onclick="document.getElementById('addSliderForm').classList.toggle('d-none')">
            <i class="fa-solid fa-plus me-1"></i>Thêm slider
        </button>
    </div>
    <div class="srt-card-body">
        <div id="addSliderForm" class="d-none mb-4 p-4 rounded-3" style="background:#f8f9fc;border:1px dashed #d0d7de;">
            <h6 class="fw-bold mb-3"><i class="fa-solid fa-plus-circle me-2" style="color:var(--accent);"></i>Thêm Slide mới</h6>
            <form method="POST" action="<?= BASE_PATH ?>/admin/settings/slider/create" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Hình ảnh <span class="text-danger">*</span></label>
                        <input type="file" name="slider_image" class="form-control" accept="image/*" required>
                        <small class="text-muted">JPG, PNG, WEBP. Khuyến nghị 1920×700px.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Tiêu đề</label>
                        <input type="text" name="title" class="form-control" placeholder="Tiêu đề slide" maxlength="255">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold small">Mô tả</label>
                        <textarea name="subtitle" class="form-control" rows="2" placeholder="Mô tả ngắn..." maxlength="500"></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Nút bấm</label>
                        <input type="text" name="button_text" class="form-control" placeholder="Khám phá ngay" maxlength="50">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Đường dẫn nút</label>
                        <input type="text" name="button_link" class="form-control" placeholder="/lien-he" maxlength="255">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Thứ tự hiển thị</label>
                        <input type="number" name="display_order" class="form-control" value="0" min="0" max="99">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn-srt-primary" style="padding:8px 20px;border-radius:7px;">
                            <i class="fa-solid fa-cloud-arrow-up me-2"></i>Tải lên & Lưu
                        </button>
                        <button type="button" style="background:#f0f0f0;border:none;border-radius:7px;padding:8px 16px;cursor:pointer;font-weight:600;font-size:.85rem;margin-left:8px;"
                                onclick="document.getElementById('addSliderForm').classList.add('d-none')">Huỷ</button>
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
            </form>
        </div>

        <div style="overflow-x:auto;">
        <table class="srt-table">
            <thead><tr>
                <th style="width:40px;">#</th><th style="width:120px;">Hình ảnh</th>
                <th>Tiêu đề</th><th>Mô tả</th>
                <th style="width:80px;">Thứ tự</th><th style="width:90px;">Trạng thái</th><th style="width:110px;">Thao tác</th>
            </tr></thead>
            <tbody>
            <?php $stt = 1; if ($sliders->num_rows === 0): ?>
                <tr><td colspan="7" class="text-center py-5" style="color:#aaa;"><i class="fa-solid fa-images fa-2x mb-2 d-block"></i>Chưa có slider nào.</td></tr>
            <?php else: while ($sl = $sliders->fetch_assoc()): ?>
                <tr>
                    <td style="color:#aaa;"><?= $stt++ ?></td>
                    <td>
                        <?php if ($sl['image_url']): ?>
                            <img src="<?= BASE_PATH ?>/<?= htmlspecialchars($sl['image_url']) ?>" style="width:100px;height:55px;object-fit:cover;border-radius:6px;border:1px solid #eee;">
                        <?php else: ?>
                            <div style="width:100px;height:55px;background:#f0f4ff;border-radius:6px;display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-image" style="color:#aaa;"></i></div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="fw-semibold" style="font-size:.87rem;"><?= htmlspecialchars($sl['title'] ?? '—') ?></div>
                        <?php if ($sl['button_text']): ?><small class="text-muted"><i class="fa-solid fa-link me-1"></i><?= htmlspecialchars($sl['button_text']) ?></small><?php endif; ?>
                    </td>
                    <td style="font-size:.83rem;color:#666;max-width:200px;"><?= htmlspecialchars(mb_substr($sl['subtitle'] ?? '', 0, 60)) ?><?= mb_strlen($sl['subtitle'] ?? '') > 60 ? '…' : '' ?></td>
                    <td class="text-center"><span style="font-weight:700;color:#555;"><?= (int)$sl['display_order'] ?></span></td>
                    <td><?= $sl['status']==1 ? '<span class="badge-active">Hiện</span>' : '<span class="badge-banned">Ẩn</span>' ?></td>
                    <td>
                        <div class="d-flex gap-1">
                            <form method="POST" action="<?= BASE_PATH ?>/admin/settings/slider/<?= $sl['id'] ?>/toggle">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-srt-primary btn-srt-sm" title="<?= $sl['status']==1?'Ẩn':'Hiện' ?>">
                                    <i class="fa-solid <?= $sl['status']==1?'fa-eye-slash':'fa-eye' ?>"></i>
                                </button>
                            </form>
                            <form method="POST" action="<?= BASE_PATH ?>/admin/settings/slider/<?= $sl['id'] ?>/delete" onsubmit="return confirm('Xoá slider này?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-srt-danger btn-srt-sm"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endwhile; endif; ?>
            </tbody>
        </table>
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
<?php include __DIR__ . '/../partials/footer.php'; ?>
