<?php require_once 'views/client/components/header.php'; ?>

<!-- 1. HERO CAROUSEL (DYNAMIC FROM SLIDERS) -->
<header id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-touch="true">
    <div class="carousel-indicators">
        <?php if ($sliders && $sliders->num_rows > 0): ?>
            <?php for($i=0; $i<$sliders->num_rows; $i++): ?>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $i ?>" class="<?= $i === 0 ? 'active' : '' ?>"></button>
            <?php endfor; ?>
        <?php endif; ?>
    </div>
    <div class="carousel-inner">
        <?php if ($sliders && $sliders->num_rows > 0): ?>
            <?php $i=0; while($slider = $sliders->fetch_assoc()): ?>
                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                    <img src="<?= $slider['image_url'] ?>" class="carousel-image-bg" alt="<?= $slider['title'] ?>">
                    <div class="container">
                        <div class="carousel-caption col-lg-7 col-md-9 text-start">
                            <?php if ($slider['subtitle']): ?>
                                <span class="badge bg-primary bg-opacity-25 text-white mb-3 py-2 px-3 rounded-pill border border-primary animate__animated animate__fadeInDown"><?= htmlspecialchars($slider['subtitle']) ?></span>
                            <?php endif; ?>
                            <h1 class="display-3 fw-bold text-white mb-4 animate__animated animate__fadeInLeft"><?= htmlspecialchars($slider['title']) ?></h1>
                            <div class="animate__animated animate__fadeInUp animate__delay-1s">
                                <a href="<?= $slider['button_link'] ?? '#' ?>" class="btn btn-gradient btn-lg px-5 rounded-pill shadow-lg"><?= $slider['button_text'] ?? 'Khám phá' ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php $i++; endwhile; ?>
        <?php else: ?>
            <!-- Fallback Slide if no sliders in DB -->
            <div class="carousel-item active">
                <img src="assets/client/img/bg1.jpg" class="carousel-image-bg" alt="Default Hero">
                <div class="container">
                    <div class="carousel-caption col-lg-7 col-md-9 text-start">
                        <h1 class="display-3 fw-bold text-white mb-4 animate__animated animate__fadeInLeft">Chào mừng đến với TechSaaS</h1>
                        <a href="index.php?url=products" class="btn btn-gradient btn-lg px-5 rounded-pill animate__animated animate__fadeInUp animate__delay-1s">Bắt đầu ngay</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
</header>

<!-- 2. SECTION ĐỐI TÁC -->
<section class="py-4 border-bottom bg-white">
    <div class="container text-center">
        <p class="text-muted small fw-bold mb-4 text-uppercase tracking-wide" data-aos="fade-up">Được tin dùng bởi 500+ doanh nghiệp</p>
        <div class="row justify-content-center align-items-center opacity-75" data-aos="fade-up" data-aos-delay="100">
            <div class="col-4 col-md-2 mb-3"><h4 class="fw-bold mb-0">GOOGLE</h4></div>
            <div class="col-4 col-md-2 mb-3"><h4 class="fw-bold mb-0">MICROSOFT</h4></div>
            <div class="col-4 col-md-2 mb-3"><h4 class="fw-bold mb-0">AMAZON</h4></div>
            <div class="col-4 col-md-2 mb-3"><h4 class="fw-bold mb-0">CISCO</h4></div>
            <div class="col-4 col-md-2 mb-3"><h4 class="fw-bold mb-0">IBM</h4></div>
        </div>
    </div>
</section>

<!-- 3. SECTION Z-PATTERN -->
<section class="py-5 bg-white overflow-hidden">
    <div class="container my-5">
        <div class="row align-items-center mb-5 pb-5 border-bottom">
            <div class="col-lg-5" data-aos="fade-right">
                <h2 class="fw-bold mb-4">Đồng bộ hoá toàn diện</h2>
                <p class="text-muted lead">Loại bỏ sự phân mảnh dữ liệu giữa các phòng ban. Mọi thông tin được xử lý tập trung trên một Dashboard duy nhất với tốc độ mili-giây.</p>
                <ul class="list-unstyled mt-4 text-muted">
                    <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i>API mở cho phép tích hợp 100+ công cụ</li>
                    <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i>Kiến trúc Microservices linh hoạt</li>
                    <li><i class="bi bi-check-circle-fill text-primary me-2"></i>Uptime đảm bảo 99.99%</li>
                </ul>
            </div>
            <div class="col-lg-7 mt-4 mt-lg-0" data-aos="fade-left">
                <img src="assets/client/img/dashboard.jpg" class="img-fluid rounded-4 shadow-sm w-100" alt="Dashboard" style="max-height: 500px; object-fit: cover;">
            </div>
        </div>
        <div class="row align-items-center mt-5 pt-4">
            <div class="col-lg-7 mt-4 mt-lg-0 order-2 order-lg-1" data-aos="fade-right">
                <img src="assets/client/img/mobile-app.jpg" class="img-fluid rounded-4 shadow-sm w-100" alt="Mobile App" style="max-height: 500px; object-fit: cover;">
            </div>
            <div class="col-lg-5 offset-lg-0 order-1 order-lg-2 ps-lg-5" data-aos="fade-left">
                <h2 class="fw-bold mb-4">Quản trị di động</h2>
                <p class="text-muted lead">Không giới hạn không gian làm việc. Ứng dụng di động được tối ưu bằng framework Native mang lại trải nghiệm mượt mà không độ trễ.</p>
                <a href="#" class="btn btn-outline-primary rounded-pill px-4 mt-3">Tải ứng dụng</a>
            </div>
        </div>
    </div>
</section>

<!-- 4. SECTION THỐNG KÊ -->
<section class="py-5 bg-primary bg-opacity-10">
    <div class="container py-4">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4 mb-md-0" data-aos="zoom-in" data-aos-delay="0">
                <h2 class="display-4 fw-bold text-primary mb-2">99.9%</h2><p class="text-muted fw-medium mb-0">Uptime Đảm bảo</p>
            </div>
            <div class="col-md-3 col-6 mb-4 mb-md-0" data-aos="zoom-in" data-aos-delay="100">
                <h2 class="display-4 fw-bold text-primary mb-2">10k+</h2><p class="text-muted fw-medium mb-0">Doanh nghiệp</p>
            </div>
            <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="200">
                <h2 class="display-4 fw-bold text-primary mb-2">50M+</h2><p class="text-muted fw-medium mb-0">Giao dịch/Ngày</p>
            </div>
            <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="300">
                <h2 class="display-4 fw-bold text-primary mb-2">24/7</h2><p class="text-muted fw-medium mb-0">Hỗ trợ Kỹ thuật</p>
            </div>
        </div>
    </div>
</section>

<!-- 5. SECTION CARD TÍNH NĂNG -->
<section class="py-5 bg-light">
    <div class="container my-5">
        <div class="text-center mb-5 pb-3" data-aos="fade-up">
            <h2 class="fw-bold display-6">Cấu trúc hạ tầng cốt lõi</h2>
        </div>
        <div class="row g-4">
            <?php 
            $features = [
                ['icon' => '<i class="bi bi-lightning-charge-fill"></i>', 'title' => 'In-Memory DB', 'desc' => 'Xử lý dữ liệu trực tiếp trên RAM, tăng tốc truy vấn gấp 10 lần.'],
                ['icon' => '<i class="bi bi-shield-lock-fill"></i>', 'title' => 'Anti-DDoS', 'desc' => 'Tường lửa WAF tự động phân tích và chặn đứng các truy cập bất thường.'],
                ['icon' => '<i class="bi bi-arrow-repeat"></i>', 'title' => 'Auto-Scaling', 'desc' => 'Tự động mở rộng tài nguyên máy chủ khi lưu lượng truy cập tăng.']
            ];
            $delay = 0;
            foreach ($features as $feat) {
                echo '
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="'.$delay.'">
                    <div class="card hover-lift h-100 p-4">
                        <div class="card-body">
                            <div class="icon-box">'.$feat['icon'].'</div>
                            <h4 class="card-title fw-bold mb-3">'.$feat['title'].'</h4>
                            <p class="card-text text-muted mb-0">'.$feat['desc'].'</p>
                        </div>
                    </div>
                </div>';
                $delay += 100;
            }
            ?>
        </div>
    </div>
</section>

<!-- 5.1 SECTION SẢN PHẨM MỚI NHẤT -->
<section class="py-5 bg-white">
    <div class="container my-5">
        <div class="text-center mb-5 pb-3" data-aos="fade-up">
            <h2 class="fw-bold display-6">Sản phẩm nổi bật</h2>
        </div>
        <div class="row g-4">
            <?php if ($latestProducts && $latestProducts->num_rows > 0): ?>
                <?php while($product = $latestProducts->fetch_assoc()): ?>
                    <div class="col-lg-3 col-md-6" data-aos="fade-up">
                        <div class="card product-card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                            <img src="<?= $product['image'] ?? 'assets/client/img/dashboard.jpg' ?>" class="card-img-top" alt="<?= $product['name'] ?>" style="height: 180px; object-fit: cover;">
                            <div class="card-body p-4 text-center">
                                <h6 class="card-title fw-bold mb-2"><?= $product['name'] ?></h6>
                                <p class="text-primary fw-bold mb-3 small"><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</p>
                                <a href="index.php?url=product/<?= $product['slug'] ?>" class="btn btn-outline-dark btn-sm rounded-pill px-4">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- 6. SECTION BẢNG GIÁ -->
<section class="py-5 bg-white">
    <div class="container my-5">
        <div class="text-center mb-5 pb-3" data-aos="fade-up">
            <h2 class="fw-bold display-6">Bảng giá minh bạch</h2>
            <p class="text-muted">Chọn gói giải pháp phù hợp với quy mô doanh nghiệp của bạn.</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="0">
                <div class="card pricing-card h-100 p-4 bg-light">
                    <div class="card-body">
                        <h5 class="text-muted fw-bold mb-3">Starter</h5>
                        <h2 class="fw-bold mb-4">500.000đ <span class="fs-6 text-muted fw-normal">/tháng</span></h2>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-3"><i class="bi bi-check2 text-success me-2 fw-bold"></i>Quản lý 5 dự án</li>
                            <li class="mb-3"><i class="bi bi-check2 text-success me-2 fw-bold"></i>Lưu trữ 10GB</li>
                            <li class="mb-3"><i class="bi bi-check2 text-success me-2 fw-bold"></i>Hỗ trợ qua Email</li>
                            <li class="mb-3 text-muted opacity-50"><i class="bi bi-x me-2"></i>Phân quyền nâng cao</li>
                        </ul>
                        <a href="#" class="btn btn-outline-primary w-100 rounded-pill">Đăng ký ngay</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card pricing-card popular h-100 p-4">
                    <span class="popular-badge">PHỔ BIẾN NHẤT</span>
                    <div class="card-body">
                        <h5 class="text-primary fw-bold mb-3">Professional</h5>
                        <h2 class="fw-bold mb-4">2.500.000đ <span class="fs-6 text-muted fw-normal">/tháng</span></h2>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-3"><i class="bi bi-check2 text-success me-2 fw-bold"></i>Dự án không giới hạn</li>
                            <li class="mb-3"><i class="bi bi-check2 text-success me-2 fw-bold"></i>Lưu trữ 500GB</li>
                            <li class="mb-3"><i class="bi bi-check2 text-success me-2 fw-bold"></i>Hỗ trợ 24/7 trực tiếp</li>
                            <li class="mb-3"><i class="bi bi-check2 text-success me-2 fw-bold"></i>Phân quyền nâng cao</li>
                        </ul>
                        <a href="#" class="btn btn-gradient w-100 rounded-pill">Dùng thử 14 ngày</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5.2 SECTION TIN TỨC MỚI NHẤT -->
<section class="py-5 bg-light">
    <div class="container my-5">
        <div class="text-center mb-5 pb-3" data-aos="fade-up">
            <h2 class="fw-bold display-6">Tin tức mới nhất</h2>
        </div>
        <div class="row g-4">
            <?php if ($latestPosts && $latestPosts->num_rows > 0): ?>
                <?php while($post = $latestPosts->fetch_assoc()): ?>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                            <img src="<?= $post['thumbnail'] ?? 'assets/client/img/bg1.jpg' ?>" class="card-img-top" alt="<?= $post['title'] ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body p-4">
                                <p class="text-primary small fw-bold mb-2"><?= date('d/m/Y', strtotime($post['created_at'])) ?></p>
                                <h5 class="card-title fw-bold mb-3 text-truncate-2"><?= $post['title'] ?></h5>
                                <a href="index.php?url=news/<?= $post['slug'] ?>" class="text-decoration-none fw-bold small">Xem thêm <i class="bi bi-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- 7. SECTION CALL TO ACTION -->
<section class="py-5 mb-5">
    <div class="container" data-aos="zoom-in">
        <div class="cta-section shadow-lg">
            <h2 class="display-5 fw-bold mb-4">Sẵn sàng chuyển đổi số?</h2>
            <p class="lead mb-5 opacity-75">Tham gia cùng hàng ngàn doanh nghiệp đang tối ưu hoá vận hành mỗi ngày.</p>
            <a href="#" class="btn btn-light text-primary btn-lg px-5 rounded-pill shadow me-3 mb-3 mb-md-0">Tạo tài khoản miễn phí</a>
            <a href="#" class="btn btn-outline-light btn-lg px-5 rounded-pill mb-3 mb-md-0">Liên hệ tư vấn</a>
        </div>
    </div>
</section>

<?php require_once 'views/client/components/footer.php'; ?>