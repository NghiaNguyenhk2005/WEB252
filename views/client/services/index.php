<?php require_once 'views/client/components/header.php'; ?>

<section class="py-5 bg-primary bg-opacity-10 text-center">
    <div class="container py-5">
        <h1 class="display-4 fw-bold mb-3" data-aos="fade-up">Giải pháp & Dịch vụ</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;" data-aos="fade-up" data-aos-delay="100">
            Chúng tôi cung cấp các công cụ và hạ tầng cần thiết để doanh nghiệp của bạn bứt phá trong kỷ nguyên số.
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container my-5">
        <div class="row g-4">
            <?php if (isset($services) && is_object($services) && $services->num_rows > 0): ?>
                <?php while($service = $services->fetch_assoc()): ?>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up">
                        <div class="card h-100 border-0 shadow-sm rounded-4 p-4 hover-lift">
                            <div class="card-body">
                                <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-4 fs-2 mb-4 d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                    <i class="bi <?= $service['icon'] ?? 'bi-cpu' ?>"></i>
                                </div>
                                <h4 class="fw-bold mb-3"><?= htmlspecialchars($service['name']) ?></h4>
                                <p class="text-muted mb-4"><?= htmlspecialchars($service['short_description']) ?></p>
                                <a href="index.php?url=service/<?= $service['slug'] ?>" class="btn btn-outline-primary rounded-pill px-4">Tìm hiểu thêm</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5 text-muted">Chưa có dịch vụ nào được cập nhật.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once 'views/client/components/footer.php'; ?>