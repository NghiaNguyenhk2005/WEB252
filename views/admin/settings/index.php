<?php include __DIR__ . '/../partials/header.php'; ?>

<!-- Page header -->
<div class="srt-page-header">
    <div>
        <h4><i class="fa-solid fa-gear me-2" style="color:var(--accent);"></i>Cài đặt & Slider</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/contacts" class="text-decoration-none">Admin</a></li>
                <li class="breadcrumb-item active">Cài đặt</li>
            </ol>
        </nav>
    </div>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="srt-alert srt-alert-success"><i class="fa-solid fa-check-circle me-2"></i>Lưu thành công.</div>
<?php endif; ?>
<?php if (isset($_GET['deleted'])): ?>
    <div class="srt-alert srt-alert-success"><i class="fa-solid fa-trash me-2"></i>Đã xoá slider.</div>
<?php endif; ?>

<!-- ── GENERAL SETTINGS CARD ─────────────────────────────── -->
<div class="srt-card mb-4">
    <div class="srt-card-header">
        <span><i class="fa-solid fa-sliders me-2"></i>Thông tin chung</span>
    </div>
    <div class="srt-card-body">
        <form method="POST" action="/admin/settings/update" enctype="multipart/form-data">
            <div class="row g-4">
                <!-- Site name -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Tên website</label>
                    <input type="text" name="site_name" class="form-control rounded-3"
                           value="<?= htmlspecialchars($globalSettings['site_name'] ?? '') ?>"
                           placeholder="TechSaaS" maxlength="100">
                </div>
                <!-- Logo upload -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Logo</label>
                    <div class="d-flex align-items-center gap-3">
                        <?php if (!empty($globalSettings['site_logo'])): ?>
                            <img src="/<?= htmlspecialchars($globalSettings['site_logo']) ?>" alt="Logo" style="height:40px;object-fit:contain;border-radius:6px;background:#f8f9fc;padding:4px;">
                        <?php else: ?>
                            <div style="width:60px;height:40px;background:#f0f4ff;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                                <i class="fa-solid fa-image" style="color:#aaa;"></i>
                            </div>
                        <?php endif; ?>
                        <input type="file" name="site_logo" class="form-control rounded-3" accept="image/*" style="max-width:300px;">
                    </div>
                </div>
                <!-- Phone -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Số điện thoại</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-phone"></i></span>
                        <input type="text" name="company_phone" class="form-control"
                               value="<?= htmlspecialchars($globalSettings['company_phone'] ?? '') ?>"
                               placeholder="0123 456 789" maxlength="20">
                    </div>
                </div>
                <!-- Email -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Email liên hệ</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" name="company_email" class="form-control"
                               value="<?= htmlspecialchars($globalSettings['company_email'] ?? '') ?>"
                               placeholder="contact@techsaas.vn" maxlength="100">
                    </div>
                </div>
                <!-- Address -->
                <div class="col-12">
                    <label class="form-label fw-semibold small">Địa chỉ công ty</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-location-dot"></i></span>
                        <input type="text" name="company_address" class="form-control"
                               value="<?= htmlspecialchars($globalSettings['company_address'] ?? '') ?>"
                               placeholder="123 Đường ABC, Quận 1, TP. HCM" maxlength="255">
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

<!-- ── SLIDER MANAGEMENT CARD ────────────────────────────── -->
<div class="srt-card" id="sliders">
    <div class="srt-card-header">
        <span><i class="fa-solid fa-images me-2"></i>Quản lý Slider</span>
        <button class="btn-srt-primary btn-srt-sm" onclick="document.getElementById('addSliderForm').classList.toggle('d-none')">
            <i class="fa-solid fa-plus me-1"></i>Thêm slider
        </button>
    </div>
    <div class="srt-card-body">

        <!-- Add Slider Form (hidden by default) -->
        <div id="addSliderForm" class="d-none mb-4 p-4 rounded-3" style="background:#f8f9fc;border:1px dashed #d0d7de;">
            <h6 class="fw-bold mb-3"><i class="fa-solid fa-plus-circle me-2" style="color:var(--accent);"></i>Thêm Slide mới</h6>
            <form method="POST" action="/admin/settings/slider/create" enctype="multipart/form-data">
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
                    <div class="col-md-12">
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
                        <button type="button" class="btn-srt-sm ms-2" style="background:#f0f0f0;border:none;border-radius:7px;padding:8px 16px;cursor:pointer;font-weight:600;"
                                onclick="document.getElementById('addSliderForm').classList.add('d-none')">
                            Huỷ
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sliders table -->
        <div style="overflow-x:auto;">
        <table class="srt-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th style="width:120px;">Hình ảnh</th>
                    <th>Tiêu đề</th>
                    <th>Mô tả</th>
                    <th style="width:80px;">Thứ tự</th>
                    <th style="width:100px;">Trạng thái</th>
                    <th style="width:140px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $stt = 1;
            if ($sliders->num_rows === 0): ?>
                <tr>
                    <td colspan="7" class="text-center py-5" style="color:#aaa;">
                        <i class="fa-solid fa-images fa-2x mb-2 d-block"></i>Chưa có slider nào.
                    </td>
                </tr>
            <?php else:
                while ($sl = $sliders->fetch_assoc()): ?>
                <tr>
                    <td style="color:#aaa;"><?= $stt++ ?></td>
                    <td>
                        <?php if ($sl['image_url']): ?>
                            <img src="/<?= htmlspecialchars($sl['image_url']) ?>"
                                 style="width:100px;height:55px;object-fit:cover;border-radius:6px;border:1px solid #eee;">
                        <?php else: ?>
                            <div style="width:100px;height:55px;background:#f0f4ff;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                                <i class="fa-solid fa-image" style="color:#aaa;"></i>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="fw-semibold" style="font-size:.87rem;"><?= htmlspecialchars($sl['title'] ?? '—') ?></div>
                        <?php if ($sl['button_text']): ?>
                            <small class="text-muted"><i class="fa-solid fa-link me-1"></i><?= htmlspecialchars($sl['button_text']) ?></small>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:.83rem;color:#666;max-width:200px;">
                        <?= htmlspecialchars(mb_substr($sl['subtitle'] ?? '', 0, 60)) ?><?= mb_strlen($sl['subtitle'] ?? '') > 60 ? '…' : '' ?>
                    </td>
                    <td class="text-center">
                        <span style="font-size:.9rem;font-weight:700;color:#555;"><?= (int)$sl['display_order'] ?></span>
                    </td>
                    <td>
                        <?php if ($sl['status'] == 1): ?>
                            <span class="badge-active">Hiện</span>
                        <?php else: ?>
                            <span class="badge-banned">Ẩn</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <!-- Toggle status -->
                            <form method="POST" action="/admin/settings/slider/<?= $sl['id'] ?>/toggle">
                                <button type="submit" class="btn-srt-primary btn-srt-sm"
                                        title="<?= $sl['status'] == 1 ? 'Ẩn slider' : 'Hiện slider' ?>">
                                    <i class="fa-solid <?= $sl['status'] == 1 ? 'fa-eye-slash' : 'fa-eye' ?>"></i>
                                </button>
                            </form>
                            <!-- Delete -->
                            <form method="POST" action="/admin/settings/slider/<?= $sl['id'] ?>/delete"
                                  onsubmit="return confirm('Xoá slider này?')">
                                <button type="submit" class="btn-srt-danger btn-srt-sm">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
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

<?php include __DIR__ . '/../partials/footer.php'; ?>
