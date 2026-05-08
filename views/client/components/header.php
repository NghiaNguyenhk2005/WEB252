<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?> - Giải pháp Doanh nghiệp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/client/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light glass-nav sticky-top py-3">
        <div class="container">
            <?php if (!empty($globalSettings['site_logo'])): ?>
                <a class="navbar-brand" href="/">
                    <img src="/<?= htmlspecialchars($globalSettings['site_logo']) ?>" alt="Logo" style="height:40px;">
                </a>
            <?php else: ?>
                <a class="navbar-brand fw-bold fs-3 text-gradient" href="/">
                    <?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?>.
                </a>
            <?php endif; ?>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto fw-medium">
                    <li class="nav-item"><a class="nav-link" href="/">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Giải pháp</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Bảng giá</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Tin tức</a></li>
                    <li class="nav-item"><a class="nav-link" href="/contact">Liên hệ</a></li>
                </ul>

                <div class="d-flex ms-lg-4 align-items-center">
                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                                <?php if (!empty($_SESSION['user']['avatar'])): ?>
                                    <img src="/<?= htmlspecialchars($_SESSION['user']['avatar']) ?>" class="rounded-circle me-2" width="32" height="32" style="object-fit:cover;">
                                <?php else: ?>
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width:32px;height:32px;font-size:14px;">
                                        <?= strtoupper(substr($_SESSION['user']['username'], 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                                <span class="fw-medium"><?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li><a class="dropdown-item" href="/profile"><i class="bi bi-person me-2"></i>Thông tin cá nhân</a></li>
                                <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
                                    <li><a class="dropdown-item" href="/admin/contacts"><i class="bi bi-speedometer2 me-2"></i>Quản trị</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="/login" class="btn btn-outline-dark me-2 px-4 rounded-pill">Đăng nhập</a>
                        <a href="/register" class="btn btn-gradient px-4 rounded-pill">Bắt đầu ngay</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
