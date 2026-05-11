<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="srt-page-header">
    <div>
        <h4>
            <i class="fa-solid fa-pen me-2" style="color:var(--accent);"></i>
            Chỉnh sửa bài viết
        </h4>
    </div>
</div>

<div class="srt-card">
    <div class="srt-card-header">
        <span>
            <i class="fa-solid fa-newspaper me-2"></i>
            Thông tin bài viết
        </span>
    </div>

    <div style="padding:24px;">
        <form action="<?= BASE_PATH ?>/admin/posts/update" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            
            <div class="mb-3">
                <label class="form-label fw-bold">Tiêu đề bài viết</label>
                <input type="text" class="form-control" name="title" 
                       value="<?= htmlspecialchars($post['title']) ?>" required>
            </div>
            
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Slug (Tự động nếu để trống)</label>
                    <input type="text" class="form-control" name="slug" 
                           value="<?= htmlspecialchars($post['slug']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Trạng thái</label>
                    <select class="form-control" name="status">
                        <option value="1" <?= ($post['status'] ?? 1) == 1 ? 'selected' : '' ?>>Hiển thị</option>
                        <option value="0" <?= ($post['status'] ?? 1) == 0 ? 'selected' : '' ?>>Ẩn</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Ảnh đại diện hiện tại</label>
                <?php if (!empty($post['thumbnail']) && file_exists($post['thumbnail'])): ?>
                    <div class="mb-2">
                        <img src="<?= BASE_PATH ?>/<?= htmlspecialchars($post['thumbnail']) ?>" 
                             width="150" class="rounded-3 border" style="object-fit:cover;">
                    </div>
                <?php endif; ?>
                <input type="file" class="form-control" name="thumbnail">
                <small class="text-muted">Để trống nếu không muốn thay đổi ảnh</small>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Nội dung bài viết (Hỗ trợ HTML)</label>
                <textarea class="form-control" name="content" rows="15" 
                          placeholder="Nội dung bài viết chi tiết tại đây..."><?= htmlspecialchars($post['content']) ?></textarea>
            </div>
            
            <div class="text-end">
                <a href="<?= BASE_PATH ?>/admin/posts" class="btn-srt-secondary me-2">
                    <i class="fa-solid fa-arrow-left me-2"></i>Hủy bỏ
                </a>
                <button type="submit" class="btn-srt-primary">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Cập nhật bài viết
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>