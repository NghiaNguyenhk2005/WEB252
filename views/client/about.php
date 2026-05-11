<?php include __DIR__ . '/components/header.php'; ?>

<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --primary-light: #667eea;
    --primary-dark: #764ba2;
}

.about-hero {
    background: var(--primary-gradient);
    padding: 100px 0;
    margin-bottom: 50px;
    position: relative;
    overflow: hidden;
}

.about-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
    background-size: cover;
    opacity: 0.15;
}

.about-hero .container {
    position: relative;
    z-index: 1;
}

.hero-badge {
    display: inline-block;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 20px;
    letter-spacing: 1px;
}

.hero-title {
    animation: fadeInUp 0.8s ease;
}

.hero-subtitle {
    animation: fadeInUp 0.8s ease 0.2s both;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.main-content-card {
    border: none;
    border-radius: 24px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.main-content-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.about-value-card {
    background: white;
    border-radius: 20px;
    padding: 30px 20px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    height: 100%;
}

.about-value-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: var(--primary-gradient);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.about-value-card:hover::before {
    transform: scaleX(1);
}

.about-value-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
}

.value-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, rgba(102,126,234,0.1) 0%, rgba(118,75,162,0.1) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    transition: all 0.3s ease;
}

.about-value-card:hover .value-icon {
    background: var(--primary-gradient);
    transform: scale(1.1);
}

.value-icon i {
    font-size: 36px;
    color: var(--primary-light);
    transition: all 0.3s ease;
}

.about-value-card:hover .value-icon i {
    color: white;
}

.value-title {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 12px;
    transition: color 0.3s ease;
}

.about-value-card:hover .value-title {
    color: var(--primary-light);
}

.mission-vision {
    background: white;
    border-radius: 24px;
    padding: 40px 30px;
    height: 100%;
    transition: all 0.3s ease;
    border: 1px solid rgba(102,126,234,0.1);
    position: relative;
    overflow: hidden;
}

.mission-vision::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: var(--primary-gradient);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.mission-vision:hover::after {
    transform: scaleX(1);
}

.mission-vision:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(102,126,234,0.1);
    border-color: transparent;
}

.mission-vision i {
    font-size: 48px;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    margin-bottom: 20px;
    display: inline-block;
}

.stats-section {
    background: var(--primary-gradient);
    position: relative;
    overflow: hidden;
}

.stats-card {
    text-align: center;
    padding: 20px;
    position: relative;
    z-index: 1;
}

.stats-number {
    font-size: 48px;
    font-weight: 800;
    margin-bottom: 10px;
    letter-spacing: 2px;
}

.stats-label {
    font-size: 0.9rem;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 1px;
}

@media (max-width: 768px) {
    .about-hero {
        padding: 60px 0;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .stats-number {
        font-size: 32px;
    }
    
    .value-icon {
        width: 60px;
        height: 60px;
    }
    
    .value-icon i {
        font-size: 28px;
    }
    
    .mission-vision {
        padding: 30px 20px;
    }
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.floating {
    animation: float 3s ease-in-out infinite;
}
</style>

<!-- Hero Section -->
<section class="about-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center text-white">
                <div class="hero-badge">
                    <i class="fa-solid fa-building me-2"></i> GIỚI THIỆU
                </div>
                <h1 class="display-3 fw-bold mb-3 hero-title"><?= htmlspecialchars($aboutContent['title'] ?? 'Về chúng tôi') ?></h1>
                <p class="lead mb-0 hero-subtitle"><?= htmlspecialchars($aboutContent['subtitle'] ?? 'Kiến tạo giải pháp công nghệ đột phá cho doanh nghiệp Việt Nam') ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="main-content-card card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="value-icon floating" style="width: 80px; height: 80px; margin: 0 auto 20px;">
                            <i class="fa-solid fa-quote-left" style="font-size: 32px;"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-4 text-center" style="color: var(--primary-light); font-size: 1.5rem;">
                        <?= htmlspecialchars($aboutContent['company_name'] ?? 'TechSaaS') ?> 
                    </h5>
                    
                    <div class="about-content text-center" style="font-size: 1.05rem; line-height: 1.8; color: #444;">
                        <?= $aboutContent['content'] ?? '<p>Chúng tôi cung cấp các giải pháp SaaS (Software as a Service) hiện đại, giúp doanh nghiệp tối ưu hóa quy trình vận hành và tăng trưởng bền vững.</p>
                        <p>Với đội ngũ chuyên gia giàu kinh nghiệm, chúng tôi cam kết mang đến những sản phẩm chất lượng cao, bảo mật tuyệt đối và hỗ trợ khách hàng 24/7.</p>' ?>
                    </div>
                    
                    <div class="text-center mt-4">
                        <span class="badge bg-light text-primary px-3 py-2 rounded-pill">
                            <i class="fa-solid fa-star me-1"></i> Chất lượng hàng đầu
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Value Cards - DYNAMIC from settings -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3">GIÁ TRỊ CỐT LÕI</span>
            <h2 class="fw-bold display-6 mb-3">Điều chúng tôi tin tưởng</h2>
            <p class="text-muted">Những nguyên tắc định hình mọi hoạt động và quyết định của chúng tôi</p>
        </div>
        <div class="row g-4">
            <?php 
            // Use dynamic values from database
            $values = $aboutContent['values'] ?? [];
            if (empty($values)) {
                // Default values if nothing in database
                $values = [
                    ['icon' => 'fa-solid fa-rocket', 'title' => 'Đổi mới sáng tạo', 'desc' => 'Không ngừng cải tiến và phát triển các giải pháp công nghệ tiên tiến nhất'],
                    ['icon' => 'fa-solid fa-handshake', 'title' => 'Đồng hành cùng khách hàng', 'desc' => 'Lắng nghe và thấu hiểu để mang lại giá trị tốt nhất'],
                    ['icon' => 'fa-solid fa-shield', 'title' => 'An toàn - Bảo mật', 'desc' => 'Bảo vệ dữ liệu khách hàng là ưu tiên hàng đầu'],
                    ['icon' => 'fa-solid fa-chart-line', 'title' => 'Phát triển bền vững', 'desc' => 'Hướng đến sự phát triển lâu dài cùng đối tác']
                ];
            }
            foreach ($values as $index => $value):
            ?>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                <div class="about-value-card">
                    <div class="value-icon">
                        <i class="<?= htmlspecialchars($value['icon']) ?>"></i>
                    </div>
                    <h5 class="value-title"><?= htmlspecialchars($value['title']) ?></h5>
                    <p class="text-muted small mb-0" style="line-height: 1.6;"><?= htmlspecialchars($value['desc']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Stats Section - DYNAMIC from settings -->
<section class="stats-section py-5 text-white">
    <div class="container py-4">
        <div class="row g-4 text-center">
            <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="0">
                <div class="stats-card">
                    <div class="stats-number"><?= htmlspecialchars($aboutContent['stat_customers'] ?? '500') ?><span style="font-size: 32px;"></span></div>
                    <div class="stats-label">Doanh nghiệp tin dùng</div>
                </div>
            </div>
            <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="100">
                <div class="stats-card">
                    <div class="stats-number"><?= htmlspecialchars($aboutContent['stat_experts'] ?? '50') ?><span style="font-size: 32px;"></span></div>
                    <div class="stats-label">Chuyên gia công nghệ</div>
                </div>
            </div>
            <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="stats-card">
                    <div class="stats-number">24/7</div>
                    <div class="stats-label">Hỗ trợ khách hàng</div>
                </div>
            </div>
            <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="300">
                <div class="stats-card">
                    <div class="stats-number"><?= htmlspecialchars($aboutContent['stat_uptime'] ?? '99.9') ?><span style="font-size: 32px;"></span></div>
                    <div class="stats-label">Uptime đảm bảo</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision - DYNAMIC from settings -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3">ĐỊNH HƯỚNG</span>
            <h2 class="fw-bold display-6 mb-3">Sứ mệnh & Tầm nhìn</h2>
            <p class="text-muted">Định hướng phát triển của chúng tôi trong tương lai</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6" data-aos="fade-right">
                <div class="mission-vision text-center">
                    <i class="fa-solid fa-bullseye"></i>
                    <h4 class="fw-bold mb-3">Sứ mệnh</h4>
                    <p class="text-muted mb-0" style="line-height: 1.7;"><?= htmlspecialchars($aboutContent['mission'] ?? 'Kiến tạo giải pháp công nghệ đột phá, giúp doanh nghiệp Việt Nam vươn tầm quốc tế.') ?></p>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-left">
                <div class="mission-vision text-center">
                    <i class="fa-solid fa-eye"></i>
                    <h4 class="fw-bold mb-3">Tầm nhìn</h4>
                    <p class="text-muted mb-0" style="line-height: 1.7;"><?= htmlspecialchars($aboutContent['vision'] ?? 'Trở thành nhà cung cấp giải pháp SaaS hàng đầu Đông Nam Á vào năm 2030.') ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center p-5 rounded-4" style="background: linear-gradient(135deg, rgba(102,126,234,0.05) 0%, rgba(118,75,162,0.05) 100%); border: 1px solid rgba(102,126,234,0.2);">
                    <i class="fa-solid fa-handshake fa-2x mb-3" style="color: var(--primary-light);"></i>
                    <h3 class="fw-bold mb-3">Bạn muốn đồng hành cùng chúng tôi?</h3>
                    <p class="text-muted mb-4">Hãy để chúng tôi giúp bạn phát triển doanh nghiệp với giải pháp công nghệ tiên tiến nhất</p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="<?= BASE_PATH ?>/contact" class="btn btn-primary rounded-pill px-4 py-2">
                            <i class="fa-solid fa-envelope me-2"></i>Liên hệ ngay
                        </a>
                        <a href="<?= BASE_PATH ?>/services" class="btn btn-outline-primary rounded-pill px-4 py-2">
                            <i class="fa-solid fa-rocket me-2"></i>Khám phá dịch vụ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/components/footer.php'; ?>