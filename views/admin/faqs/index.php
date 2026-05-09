<?php require_once 'views/admin/partials/header.php'; ?>

<div class="main-content-inner p-4">
    <div class="row">
        <!-- 1. ADD NEW FAQ (Optional proactive adding) -->
        <div class="col-lg-4 mt-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4 text-dark"><i class="ti-plus me-2 text-primary"></i>Thêm câu hỏi mới</h4>
                    <form action="index.php?url=admin/faqs/store" method="POST">
                        <div class="form-group mb-3">
                            <label class="small fw-bold text-muted">CÂU HỎI</label>
                            <input type="text" class="form-control rounded-3 border-light" name="question" placeholder="Khách hàng thường hỏi gì?" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="small fw-bold text-muted">CÂU TRẢ LỜI</label>
                            <textarea class="form-control rounded-4 border-light" name="answer" rows="6" placeholder="Viết câu trả lời chuẩn tại đây..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 shadow-sm fw-bold">Xuất bản FAQ</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- 2. FAQ LIST & ANSWERING QUEUE -->
        <div class="col-lg-8 mt-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h4 class="fw-bold mb-4 text-dark">Quản lý câu hỏi & trả lời</h4>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light-gray text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-3">Trạng thái</th>
                                    <th>Nội dung câu hỏi</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($faqs) && is_object($faqs) && $faqs->num_rows > 0): ?>
                                    <?php 
                                        $faqs->data_seek(0);
                                        while($faq = $faqs->fetch_assoc()): 
                                    ?>
                                        <tr>
                                            <td class="ps-3">
                                                <?php if($faq['status'] == 'pending'): ?>
                                                    <span class="badge bg-warning-light text-warning rounded-pill px-3">Chờ trả lời</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success-light text-success rounded-pill px-3">Đã đăng</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark mb-1 small"><?= htmlspecialchars($faq['question'] ?? '') ?></div>
                                                <span class="text-muted extra-small">Ngày nhận: <?= date('d/m/Y', strtotime($faq['created_at'])) ?></span>
                                            </td>
                                            <td class="text-center">
                                                <a href="index.php?url=admin/faqs/edit&id=<?= $faq['id'] ?>" class="btn btn-light btn-sm rounded-circle me-2" title="Trả lời/Chỉnh sửa">
                                                    <i class="ti-comment-alt text-primary"></i>
                                                </a>
                                                <a href="index.php?url=admin/faqs/delete&id=<?= $faq['id'] ?>" class="btn btn-light btn-sm rounded-circle" onclick="return confirm('Xóa vĩnh viễn câu hỏi này?')" title="Xóa">
                                                    <i class="ti-trash text-danger"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="py-5 text-center text-muted">
                                            <i class="ti-help-alt display-4 opacity-25 d-block mb-3"></i>
                                            Chưa có câu hỏi nào cần xử lý.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/admin/partials/footer.php'; ?>