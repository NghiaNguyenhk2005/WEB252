<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="srt-page-header">
    <div>
        <h4><i class="fa-solid fa-newspaper me-2" style="color:var(--accent);"></i>Quản lý Tin tức</h4>
    </div>
    <a href="<?= BASE_PATH ?>/admin/posts/create" class="btn-srt-primary text-decoration-none">
        <i class="fa-solid fa-plus"></i> Thêm bài viết
    </a>
</div>

<div class="srt-card">
    <div class="srt-card-header">
        <span><i class="fa-solid fa-list me-2"></i>Danh sách bài viết</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="srt-table">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th style="width:80px;">Ảnh</th>
                    <th>Tiêu đề</th>
                    <th style="width:110px;">Ngày đăng</th>
                    <th style="width:110px;">Trạng thái</th>
                    <th style="width:120px;text-align:center;">Hành động</th>
                </tr>
            </thead>
            <tbody>
            <?php if (isset($posts) && is_object($posts) && $posts->num_rows > 0):
                while ($post = $posts->fetch_assoc()): ?>
                <tr>
                    <td style="color:#aaa;font-size:.82rem;"><?= $post['id'] ?></td>
                    <td>
                        <img src="<?= BASE_PATH ?>/<?= htmlspecialchars($post['thumbnail'] ?? 'assets/client/img/bg1.jpg') ?>"
                             width="64" height="42" class="rounded-3 flex-shrink-0"
                             style="object-fit:cover;border:1px solid #eee;"
                             onerror="this.src='<?= BASE_PATH ?>/assets/client/img/bg1.jpg'">
                    </td>
                    <td>
                        <div class="fw-semibold" style="font-size:.88rem;max-width:320px;">
                            <?= htmlspecialchars($post['title']) ?>
                        </div>
                        <div style="font-size:.77rem;color:#aaa;"><?= htmlspecialchars($post['slug'] ?? '') ?></div>
                    </td>
                    <td style="font-size:.82rem;color:#888;white-space:nowrap;">
                        <?= $post['created_at'] ? date('d/m/Y', strtotime($post['created_at'])) : '—' ?>
                    </td>
                    <td>
                        <?= ($post['status'] ?? 1) == 1
                            ? '<span class="badge-active">Hiển thị</span>'
                            : '<span class="badge-banned">Ẩn</span>' ?>
                    </td>
                    <td style="text-align:center;">
                        <div class="srt-actions" style="justify-content:center;">
                            <a href="<?= BASE_PATH ?>/news/<?= htmlspecialchars($post['slug'] ?? '') ?>"
                            target="_blank"
                            class="btn-srt-secondary btn-srt-sm text-decoration-none" title="Xem bài viết">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="<?= BASE_PATH ?>/admin/posts/edit?id=<?= $post['id'] ?>"
                            class="btn-srt-warning btn-srt-sm text-decoration-none" title="Chỉnh sửa">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form method="POST"
                                action="<?= BASE_PATH ?>/admin/posts/delete"
                                onsubmit="return confirm('Xoá bài viết này?')">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value="<?= $post['id'] ?>">
                                <button type="submit" class="btn-srt-danger btn-srt-sm" title="Xoá">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endwhile; else: ?>
                <tr>
                    <td colspan="6" class="text-center py-5" style="color:#aaa;">
                        <i class="fa-solid fa-newspaper fa-2x mb-2 d-block" style="opacity:.3;"></i>
                        Chưa có bài viết nào. <a href="<?= BASE_PATH ?>/admin/posts/create" class="fw-bold" style="color:var(--accent);">Đăng bài ngay</a>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($pages) && $pages > 1): ?>
    <div style="padding:16px 20px;">
        <div class="srt-pagination">
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <?php if ($i == ($page ?? 1)): ?>
                    <span class="active"><?= $i ?></span>
                <?php else: ?>
                    <a href="<?= BASE_PATH ?>/admin/posts?page=<?= $i ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
