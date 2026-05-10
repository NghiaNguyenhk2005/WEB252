<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="srt-page-header">
    <div>
        <h4><i class="fa-solid fa-gear me-2" style="color:var(--accent);"></i>Cài đặt hệ thống</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider:'›';">
                <li class="breadcrumb-item">
                    <a href="<?= BASE_PATH ?>/admin/contacts" class="text-decoration-none" style="color:var(--accent);">Admin</a>
                </li>
                <li class="breadcrumb-item active" style="color:#888;">Cài đặt & Slider</li>
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

<!-- ── General Settings ─────────────────────────────────────── -->
<div class="srt-card mb-4">
    <div class="srt-card-header">
        <span><i class="fa-solid fa-sliders me-2"></i>Thông tin chung</span>
    </div>
    <div class="srt-card-body">
        <form method="POST" action="<?= BASE_PATH ?>/admin/settings/update" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="row g-4">

                <!-- Site name -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Tên website</label>
                    <input type="text" name="site_name" class="form-control rounded-3"
                           value="<?= htmlspecialchars($globalSettings['site_name'] ?? '') ?>"
                           placeholder="TechSaaS" maxlength="100">
                </div>

                <!-- Logo -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold small d-block">Logo</label>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <?php if (!empty($globalSettings['site_logo'])): ?>
                            <img src="<?= BASE_PATH ?>/<?= htmlspecialchars($globalSettings['site_logo']) ?>"
                                 id="logo-preview" alt="Logo"
                                 style="height:44px;max-width:140px;object-fit:contain;border-radius:8px;background:#f8f9fc;padding:4px;border:1px solid #eee;">
                        <?php else: ?>
                            <div id="logo-preview-placeholder"
                                 style="width:60px;height:44px;background:#f0f4ff;border-radius:8px;display:flex;align-items:center;justify-content:center;border:1px dashed #d0d7de;">
                                <i class="fa-solid fa-image" style="color:#aaa;"></i>
                            </div>
                        <?php endif; ?>
                        <div>
                            <input type="file" name="site_logo" class="form-control form-control-sm rounded-3"
                                   accept="image/*" onchange="previewLogo(this)">
                            <small class="text-muted">PNG, JPG, SVG, WEBP. Tối đa 2MB.</small>
                        </div>
                    </div>
                </div>

                <!-- Phone -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Số điện thoại</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fa-solid fa-phone text-muted"></i>
                        </span>
                        <input type="text" name="company_phone" class="form-control border-start-0"
                               value="<?= htmlspecialchars($globalSettings['company_phone'] ?? '') ?>"
                               placeholder="0123 456 789" maxlength="20">
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Email liên hệ</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fa-solid fa-envelope text-muted"></i>
                        </span>
                        <input type="email" name="company_email" class="form-control border-start-0"
                               value="<?= htmlspecialchars($globalSettings['company_email'] ?? '') ?>"
                               placeholder="contact@techsaas.vn" maxlength="100">
                    </div>
                </div>

                <!-- Address -->
                <div class="col-12">
                    <label class="form-label fw-semibold small">Địa chỉ công ty</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fa-solid fa-location-dot text-muted"></i>
                        </span>
                        <input type="text" name="company_address" class="form-control border-start-0"
                               value="<?= htmlspecialchars($globalSettings['company_address'] ?? '') ?>"
                               placeholder="123 Đường ABC, Quận 1, TP. HCM" maxlength="255">
                    </div>
                </div>

                <!-- Submit -->
                <div class="col-12">
                    <button type="submit" class="btn-srt-primary" style="padding:10px 28px;border-radius:8px;font-size:.9rem;">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Lưu cài đặt
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- ── Slider Management ────────────────────────────────────── -->
<div class="srt-card" id="sliders">
    <div class="srt-card-header">
        <span><i class="fa-solid fa-images me-2"></i>Quản lý Slider trang chủ</span>
        <button type="button" class="btn-srt-primary btn-srt-sm"
                onclick="toggleAddForm()">
            <i class="fa-solid fa-plus me-1"></i>Thêm slider
        </button>
    </div>
    <div class="srt-card-body">

        <!-- Add form (hidden by default) -->
        <div id="addSliderForm" class="d-none mb-4 p-4 rounded-3"
             style="background:#f8f9fc;border:2px dashed #d0d7de;">
            <h6 class="fw-bold mb-3">
                <i class="fa-solid fa-plus-circle me-2" style="color:var(--accent);"></i>Thêm slide mới
            </h6>
            <form method="POST" action="<?= BASE_PATH ?>/admin/settings/slider/create"
                  enctype="multipart/form-data" id="sliderCreateForm">
                <?= csrf_field() ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">
                            Hình ảnh <span class="text-danger">*</span>
                        </label>
                        <input type="file" name="slider_image" class="form-control"
                               accept="image/jpeg,image/png,image/webp" required
                               onchange="previewSlider(this)">
                        <small class="text-muted">JPG, PNG, WEBP. Tỷ lệ 1920×700px cho tốt nhất.</small>
                        <!-- Slider preview -->
                        <div id="sliderPreviewWrap" class="mt-2 d-none">
                            <img id="sliderPreview" src="" alt="Preview"
                                 style="width:100%;max-height:120px;object-fit:cover;border-radius:8px;border:1px solid #eee;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Tiêu đề</label>
                        <input type="text" name="title" class="form-control"
                               placeholder="VD: Giải pháp chuyển đổi số" maxlength="255">
                        <div class="mt-3">
                            <label class="form-label fw-semibold small">Thứ tự hiển thị</label>
                            <input type="number" name="display_order" class="form-control"
                                   value="0" min="0" max="99" style="max-width:120px;">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold small">Mô tả / Phụ đề</label>
                        <textarea name="subtitle" class="form-control" rows="2"
                                  placeholder="Mô tả ngắn xuất hiện dưới tiêu đề..." maxlength="500"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Nội dung nút CTA</label>
                        <input type="text" name="button_text" class="form-control"
                               placeholder="VD: Tìm hiểu thêm" maxlength="50">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Đường dẫn nút</label>
                        <input type="text" name="button_link" class="form-control"
                               placeholder="VD: /contact" maxlength="255">
                    </div>
                    <div class="col-12 d-flex gap-2 align-items-center">
                        <button type="submit" class="btn-srt-primary" style="padding:9px 22px;border-radius:7px;">
                            <i class="fa-solid fa-cloud-arrow-up me-2"></i>Tải lên & Lưu
                        </button>
                        <button type="button" onclick="toggleAddForm()"
                                style="background:#f0f0f0;border:none;border-radius:7px;padding:9px 18px;cursor:pointer;font-weight:600;font-size:.85rem;color:#555;">
                            <i class="fa-solid fa-xmark me-1"></i>Huỷ
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sliders table -->
        <?php if ($sliders->num_rows === 0): ?>
            <div class="text-center py-5" style="color:#aaa;">
                <i class="fa-solid fa-images fa-3x mb-3 d-block" style="opacity:.3;"></i>
                <p class="mb-0">Chưa có slider nào. Nhấn <strong>Thêm slider</strong> để tạo mới.</p>
            </div>
        <?php else: ?>
        <div style="overflow-x:auto;">
        <table class="srt-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th style="width:120px;">Hình ảnh</th>
                    <th>Tiêu đề / Nút</th>
                    <th>Mô tả</th>
                    <th style="width:70px;text-align:center;">Thứ tự</th>
                    <th style="width:90px;">Trạng thái</th>
                    <th style="width:100px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php $stt = 1; while ($sl = $sliders->fetch_assoc()): ?>
                <tr>
                    <td style="color:#aaa;"><?= $stt++ ?></td>
                    <td>
                        <img src="<?= BASE_PATH ?>/<?= htmlspecialchars($sl['image_url']) ?>"
                             style="width:105px;height:58px;object-fit:cover;border-radius:6px;border:1px solid #eee;"
                             onerror="this.style.display='none'">
                    </td>
                    <td>
                        <div class="fw-semibold" style="font-size:.87rem;">
                            <?= htmlspecialchars($sl['title'] ?: '—') ?>
                        </div>
                        <?php if ($sl['button_text']): ?>
                            <small style="color:var(--accent);font-size:.78rem;">
                                <i class="fa-solid fa-arrow-pointer me-1"></i><?= htmlspecialchars($sl['button_text']) ?>
                                <?php if ($sl['button_link']): ?>
                                    → <code style="font-size:.75rem;"><?= htmlspecialchars($sl['button_link']) ?></code>
                                <?php endif; ?>
                            </small>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:.83rem;color:#666;max-width:180px;">
                        <?= htmlspecialchars(mb_substr($sl['subtitle'] ?? '', 0, 55)) ?><?= mb_strlen($sl['subtitle'] ?? '') > 55 ? '…' : '' ?>
                    </td>
                    <td class="text-center">
                        <span class="fw-bold" style="color:#555;"><?= (int)$sl['display_order'] ?></span>
                    </td>
                    <td>
                        <?= $sl['status'] == 1
                            ? '<span class="badge-active">Hiện</span>'
                            : '<span class="badge-banned">Ẩn</span>' ?>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <!-- Toggle visibility -->
                            <form method="POST" action="<?= BASE_PATH ?>/admin/settings/slider/<?= $sl['id'] ?>/toggle">
                                <?= csrf_field() ?>
                                <button type="submit"
                                        class="btn-srt-primary btn-srt-sm"
                                        style="<?= $sl['status'] == 1 ? 'background:#6c757d;' : '' ?>"
                                        title="<?= $sl['status'] == 1 ? 'Ẩn slider này' : 'Hiện slider này' ?>">
                                    <i class="fa-solid <?= $sl['status'] == 1 ? 'fa-eye-slash' : 'fa-eye' ?>"></i>
                                </button>
                            </form>
                            <!-- Delete -->
                            <form method="POST"
                                  action="<?= BASE_PATH ?>/admin/settings/slider/<?= $sl['id'] ?>/delete"
                                  onsubmit="return confirm('Xoá slider «<?= addslashes(htmlspecialchars($sl['title'] ?: 'này')) ?>»?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-srt-danger btn-srt-sm" title="Xoá slider">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Toggle add-slider form
function toggleAddForm() {
    const form = document.getElementById('addSliderForm');
    form.classList.toggle('d-none');
    if (!form.classList.contains('d-none')) {
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

// Logo preview
function previewLogo(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        let prev = document.getElementById('logo-preview');
        if (!prev) {
            prev = document.createElement('img');
            prev.id = 'logo-preview';
            prev.alt = 'Logo';
            prev.style.cssText = 'height:44px;max-width:140px;object-fit:contain;border-radius:8px;background:#f8f9fc;padding:4px;border:1px solid #eee;';
            const placeholder = document.getElementById('logo-preview-placeholder');
            if (placeholder) placeholder.replaceWith(prev);
        }
        prev.src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
}

// Slider image preview
function previewSlider(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('sliderPreview').src = e.target.result;
        document.getElementById('sliderPreviewWrap').classList.remove('d-none');
    };
    reader.readAsDataURL(input.files[0]);
}

// Auto-scroll to #sliders section if URL hash is present on load
if (window.location.hash === '#sliders') {
    setTimeout(() => {
        const el = document.getElementById('sliders');
        if (el) el.scrollIntoView({ behavior: 'smooth' });
    }, 300);
}

// Validate slider form before submit
document.getElementById('sliderCreateForm').addEventListener('submit', function(e) {
    const fileInput = this.querySelector('[name=slider_image]');
    if (!fileInput.files || !fileInput.files[0]) {
        e.preventDefault();
        alert('Vui lòng chọn hình ảnh cho slider.');
    }
});
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
