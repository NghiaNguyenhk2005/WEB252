<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechSaaS - Giải pháp Doanh nghiệp</title>
    <!-- Nhúng CSS Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Nhúng Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Nhúng CSS AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Nhúng Animate.css cho Slider -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <!-- Nhúng file CSS custom của dự án -->
    <link rel="stylesheet" href="assets/client/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light glass-nav sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3 text-gradient" href="index.php">TechSaaS.</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto fw-medium">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?url=products">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?url=news">Tin tức</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?url=faqs">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?url=contact">Liên hệ</a></li>
                </ul>
                
                <!-- Search Bar AJAX (Desktop & Mobile) -->
                <div class="ms-lg-3 mt-3 mt-lg-0 position-relative">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 rounded-start-pill ps-3"><i class="bi bi-search"></i></span>
                        <input type="text" id="ajax-search-input" class="form-control bg-light border-0 rounded-end-pill py-2 pe-4" placeholder="Tìm kiếm..." style="min-width: 200px;">
                    </div>
                    <div id="search-results-dropdown" class="dropdown-menu shadow border-0 mt-2 p-0 overflow-hidden" style="width: 100%; min-width: 300px; right: 0;">
                        <!-- Results will appear here -->
                    </div>
                </div>

                <div class="d-flex ms-lg-4 align-items-center">
                    <?php if (isset($_SESSION['user'])): 
                        /** @var mysqli $conn */
                        global $conn;
                        require_once "app/models/CartModel.php";
                        require_once "app/models/CartItemModel.php";
                        $cartCountModel = new CartModel($conn);
                        $cartItemCountModel = new CartItemModel($conn);
                        $userCart = $cartCountModel->getCartByUserId($_SESSION['user']['id']);
                        $cartItemsResult = $cartItemCountModel->where('cart_id', $userCart['id'])->get();
                        $cartCount = ($cartItemsResult && is_object($cartItemsResult)) ? $cartItemsResult->num_rows : 0;
                    ?>
                        <a href="index.php?url=cart" class="nav-link me-3 position-relative">
                            <i class="bi bi-cart3 fs-4"></i>
                            <?php if ($cartCount > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                    <?= $cartCount ?>
                                </span>
                            <?php endif; ?>
                        </a>
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <img src="<?= $_SESSION['user']['avatar'] ?? 'assets/client/img/dashboard.jpg' ?>" class="rounded-circle me-2 border" width="30" height="30" style="object-fit: cover;">
                                <span><?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3">
                                <li><a class="dropdown-item" href="index.php?url=profile"><i class="bi bi-person-badge me-2"></i>Hồ sơ cá nhân</a></li>
                                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                                    <li><a class="dropdown-item" href="index.php?url=admin/settings"><i class="bi bi-speedometer2 me-2"></i>Quản trị</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item text-danger" href="index.php?url=logout"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="index.php?url=login" class="btn btn-outline-dark me-2 px-4 rounded-pill">Đăng nhập</a>
                        <a href="index.php?url=register" class="btn btn-gradient px-4 rounded-pill">Bắt đầu ngay</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>