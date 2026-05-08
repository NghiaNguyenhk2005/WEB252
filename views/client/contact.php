<?php include __DIR__ . '/components/header.php'; ?>

<!-- Page Hero -->
<section class="py-5 bg-primary bg-opacity-10">
    <div class="container py-3">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted small">Trang chủ</a></li>
                        <li class="breadcrumb-item active text-muted small">Liên hệ</li>
                    </ol>
                </nav>
                <h1 class="display-5 fw-bold mb-3">Liên hệ với chúng tôi</h1>
                <p class="lead text-muted mb-0">Đội ngũ hỗ trợ của TechSaaS sẵn sàng giải đáp mọi thắc mắc của bạn trong vòng 24 giờ.</p>
            </div>
            <div class="col-lg-5 offset-lg-1 mt-4 mt-lg-0 text-center" data-aos="fade-left">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10" style="width:120px;height:120px;">
                    <i class="bi bi-headset text-primary" style="font-size:3.5rem;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Info Cards -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                <div class="card hover-lift h-100 p-4 text-center border-0 shadow-sm">
                    <div class="card-body">
                        <div class="icon-box mx-auto mb-3"><i class="bi bi-telephone-fill"></i></div>
                        <h5 class="fw-bold mb-2">Điện thoại</h5>
                        <p class="text-muted mb-1 small">Thứ 2 – Thứ 6 | 8:00 – 17:00</p>
                        <a href="tel:<?= htmlspecialchars($globalSettings['company_phone'] ?? '0123456789') ?>"
                           class="text-primary fw-semibold text-decoration-none">
                            <?= htmlspecialchars($globalSettings['company_phone'] ?? '0123 456 789') ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card hover-lift h-100 p-4 text-center border-0 shadow-sm">
                    <div class="card-body">
                        <div class="icon-box mx-auto mb-3"><i class="bi bi-envelope-fill"></i></div>
                        <h5 class="fw-bold mb-2">Email</h5>
                        <p class="text-muted mb-1 small">Phản hồi trong vòng 24 giờ</p>
                        <a href="mailto:<?= htmlspecialchars($globalSettings['company_email'] ?? 'contact@techsaas.vn') ?>"
                           class="text-primary fw-semibold text-decoration-none">
                            <?= htmlspecialchars($globalSettings['company_email'] ?? 'contact@techsaas.vn') ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card hover-lift h-100 p-4 text-center border-0 shadow-sm">
                    <div class="card-body">
                        <div class="icon-box mx-auto mb-3"><i class="bi bi-geo-alt-fill"></i></div>
                        <h5 class="fw-bold mb-2">Địa chỉ</h5>
                        <p class="text-muted mb-1 small">Trụ sở chính</p>
                        <span class="text-primary fw-semibold">
                            <?= htmlspecialchars($globalSettings['company_address'] ?? 'Quận 1, TP. Hồ Chí Minh') ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form + Map -->
        <div class="row g-5 align-items-start">

            <!-- Form -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="card border-0 shadow-sm rounded-4 p-2">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-1">Gửi tin nhắn</h4>
                        <p class="text-muted small mb-4">Điền thông tin bên dưới, chúng tôi sẽ phản hồi sớm nhất.</p>

                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success rounded-3 fw-semibold small">
                                <i class="bi bi-check-circle-fill me-2"></i>Tin nhắn của bạn đã được gửi thành công! Chúng tôi sẽ liên hệ lại sớm.
                            </div>
                        <?php endif; ?>
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger rounded-3 fw-semibold small">
                                <i class="bi bi-exclamation-circle-fill me-2"></i>Vui lòng kiểm tra lại thông tin đã nhập.
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="/contact/submit" id="contactForm" novalidate>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Họ và tên <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                                    <input type="text" name="name" id="nameInput"
                                           class="form-control border-start-0 ps-0 rounded-end"
                                           placeholder="Nguyễn Văn A"
                                           value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                                           required minlength="2" maxlength="100">
                                </div>
                                <div class="invalid-feedback">Vui lòng nhập họ tên (ít nhất 2 ký tự).</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                                    <input type="email" name="email" id="emailInput"
                                           class="form-control border-start-0 ps-0 rounded-end"
                                           placeholder="you@example.com"
                                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                           required>
                                </div>
                                <div class="invalid-feedback">Vui lòng nhập email hợp lệ.</div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold small">Nội dung <span class="text-danger">*</span></label>
                                <textarea name="message" id="messageInput" rows="5"
                                          class="form-control rounded-3"
                                          placeholder="Nhập nội dung tin nhắn của bạn..."
                                          required minlength="10" maxlength="2000"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                                <div class="d-flex justify-content-between mt-1">
                                    <div class="invalid-feedback d-block text-danger small" id="msgError" style="display:none!important;"></div>
                                    <small class="text-muted ms-auto" id="charCount">0 / 2000</small>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-gradient w-100 rounded-pill py-2 fw-bold">
                                <i class="bi bi-send-fill me-2"></i>Gửi tin nhắn
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Map / Extra Info -->
            <div class="col-lg-6" data-aos="fade-left">
                <!-- Embedded Map placeholder (Google Maps iframe) -->
                <div class="rounded-4 overflow-hidden shadow-sm mb-4" style="height:300px;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4667!2d106.698!3d10.771!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTDCsDQ2JzE1LjYiTiAxMDbCsDQxJzUyLjgiRQ!5e0!3m2!1svi!2svn!4v1700000000000"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <!-- Working hours -->
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-clock-fill text-primary me-2"></i>Giờ làm việc</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted small">Thứ 2 – Thứ 6</span>
                            <span class="fw-semibold small">08:00 – 17:30</span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted small">Thứ 7</span>
                            <span class="fw-semibold small">08:00 – 12:00</span>
                        </li>
                        <li class="d-flex justify-content-between py-2">
                            <span class="text-muted small">Chủ nhật</span>
                            <span class="text-danger fw-semibold small">Nghỉ</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section (same style as home.php) -->
<section class="py-5 mb-5">
    <div class="container" data-aos="zoom-in">
        <div class="cta-section shadow-lg">
            <h2 class="display-5 fw-bold mb-4">Cần hỗ trợ nhanh hơn?</h2>
            <p class="lead mb-5 opacity-75">Đội ngũ kỹ thuật của chúng tôi hoạt động 24/7 để hỗ trợ doanh nghiệp của bạn.</p>
            <a href="tel:<?= htmlspecialchars($globalSettings['company_phone'] ?? '0123456789') ?>"
               class="btn btn-light text-primary btn-lg px-5 rounded-pill shadow me-3 mb-3 mb-md-0">
                <i class="bi bi-telephone-fill me-2"></i>Gọi ngay
            </a>
            <a href="mailto:<?= htmlspecialchars($globalSettings['company_email'] ?? 'contact@techsaas.vn') ?>"
               class="btn btn-outline-light btn-lg px-5 rounded-pill mb-3 mb-md-0">
                <i class="bi bi-envelope-fill me-2"></i>Gửi email
            </a>
        </div>
    </div>
</section>

<script>
// Character counter for message
const msgInput    = document.getElementById('messageInput');
const charCount   = document.getElementById('charCount');
if (msgInput) {
    msgInput.addEventListener('input', function() {
        charCount.textContent = this.value.length + ' / 2000';
        if (this.value.length > 1800) charCount.classList.add('text-warning');
        else charCount.classList.remove('text-warning');
    });
}

// Client-side validation
document.getElementById('contactForm').addEventListener('submit', function(e) {
    let valid = true;
    const name  = document.getElementById('nameInput');
    const email = document.getElementById('emailInput');
    const msg   = document.getElementById('messageInput');

    [name, email, msg].forEach(el => el.classList.remove('is-invalid'));

    if (!name.value.trim() || name.value.trim().length < 2) {
        name.classList.add('is-invalid'); valid = false;
    }
    const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRe.test(email.value.trim())) {
        email.classList.add('is-invalid'); valid = false;
    }
    if (!msg.value.trim() || msg.value.trim().length < 10) {
        msg.classList.add('is-invalid');
        document.getElementById('msgError').textContent = 'Nội dung ít nhất 10 ký tự.';
        document.getElementById('msgError').style.display = 'block';
        valid = false;
    }
    if (!valid) e.preventDefault();
});
</script>

<?php include __DIR__ . '/components/footer.php'; ?>
