<?php require_once 'views/admin/partials/header.php'; ?>
<?php 
// Robust safety check for $faq object
if (!isset($faq) || !is_array($faq)) {
    $faq = ['id' => 0, 'question' => 'Không tìm thấy dữ liệu', 'answer' => ''];
}
?>

<div class="main-content-inner p-4">
    <div class="row">
        <div class="col-lg-8 mt-5 mx-auto">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center mb-5 pb-3 border-bottom">
                        <a href="index.php?url=admin/faqs" class="btn btn-light rounded-circle me-3 shadow-xs">
                            <i class="ti-arrow-left"></i>
                        </a>
                        <div>
                            <h4 class="fw-bold mb-1">Trả lời thắc mắc khách hàng</h4>
                            <p class="text-muted small mb-0">Nội dung trả lời sẽ được hiển thị công khai trên website.</p>
                        </div>
                    </div>

                    <form action="index.php?url=admin/faqs/update" method="POST">
                        <input type="hidden" name="id" value="<?= $faq['id'] ?>">
                        
                        <div class="mb-4">
                            <label class="small fw-bold text-uppercase text-muted mb-2">CÂU HỎI NHẬN ĐƯỢC</label>
                            <div class="p-4 bg-light rounded-4 border-left-primary-bold shadow-xs">
                                <h5 class="fw-bold mb-0 text-dark">"<?= htmlspecialchars($faq['question'] ?? '') ?>"</h5>
                            </div>
                        </div>

                        <input type="hidden" name="question" value="<?= htmlspecialchars($faq['question'] ?? '') ?>">

                        <div class="mb-5">
                            <label class="small fw-bold text-uppercase text-muted mb-2">CÂU TRẢ LỜI CỦA BẠN</label>
                            <textarea class="form-control rounded-4 border-primary p-4 shadow-sm" name="answer" rows="12" placeholder="Hãy viết câu trả lời thật chi tiết và hữu ích..." required><?= htmlspecialchars($faq['answer'] ?? '') ?></textarea>
                            <div class="mt-2 d-flex align-items-center text-primary small">
                                <i class="ti-info-alt me-2"></i>
                                <span>Trạng thái sẽ tự động chuyển thành <b>"Đã đăng"</b> sau khi bạn cập nhật.</span>
                            </div>
                        </div>

                        <div class="text-right border-top pt-4">
                            <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 shadow font-weight-bold">
                                <i class="ti-check me-2"></i>Xuất bản câu trả lời
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/admin/partials/footer.php'; ?>