<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="srt-page-header">
    <div>
        <h4><i class="fa-solid fa-building me-2" style="color:var(--accent);"></i>Cấu hình trang Giới thiệu</h4>
        <p class="text-muted small mb-0">Quản lý nội dung trang Giới thiệu công ty</p>
    </div>
    <a href="<?= BASE_PATH ?>/about" class="btn-srt-secondary text-decoration-none" target="_blank">
        <i class="fa-solid fa-eye me-2"></i>Xem trang
    </a>
</div>

<div class="srt-card">
    <div class="srt-card-header">
        <span><i class="fa-solid fa-pen me-2"></i>Thông tin trang Giới thiệu</span>
    </div>
    <div style="padding:24px;">
        <form action="<?= BASE_PATH ?>/admin/settings/about/update" method="POST">
            <?= csrf_field() ?>
            
            <!-- Basic Info -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tiêu đề trang</label>
                    <input type="text" name="title" class="form-control" 
                           value="<?= htmlspecialchars($aboutSettings['title']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tiêu đề phụ</label>
                    <input type="text" name="subtitle" class="form-control" 
                           value="<?= htmlspecialchars($aboutSettings['subtitle']) ?>">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Tên công ty</label>
                <input type="text" name="company_name" class="form-control" 
                       value="<?= htmlspecialchars($aboutSettings['company_name']) ?>" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Nội dung chính</label>
                <textarea name="content" class="form-control" rows="8" id="editor"><?= htmlspecialchars($aboutSettings['content']) ?></textarea>
                <small class="text-muted">Hỗ trợ thẻ HTML (p, strong, em, ul, li, h1-h6)</small>
            </div>

            <!-- Mission & Vision -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Sứ mệnh</label>
                    <textarea name="mission" class="form-control" rows="3"><?= htmlspecialchars($aboutSettings['mission']) ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tầm nhìn</label>
                    <textarea name="vision" class="form-control" rows="3"><?= htmlspecialchars($aboutSettings['vision']) ?></textarea>
                </div>
            </div>

            <!-- Statistics -->
            <h5 class="fw-bold mb-3">Thống kê</h5>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Doanh nghiệp tin dùng</label>
                    <input type="text" name="stat_customers" class="form-control" 
                           value="<?= htmlspecialchars($aboutSettings['stat_customers']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Chuyên gia công nghệ</label>
                    <input type="text" name="stat_experts" class="form-control" 
                           value="<?= htmlspecialchars($aboutSettings['stat_experts']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Uptime đảm bảo</label>
                    <input type="text" name="stat_uptime" class="form-control" 
                           value="<?= htmlspecialchars($aboutSettings['stat_uptime']) ?>">
                </div>
            </div>

            <!-- Values Cards -->
            <h5 class="fw-bold mb-3">Giá trị cốt lõi</h5>
            <div id="values-container">
                <?php 
                $values = $aboutSettings['values'];
                if (empty($values)) {
                    $values = [
                        ['icon' => 'fa-solid fa-rocket', 'title' => 'Đổi mới sáng tạo', 'desc' => 'Không ngừng cải tiến'],
                        ['icon' => 'fa-solid fa-handshake', 'title' => 'Đồng hành cùng khách hàng', 'desc' => 'Lắng nghe và thấu hiểu'],
                        ['icon' => 'fa-solid fa-shield-haltered', 'title' => 'An toàn - Bảo mật', 'desc' => 'Bảo vệ dữ liệu khách hàng'],
                        ['icon' => 'fa-solid fa-chart-line', 'title' => 'Phát triển bền vững', 'desc' => 'Phát triển lâu dài cùng đối tác']
                    ];
                }
                foreach ($values as $index => $value): 
                ?>
                <div class="value-item row mb-3 p-3 border rounded">
                    <div class="col-md-2">
                        <label class="form-label small">Icon</label>
                        <input type="text" name="value_icon[]" class="form-control" 
                               value="<?= htmlspecialchars($value['icon']) ?>" placeholder="fa-solid fa-rocket">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">Tiêu đề</label>
                        <input type="text" name="value_title[]" class="form-control" 
                               value="<?= htmlspecialchars($value['title']) ?>">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small">Mô tả</label>
                        <input type="text" name="value_desc[]" class="form-control" 
                               value="<?= htmlspecialchars($value['desc']) ?>">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-value">×</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <button type="button" class="btn-srt-secondary btn-sm mb-4" id="add-value">
                <i class="fa-solid fa-plus me-1"></i>Thêm giá trị
            </button>

            <div class="d-flex gap-2 justify-content-end">
                <a href="<?= BASE_PATH ?>/admin/settings" class="btn-srt-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Quay lại
                </a>
                <button type="submit" class="btn-srt-primary">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Add new value card
document.getElementById('add-value').addEventListener('click', function() {
    const container = document.getElementById('values-container');
    const newItem = document.createElement('div');
    newItem.className = 'value-item row mb-3 p-3 border rounded';
    newItem.innerHTML = `
        <div class="col-md-2">
            <label class="form-label small">Icon</label>
            <input type="text" name="value_icon[]" class="form-control" placeholder="fa-solid fa-rocket">
        </div>
        <div class="col-md-4">
            <label class="form-label small">Tiêu đề</label>
            <input type="text" name="value_title[]" class="form-control">
        </div>
        <div class="col-md-5">
            <label class="form-label small">Mô tả</label>
            <input type="text" name="value_desc[]" class="form-control">
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <button type="button" class="btn btn-danger btn-sm remove-value">×</button>
        </div>
    `;
    container.appendChild(newItem);
});

// Remove value card
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-value')) {
        e.target.closest('.value-item').remove();
    }
});
</script>

<style>
.value-item {
    background: #f8f9fa;
    transition: all 0.2s;
}
.value-item:hover {
    background: #e9ecef;
}
</style>

<?php include __DIR__ . '/../partials/footer.php'; ?>