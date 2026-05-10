<?php require_once 'views/client/components/header.php'; ?>

<section class="py-5">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <nav aria-label="breadcrumb" class="mb-5">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php?url=services" class="text-decoration-none">Dịch vụ</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($service['name']) ?></li>
                    </ol>
                </nav>

                <div class="row align-items-center mb-5">
                    <div class="col-md-2 text-center text-md-start mb-4 mb-md-0">
                        <div class="icon-box bg-primary text-white rounded-4 fs-1 d-inline-flex align-items-center justify-content-center shadow" style="width: 100px; height: 100px;">
                            <i class="bi <?= $service['icon'] ?? 'bi-cpu' ?>"></i>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <h1 class="fw-bold display-4 mb-2"><?= htmlspecialchars($service['name']) ?></h1>
                        <p class="lead text-muted mb-0"><?= htmlspecialchars($service['short_description']) ?></p>
                    </div>
                </div>

                <div class="service-content lead text-muted border-top pt-5">
                    <?= $service['detailed_content'] ?>
                </div>

                <div class="cta-box bg-light rounded-4 p-5 mt-5 text-center shadow-sm">
                    <h3 class="fw-bold mb-4">Sẵn sàng trải nghiệm dịch vụ này?</h3>
                    <a href="index.php?url=contact" class="btn btn-gradient btn-lg px-5 rounded-pill shadow">Nhận tư vấn miễn phí</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'views/client/components/footer.php'; ?>