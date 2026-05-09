<?php require_once 'views/client/components/header.php'; ?>

<!-- 1. HERO SECTION -->
<section class="py-5 bg-primary bg-opacity-10">
    <div class="container py-5 text-center">
        <h1 class="display-4 fw-bold mb-3" data-aos="fade-up">Kết nối với chúng tôi</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;" data-aos="fade-up" data-aos-delay="100">
            Bạn có câu hỏi hoặc muốn tư vấn về giải pháp chuyển đổi số? Hãy để lại thông tin, đội ngũ của chúng tôi sẽ phản hồi trong vòng 24h.
        </p>
    </div>
</section>

<!-- 2. CONTACT CONTENT -->
<section class="py-5">
    <div class="container my-5">
        <div class="row g-5">
            <!-- Contact Info -->
            <div class="col-lg-5" data-aos="fade-right">
                <div class="card border-0 bg-dark text-white rounded-4 p-5 h-100 shadow-lg">
                    <h3 class="fw-bold mb-4">Thông tin liên hệ</h3>
                    <p class="text-secondary mb-5">Chào mừng bạn ghé thăm văn phòng hoặc liên hệ trực tiếp qua các kênh sau:</p>
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-box bg-primary rounded-circle me-3">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div>
                            <p class="mb-0 small text-secondary text-uppercase">Hotline</p>
                            <h5 class="mb-0"><?= htmlspecialchars($globalSettings['company_phone'] ?? '0123 456 789') ?></h5>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-box bg-success rounded-circle me-3">
                            <i class="bi bi-envelope-at-fill"></i>
                        </div>
                        <div>
                            <p class="mb-0 small text-secondary text-uppercase">Email</p>
                            <h5 class="mb-0"><?= htmlspecialchars($globalSettings['company_email'] ?? 'contact@techsaas.vn') ?></h5>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-5">
                        <div class="icon-box bg-warning rounded-circle me-3 text-dark">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div>
                            <p class="mb-0 small text-secondary text-uppercase">Địa chỉ</p>
                            <h5 class="mb-0"><?= htmlspecialchars($globalSettings['company_address'] ?? 'Quận 1, TP. Hồ Chí Minh') ?></h5>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <h6 class="text-uppercase small text-secondary mb-3">Mạng xã hội</h6>
                        <div class="d-flex gap-3">
                            <a href="#" class="btn btn-outline-light rounded-circle p-2"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="btn btn-outline-light rounded-circle p-2"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="btn btn-outline-light rounded-circle p-2"><i class="bi bi-twitter-x"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-7" data-aos="fade-left">
                <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm border">
                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success border-0 rounded-4 p-3 mb-4">
                            <i class="bi bi-check-circle-fill me-2"></i> Gửi liên hệ thành công! Chúng tôi sẽ sớm phản hồi.
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger border-0 rounded-4 p-3 mb-4">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Vui lòng điền đầy đủ thông tin hợp lệ.
                        </div>
                    <?php endif; ?>

                    <form action="index.php?url=contact/submit" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Họ và tên</label>
                                <input type="text" name="name" class="form-control rounded-3 p-3" placeholder="Nguyễn Văn A" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Địa chỉ Email</label>
                                <input type="email" name="email" class="form-control rounded-3 p-3" placeholder="email@example.com" required>
                            </div>
                            <div class="col-12 mt-4">
                                <label class="form-label fw-bold">Lời nhắn của bạn</label>
                                <textarea name="message" class="form-control rounded-3 p-3" rows="6" placeholder="Tôi muốn hỏi về..." required></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-gradient btn-lg px-5 rounded-pill w-100 py-3 shadow">Gửi thông tin ngay</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. MAP SECTION -->
<section class="mb-n5 position-relative z-1" data-aos="zoom-in">
    <div class="container">
        <div class="ratio ratio-21x9 rounded-4 overflow-hidden shadow">
            <?php 
                $mapAddress = urlencode($globalSettings['company_address'] ?? 'Quận 1, TP. Hồ Chí Minh');
                $mapUrl = "https://www.google.com/maps?q={$mapAddress}&output=embed";
            ?>
            <iframe src="<?= $mapUrl ?>" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>

<?php require_once 'views/client/components/footer.php'; ?>