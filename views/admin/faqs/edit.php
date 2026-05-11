<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="srt-page-header">
    <div>
        <h4>
            <i class="fa-solid fa-pen me-2" style="color:var(--accent);"></i>
            Trả lời câu hỏi FAQ
        </h4>
    </div>
    <a href="<?= BASE_PATH ?>/admin/faqs" class="btn-srt-secondary text-decoration-none">
        <i class="fa-solid fa-arrow-left me-2"></i> Quay lại
    </a>
</div>

<div class="srt-card">
    <div class="srt-card-header">
        <span>
            <i class="fa-solid fa-circle-question me-2"></i>
            Câu hỏi từ khách hàng
        </span>
    </div>

    <div style="padding:24px;">
        <form action="<?= BASE_PATH ?>/admin/faqs/update" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $faq['id'] ?>">
            
            <div class="mb-4">
                <label class="form-label fw-bold">Câu hỏi:</label>
                <div class="p-4 bg-light rounded-3" style="background:#f8f9fa;">
                    <h5 class="mb-0">"<?= htmlspecialchars($faq['question'] ?? '') ?>"</h5>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Câu trả lời:</label>
                <textarea class="form-control" name="answer" rows="8" 
                          placeholder="Nhập câu trả lời chi tiết..." 
                          required><?= htmlspecialchars($faq['answer'] ?? '') ?></textarea>
                <small class="text-muted">Trạng thái sẽ tự động chuyển thành "Đã đăng" sau khi cập nhật.</small>
            </div>

            <div class="text-end">
                <a href="<?= BASE_PATH ?>/admin/faqs" class="btn-srt-secondary me-2">
                    <i class="fa-solid fa-times me-2"></i>Hủy bỏ
                </a>
                <button type="submit" class="btn-srt-primary">
                    <i class="fa-solid fa-paper-plane me-2"></i>Xuất bản câu trả lời
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>