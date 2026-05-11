<?php include __DIR__ . '/components/header.php'; ?>

<!-- Hero -->
<section class="py-5 bg-primary bg-opacity-10">
    <div class="container py-3">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="<?= BASE_PATH ?>/" class="text-decoration-none text-muted small">Trang chủ</a></li>
                        <li class="breadcrumb-item active text-muted small">Liên hệ</li>
                    </ol>
                </nav>
                <h1 class="display-5 fw-bold mb-3">Kết nối với chúng tôi</h1>
                <p class="lead text-muted mb-0">
                    Bạn có câu hỏi hoặc muốn tư vấn về giải pháp chuyển đổi số? Đội ngũ của chúng tôi sẽ phản hồi trong vòng 24h.
                </p>
            </div>
            <div class="col-lg-5 offset-lg-1 mt-4 mt-lg-0 text-center" data-aos="fade-left">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10"
                     style="width:120px;height:120px;">
                    <i class="bi bi-headset text-primary" style="font-size:3.5rem;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main contact section -->
<section class="py-5">
    <div class="container my-3">
        <div class="row g-5">

            <!-- Left: dark info card -->
            <div class="col-lg-5" data-aos="fade-right">
                <div class="card border-0 bg-dark text-white rounded-4 p-5 h-100 shadow-lg">
                    <h3 class="fw-bold mb-2">Thông tin liên hệ</h3>
                    <p class="text-secondary mb-4">Chào mừng bạn ghé thăm văn phòng hoặc liên hệ trực tiếp qua các kênh sau:</p>

                    <!-- HOTLINE - Blue background, white icon -->
                    <div class="contact-info-item d-flex align-items-center mb-4">
                        <div class="icon-box bg-primary rounded-circle me-3 flex-shrink-0">
                            <i class="fas fa-phone-alt text-white"></i>
                        </div>
                        <div>
                            <p class="mb-0 small text-secondary text-uppercase">HOTLINE</p>
                            <h6 class="mb-0 text-white"><?= htmlspecialchars($globalSettings['company_phone'] ?? '0123 456 789') ?></h6>
                        </div>
                    </div>

                    <!-- EMAIL - Green background, white icon -->
                    <div class="contact-info-item d-flex align-items-center mb-4">
                        <div class="icon-box bg-success rounded-circle me-3 flex-shrink-0">
                            <i class="fas fa-envelope text-white"></i>
                        </div>
                        <div>
                            <p class="mb-0 small text-secondary text-uppercase">EMAIL</p>
                            <h6 class="mb-0 text-white"><?= htmlspecialchars($globalSettings['company_email'] ?? 'contact@techsaas.vn') ?></h6>
                        </div>
                    </div>

                    <!-- ADDRESS - Yellow background, white icon -->
                    <div class="contact-info-item d-flex align-items-center mb-4">
                        <div class="icon-box bg-warning rounded-circle me-3 flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-white"></i>
                        </div>
                        <div>
                            <p class="mb-0 small text-secondary text-uppercase">ĐỊA CHỈ</p>
                            <h6 class="mb-0 text-white"><?= htmlspecialchars($globalSettings['company_address'] ?? 'Quận 12, TP. Hồ Chí Minh') ?></h6>
                        </div>
                    </div>

                    <!-- HOURS - Cyan background, white icon -->
                    <div class="contact-info-item d-flex align-items-center mb-5">
                        <div class="icon-box bg-info rounded-circle me-3 flex-shrink-0">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <div>
                            <p class="mb-0 small text-secondary text-uppercase">GIỜ LÀM VIỆC</p>
                            <h6 class="mb-0 text-white">T2–T6: 08:00–17:30 | T7: 08:00–12:00</h6>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <h6 class="text-uppercase small text-secondary mb-3">Mạng xã hội</h6>
                        <div class="d-flex gap-3">
                            <a href="https://facebook.com/techsaas.vn" class="social-icon-contact" target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://linkedin.com/company/techsaas" class="social-icon-contact" target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="https://twitter.com/techsaas" class="social-icon-contact" target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://instagram.com/techsaas" class="social-icon-contact" target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: form -->
            <div class="col-lg-7" data-aos="fade-left">
                <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm border h-100">
                    <h4 class="fw-bold mb-1">Gửi tin nhắn</h4>
                    <p class="text-muted small mb-4">Điền thông tin bên dưới, chúng tôi sẽ phản hồi sớm nhất.</p>

                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success rounded-3 fw-semibold small">
                            <i class="bi bi-check-circle-fill me-2"></i>Tin nhắn đã được gửi thành công! Chúng tôi sẽ liên hệ lại sớm.
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger rounded-3 fw-semibold small">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>Vui lòng kiểm tra lại thông tin đã nhập.
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= BASE_PATH ?>/contact/submit" id="contactForm" novalidate>
                        <?= csrf_field() ?>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="nameInput"
                                       class="form-control rounded-3 p-3"
                                       placeholder="Nguyễn Văn A"
                                       value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                                       required minlength="2" maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="emailInput"
                                       class="form-control rounded-3 p-3"
                                       placeholder="you@example.com"
                                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                       required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold small">Nội dung <span class="text-danger">*</span></label>
                                <textarea name="message" id="messageInput" rows="6"
                                          class="form-control rounded-3 p-3"
                                          placeholder="Tôi muốn hỏi về..."
                                          required minlength="10" maxlength="2000"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                                <div class="d-flex justify-content-between mt-1">
                                    <div class="text-danger small fw-semibold" id="msgError" style="display:none;"></div>
                                    <small class="text-muted ms-auto" id="charCount">0 / 2000</small>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-gradient btn-lg w-100 rounded-pill py-3 fw-bold shadow">
                                    <i class="bi bi-send-fill me-2"></i>Gửi thông tin ngay
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map -->
<section class="py-5 mb-5" data-aos="zoom-in">
    <div class="container">
        <div class="ratio ratio-21x9 rounded-4 overflow-hidden shadow">
            <?php $mapAddress = urlencode($globalSettings['company_address'] ?? 'Quận 12, TP. Hồ Chí Minh'); ?>
            <iframe src="https://www.google.com/maps?q=<?= $mapAddress ?>&output=embed"
                    style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>

<style>
/* Contact Info Items Animation */
.contact-info-item {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.contact-info-item:hover {
    transform: translateX(10px);
}

.contact-info-item:hover .icon-box {
    transform: scale(1.1);
    transition: transform 0.3s ease;
}

/* Icon Box Styling - Keep original colors, icons white */
.icon-box {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.icon-box i {
    color: white !important;
    font-size: 1.3rem;
}

/* Social Icons for Contact Page */
.social-icon-contact {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    color: white;
    font-size: 1.2rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
}

.social-icon-contact:hover {
    background: #4361ee;
    color: white;
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
}

/* Form Input Focus Animation */
.form-control {
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #4361ee;
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    transform: translateY(-2px);
}

/* Button Hover Animation */
.btn-gradient {
    background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
    border: none;
    color: white;
    transition: all 0.3s ease;
}

.btn-gradient:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(67, 97, 238, 0.3);
    background: linear-gradient(135deg, #3a0ca3 0%, #4361ee 100%);
}

.btn-gradient:active {
    transform: translateY(1px);
}

/* Responsive */
@media (max-width: 768px) {
    .contact-info-item:hover {
        transform: translateX(5px);
    }
    
    .social-icon-contact {
        width: 38px;
        height: 38px;
        font-size: 1rem;
    }
}
</style>

<script>
const msgInput = document.getElementById('messageInput');
const charCount = document.getElementById('charCount');
if (msgInput) {
    msgInput.addEventListener('input', function() {
        charCount.textContent = this.value.length + ' / 2000';
        charCount.classList.toggle('text-warning', this.value.length > 1800);
    });
}

const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        let valid = true;
        const name   = document.getElementById('nameInput');
        const email  = document.getElementById('emailInput');
        const msg    = document.getElementById('messageInput');
        const msgErr = document.getElementById('msgError');
        
        [name, email, msg].forEach(el => el?.classList.remove('is-invalid'));
        if (msgErr) msgErr.style.display = 'none';
        
        if (!name.value.trim() || name.value.trim().length < 2) { 
            name.classList.add('is-invalid'); 
            valid = false; 
        }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) { 
            email.classList.add('is-invalid'); 
            valid = false; 
        }
        if (!msg.value.trim() || msg.value.trim().length < 10) {
            msg.classList.add('is-invalid');
            if (msgErr) {
                msgErr.textContent = 'Nội dung ít nhất 10 ký tự.';
                msgErr.style.display = 'block';
            }
            valid = false;
        }
        if (!valid) e.preventDefault();
    });
}
</script>

<?php include __DIR__ . '/components/footer.php'; ?>