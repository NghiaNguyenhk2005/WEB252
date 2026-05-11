<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="srt-page-header">
    <div>
        <h4>
            <i class="fa-solid fa-pen me-2" style="color:var(--accent);"></i>
            Chỉnh sửa dịch vụ
        </h4>
    </div>
</div>

<div class="srt-card">
    <div class="srt-card-header">
        <span>
            <i class="fa-solid fa-handshake me-2"></i>
            Thông tin dịch vụ
        </span>
    </div>

    <div style="padding:24px;">
        <form action="<?= BASE_PATH ?>/admin/services/update" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $service['id'] ?>">
            
            <div class="mb-3">
                <label class="form-label fw-bold">Tên dịch vụ</label>
                <input type="text" class="form-control" name="name" 
                       value="<?= htmlspecialchars($service['name']) ?>" required>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Slug (Tự động nếu để trống)</label>
                    <input type="text" class="form-control" name="slug" 
                           value="<?= htmlspecialchars($service['slug']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Trạng thái</label>
                    <select class="form-control" name="status">
                        <option value="1" <?= ($service['status'] ?? 1) == 1 ? 'selected' : '' ?>>Hiển thị</option>
                        <option value="0" <?= ($service['status'] ?? 1) == 0 ? 'selected' : '' ?>>Ẩn</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Bootstrap Icon Class</label>
                <input type="text" class="form-control" name="icon" 
                       value="<?= htmlspecialchars($service['icon'] ?? 'bi-cpu') ?>">
                <small class="text-muted">Ví dụ: bi-shield-lock, bi-cpu, bi-gear</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Mô tả ngắn</label>
                <input type="text" class="form-control" name="short_description" 
                       value="<?= htmlspecialchars($service['short_description']) ?>" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Nội dung chi tiết (Hỗ trợ HTML)</label>
                <textarea class="form-control" name="detailed_content" rows="10"><?= htmlspecialchars($service['detailed_content']) ?></textarea>
            </div>
            
            <div class="text-end">
                <a href="<?= BASE_PATH ?>/admin/services" class="btn-srt-secondary me-2">
                    <i class="fa-solid fa-arrow-left me-2"></i>Hủy bỏ
                </a>
                <button type="submit" class="btn-srt-primary">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Cập nhật dịch vụ
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>