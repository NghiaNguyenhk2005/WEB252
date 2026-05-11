<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="srt-page-header">
    <div>
        <h4><i class="fa-solid fa-circle-question me-2" style="color:var(--accent);"></i>Quản lý FAQ</h4>
    </div>
</div>

<div class="row g-4">

    <!-- Add form -->
    <div class="col-lg-4">
        <div class="srt-card" style="position:sticky;top:80px;">
            <div class="srt-card-header">
                <span><i class="fa-solid fa-plus me-2"></i>Thêm câu hỏi mới</span>
            </div>
            <div class="srt-card-body">
                <form action="<?= BASE_PATH ?>/admin/faqs/store" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Câu hỏi <span class="text-danger">*</span></label>
                        <input type="text" name="question" class="form-control rounded-3"
                               placeholder="Khách hàng thường hỏi gì?" required maxlength="255">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Câu trả lời <span class="text-danger">*</span></label>
                        <textarea name="answer" class="form-control rounded-3" rows="5"
                                  placeholder="Câu trả lời đầy đủ, rõ ràng..." required></textarea>
                    </div>
                    <button type="submit" class="btn-srt-primary w-100" style="justify-content:center;padding:10px;border-radius:8px;">
                        <i class="fa-solid fa-paper-plane me-2"></i>Xuất bản FAQ
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- FAQ list -->
    <div class="col-lg-8">
        <div class="srt-card">
            <div class="srt-card-header">
                <span><i class="fa-solid fa-list me-2"></i>Danh sách câu hỏi (<?= isset($faqs) && is_object($faqs) ? $faqs->num_rows : 0 ?>)</span>
            </div>
            <div style="overflow-x:auto;">
                <table class="srt-table">
                    <thead>
                        <tr>
                            <th style="width:110px;">Trạng thái</th>
                            <th>Câu hỏi / Ngày</th>
                            <th style="width:110px;text-align:center;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($faqs) && is_object($faqs) && $faqs->num_rows > 0):
                        $faqs->data_seek(0);
                        while ($faq = $faqs->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?= $faq['status'] === 'pending'
                                    ? '<span class="badge-pending">Chờ duyệt</span>'
                                    : '<span class="badge-active">Đã đăng</span>' ?>
                            </td>
                            <td>
                                <div class="fw-semibold" style="font-size:.88rem;">
                                    <?= htmlspecialchars($faq['question']) ?>
                                </div>
                                <?php if (!empty($faq['answer'])): ?>
                                    <div style="font-size:.8rem;color:#888;margin-top:3px;">
                                        <?= htmlspecialchars(mb_substr($faq['answer'], 0, 80)) ?>…
                                    </div>
                                <?php endif; ?>
                                <div style="font-size:.76rem;color:#aaa;margin-top:4px;">
                                    <?= $faq['created_at'] ? date('d/m/Y', strtotime($faq['created_at'])) : '' ?>
                                </div>
                            </td>
                        <td style="text-align:center;">
                            <div class="srt-actions" style="justify-content:center;">
                                <a href="<?= BASE_PATH ?>/admin/faqs/edit?id=<?= $faq['id'] ?>"
                                class="btn-srt-primary btn-srt-sm text-decoration-none" title="Trả lời / Chỉnh sửa">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form method="POST"
                                    action="<?= BASE_PATH ?>/admin/faqs/delete"
                                    onsubmit="return confirm('Xoá câu hỏi này?')">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $faq['id'] ?>">
                                    <button type="submit" class="btn-srt-danger btn-srt-sm" title="Xoá">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr>
                            <td colspan="3" class="text-center py-5" style="color:#aaa;">
                                <i class="fa-solid fa-circle-question fa-2x mb-2 d-block" style="opacity:.3;"></i>
                                Chưa có câu hỏi nào.
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
