<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="srt-page-header">
    <div>
        <h4><i class="fa-solid fa-tags me-2" style="color:var(--accent);"></i>Quản lý Danh mục</h4>
    </div>
</div>

<div class="row g-4">

    <!-- Add form -->
    <div class="col-lg-4">
        <div class="srt-card">
            <div class="srt-card-header">
                <span><i class="fa-solid fa-plus me-2"></i>Thêm danh mục mới</span>
            </div>
            <div class="srt-card-body">
                <form action="<?= BASE_PATH ?>/admin/categories/store" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-3"
                               placeholder="VD: Điện tử, Thời trang..." required maxlength="100">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Slug <span class="text-muted">(để trống tự tạo)</span></label>
                        <input type="text" name="slug" class="form-control rounded-3"
                               placeholder="dien-tu">
                    </div>
                    <button type="submit" class="btn-srt-primary w-100" style="justify-content:center;padding:10px;border-radius:8px;">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Lưu danh mục
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- List -->
    <div class="col-lg-8">
        <div class="srt-card">
            <div class="srt-card-header">
                <span><i class="fa-solid fa-list me-2"></i>Danh sách danh mục</span>
            </div>
            <div style="overflow-x:auto;">
                <table class="srt-table">
                    <thead>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th>Tên danh mục</th>
                            <th>Slug</th>
                            <th style="width:90px;text-align:center;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($categories) && is_object($categories) && $categories->num_rows > 0):
                        while ($cat = $categories->fetch_assoc()): ?>
                        <tr>
                            <td style="color:#aaa;"><?= $cat['id'] ?></td>
                            <td class="fw-semibold"><?= htmlspecialchars($cat['name']) ?></td>
                            <td style="font-size:.82rem;color:#888;"><?= htmlspecialchars($cat['slug'] ?? '') ?></td>
                            <td style="text-align:center;">
                                <form method="POST"
                                      action="<?= BASE_PATH ?>/admin/categories/delete/<?= $cat['id'] ?>"
                                      onsubmit="return confirm('Xoá danh mục «<?= addslashes(htmlspecialchars($cat['name'])) ?>»? Sản phẩm trong danh mục sẽ mất liên kết.')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn-srt-danger btn-srt-sm" title="Xoá danh mục">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5" style="color:#aaa;">
                                <i class="fa-solid fa-tags fa-2x mb-2 d-block" style="opacity:.3;"></i>
                                Chưa có danh mục nào.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
