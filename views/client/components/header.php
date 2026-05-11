<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php
    // Load SEO class if not already loaded
    if (!class_exists('SEO') && file_exists(__DIR__ . '/../../app/core/SEO.php')) {
        require_once __DIR__ . '/../../app/core/SEO.php';
    }
    
    // Set default SEO for homepage if not set
    if (!isset($seo) && class_exists('SEO')) {
        SEO::set('title', ($globalSettings['site_name'] ?? 'TechSaaS') . ' - Giải pháp Doanh nghiệp')
            ->set('description', $globalSettings['site_description'] ?? 'Nền tảng cung cấp giải pháp công nghệ tối ưu cho doanh nghiệp vừa và nhỏ tại Việt Nam.')
            ->set('keywords', 'techsaas, giải pháp công nghệ, doanh nghiệp, SaaS, chuyển đổi số, Việt Nam')
            ->set('author', $globalSettings['site_name'] ?? 'TechSaaS')
            ->set('og_image', BASE_PATH . '/assets/client/img/og-image.jpg')
            ->set('og_type', 'website');
    }
    
    // Render SEO tags if class exists
    if (class_exists('SEO')) {
        echo SEO::render();
    } else {
        // Fallback SEO tags
        ?>
        <title><?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?> - Giải pháp Doanh nghiệp</title>
        <meta name="description" content="<?= htmlspecialchars($globalSettings['site_description'] ?? 'Nền tảng cung cấp giải pháp công nghệ tối ưu cho doanh nghiệp vừa và nhỏ tại Việt Nam.') ?>">
        <meta name="keywords" content="techsaas, giải pháp công nghệ, doanh nghiệp, SaaS, chuyển đổi số">
        <meta name="author" content="<?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?>">
        <meta name="robots" content="index, follow">
        <link rel="canonical" href="<?= BASE_PATH ?>/">
        <?php
    }
    ?>
    
    <!-- Open Graph / Facebook (Fallback) -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= BASE_PATH ?>/">
    <meta property="og:title" content="<?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?> - Giải pháp Doanh nghiệp">
    <meta property="og:description" content="<?= htmlspecialchars($globalSettings['site_description'] ?? 'Nền tảng cung cấp giải pháp công nghệ tối ưu cho doanh nghiệp vừa và nhỏ tại Việt Nam.') ?>">
    <meta property="og:image" content="<?= BASE_PATH ?>/assets/client/img/og-image.jpg">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?> - Giải pháp Doanh nghiệp">
    <meta name="twitter:description" content="<?= htmlspecialchars($globalSettings['site_description'] ?? 'Nền tảng cung cấp giải pháp công nghệ tối ưu cho doanh nghiệp vừa và nhỏ tại Việt Nam.') ?>">
    <meta name="twitter:image" content="<?= BASE_PATH ?>/assets/client/img/og-image.jpg">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= BASE_PATH ?>/favicon.ico">
    <link rel="apple-touch-icon" href="<?= BASE_PATH ?>/assets/client/img/apple-touch-icon.png">
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/client/css/style.css">
    
    <!-- Preload critical assets -->
    <link rel="preload" href="<?= BASE_PATH ?>/assets/client/css/style.css" as="style">
    
    <!-- Structured Data / JSON-LD for SEO -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?>",
        "url": "<?= BASE_PATH ?>/",
        "logo": "<?= BASE_PATH ?>/assets/client/img/logo.png",
        "description": "<?= htmlspecialchars($globalSettings['site_description'] ?? 'Nền tảng cung cấp giải pháp công nghệ tối ưu cho doanh nghiệp vừa và nhỏ tại Việt Nam.') ?>",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Ho Chi Minh City",
            "addressCountry": "Vietnam"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "<?= htmlspecialchars($globalSettings['company_phone'] ?? '0123 456 789') ?>",
            "contactType": "customer service"
        },
        "sameAs": [
            "https://facebook.com/techsaas.vn",
            "https://linkedin.com/company/techsaas",
            "https://twitter.com/techsaas"
        ]
    }
    </script>
</head>
<body>
<?php $bp = BASE_PATH; ?>
<nav class="navbar navbar-expand-lg navbar-light glass-nav sticky-top py-3">
    <div class="container">
        <?php if (!empty($globalSettings['site_logo'])): ?>
            <a class="navbar-brand" href="<?= $bp ?>/">
                <img src="<?= $bp ?>/<?= htmlspecialchars($globalSettings['site_logo']) ?>" alt="Logo" style="height:40px;">
            </a>
        <?php else: ?>
            <a class="navbar-brand fw-bold fs-3 text-gradient" href="<?= $bp ?>/">
                <?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?>.
            </a>
        <?php endif; ?>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto fw-medium">
                <li class="nav-item"><a class="nav-link" href="<?= $bp ?>/">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $bp ?>/products">Sản phẩm</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $bp ?>/news">Tin tức</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $bp ?>/faqs">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $bp ?>/contact">Liên hệ</a></li>
            </ul>

            <!-- AJAX Search -->
            <div class="ms-lg-3 mt-3 mt-lg-0 position-relative">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0 rounded-start-pill ps-3">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="ajax-search-input"
                           class="form-control bg-light border-0 rounded-end-pill py-2 pe-4"
                           placeholder="Tìm kiếm..." style="min-width:180px;">
                </div>
                <div id="search-results-dropdown"
                     class="dropdown-menu shadow border-0 mt-2 p-0 overflow-hidden"
                     style="width:100%;min-width:300px;right:0;"></div>
            </div>

            <div class="d-flex ms-lg-3 align-items-center">
                <?php if (isset($_SESSION['user'])): ?>
                    <!-- Cart icon -->
                    <a href="<?= $bp ?>/cart" class="nav-link me-3 position-relative">
                        <i class="bi bi-cart3 fs-5"></i>
                        <span id="cart-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem;display:none;">0</span>
                    </a>
                    <!-- User dropdown -->
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <?php if (!empty($_SESSION['user']['avatar'])): ?>
                                <img src="<?= $bp ?>/<?= htmlspecialchars($_SESSION['user']['avatar']) ?>"
                                     class="rounded-circle me-2 border" width="32" height="32" style="object-fit:cover;">
                            <?php else: ?>
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                     style="width:32px;height:32px;font-size:14px;">
                                    <?= strtoupper(substr($_SESSION['user']['username'], 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                            <span class="fw-medium d-none d-lg-inline"><?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item" href="<?= $bp ?>/profile"><i class="bi bi-person me-2"></i>Hồ sơ cá nhân</a></li>
                            <li><a class="dropdown-item" href="<?= $bp ?>/orders"><i class="bi bi-receipt me-2"></i>Đơn hàng của tôi</a></li>
                            <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= $bp ?>/admin/contacts"><i class="bi bi-speedometer2 me-2"></i>Quản trị</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= $bp ?>/logout"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?= $bp ?>/login" class="btn btn-outline-dark me-2 px-4 rounded-pill">Đăng nhập</a>
                    <a href="<?= $bp ?>/register" class="btn btn-gradient px-4 rounded-pill">Bắt đầu ngay</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
