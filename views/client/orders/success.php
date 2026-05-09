<?php require_once 'views/client/components/header.php'; ?>

<div class="container my-5 py-5 text-center" data-aos="zoom-in">
    <div class="mb-4">
        <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
    </div>
    <h1 class="fw-bold mb-3">Đặt hàng thành công!</h1>
    <p class="lead text-muted mb-5 mx-auto" style="max-width: 600px;">
        Cảm ơn bạn đã tin tưởng TechSaaS. Mã đơn hàng của bạn là <span class="fw-bold text-primary">#<?= $_GET['id'] ?? 'N/A' ?></span>. Chúng tôi sẽ liên hệ với bạn qua số điện thoại để xác nhận đơn hàng sớm nhất.
    </p>
    <div class="d-flex justify-content-center gap-3">
        <a href="index.php?url=orders" class="btn btn-outline-primary rounded-pill px-5 py-2">Xem lịch sử đơn hàng</a>
        <a href="index.php" class="btn btn-gradient rounded-pill px-5 py-2">Quay lại trang chủ</a>
    </div>
</div>

<?php require_once 'views/client/components/footer.php'; ?>