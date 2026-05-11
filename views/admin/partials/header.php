<?php
$currentUrl = trim($_GET['url'] ?? '');
$adminUsername = $_SESSION['user']['username'] ?? 'Admin';
$adminAvatar = $_SESSION['user']['avatar'] ?? '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin – <?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --sidebar-bg: #1a1f2e;
            --sidebar-width: 260px;
            --topbar-height: 60px;
            --accent: #4e73df;
            --accent-hover: #3a5fc8;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background: #f4f6f9;
            overflow-x: hidden;
        }
        
        /* ============================================
           SIDEBAR
        ============================================ */
        .srt-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }
        
        .srt-sidebar.closed {
            transform: translateX(-100%);
        }
        
        .srt-sidebar .brand {
            display: block;
            padding: 20px 24px;
            font-size: 1.2rem;
            font-weight: 800;
            color: #fff;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        
        .srt-sidebar .brand span {
            color: var(--accent);
        }
        
        .srt-nav {
            padding: 12px 0;
        }
        
        .srt-nav-label {
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(255,255,255,0.3);
            padding: 14px 24px 6px;
        }
        
        .srt-nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 24px;
            color: rgba(255,255,255,0.65);
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        
        .srt-nav a:hover {
            color: #fff;
            background: rgba(255,255,255,0.05);
            border-left-color: rgba(255,255,255,0.3);
            padding-left: 28px;
        }
        
        .srt-nav a.active {
            color: #fff;
            background: rgba(78,115,223,0.2);
            border-left-color: var(--accent);
        }
        
        .srt-nav a i {
            width: 20px;
            text-align: center;
            font-size: 0.9rem;
        }
        
        /* ============================================
           TOPBAR
        ============================================ */
        .srt-topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            box-shadow: 0 1px 0 #e9ecef;
            z-index: 999;
            transition: left 0.3s ease;
        }
        
        .srt-topbar.expanded {
            left: 0;
        }
        
        .srt-sidebar-toggle {
            background: none;
            border: none;
            cursor: pointer;
            color: #6c757d;
            font-size: 1.2rem;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        
        .srt-sidebar-toggle:hover {
            background: #f4f6f9;
            transform: scale(1.05);
        }
        
        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 0.88rem;
            color: #444;
        }
        
        .topbar-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--accent);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.85rem;
            overflow: hidden;
        }
        
        .topbar-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        /* ============================================
           MAIN CONTENT
        ============================================ */
        .srt-main {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-height);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        
        .srt-main.expanded {
            margin-left: 0;
        }
        
        .srt-content {
            padding: 24px 28px;
        }
        
        /* ============================================
           PAGE HEADER
        ============================================ */
        .srt-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }
        
        .srt-page-header h4 {
            margin: 0;
            font-weight: 800;
            font-size: 1.1rem;
            color: #2d3748;
        }
        
        /* ============================================
           CARDS
        ============================================ */
        .srt-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            overflow: hidden;
            margin-bottom: 24px;
        }
        
        .srt-card-header {
            padding: 14px 20px;
            border-bottom: 1px solid #f0f0f0;
            font-weight: 700;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fafbff;
        }
        
        .srt-card-body {
            padding: 20px;
        }
        
        /* ============================================
           BUTTONS
        ============================================ */
        .btn-srt-primary {
            background: var(--accent);
            color: #fff !important;
            border: none;
            border-radius: 6px;
            padding: 6px 14px;
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
        }
        
        .btn-srt-primary:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
        }
        
        .btn-srt-danger {
            background: #e53e3e;
            color: #fff !important;
            border: none;
            border-radius: 6px;
            padding: 6px 14px;
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
        }
        
        .btn-srt-danger:hover {
            background: #c53030;
            transform: translateY(-1px);
        }
        
        .btn-srt-warning {
            background: #f59e0b;
            color: #fff !important;
            border: none;
            border-radius: 6px;
            padding: 6px 14px;
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
        }
        
        .btn-srt-warning:hover {
            background: #d97706;
            transform: translateY(-1px);
        }
        
        .btn-srt-sm {
            padding: 4px 9px !important;
            font-size: 0.76rem !important;
        }
        
        .srt-actions {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        /* ============================================
           TABLE
        ============================================ */
        .srt-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }
        
        .srt-table thead th {
            background: #f8f9fc;
            padding: 10px 14px;
            text-align: left;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            color: #7a8599;
            border-bottom: 2px solid #e9ecef;
        }
        
        .srt-table tbody td {
            padding: 11px 14px;
            border-bottom: 1px solid #f0f0f0;
            color: #444;
        }
        
        .srt-table tbody tr:hover {
            background: #f8f9fc;
        }
        
        /* ============================================
           BADGES
        ============================================ */
        .badge-active, .badge-success {
            background: #e6f9f0;
            color: #1a9c5b;
            border-radius: 20px;
            padding: 3px 10px;
            font-size: 0.74rem;
            font-weight: 700;
            display: inline-block;
        }
        
        .badge-pending, .badge-warning {
            background: #fef9ec;
            color: #d68910;
            border-radius: 20px;
            padding: 3px 10px;
            font-size: 0.74rem;
            font-weight: 700;
            display: inline-block;
        }
        
        .badge-banned, .badge-danger {
            background: #fff0f0;
            color: #e53e3e;
            border-radius: 20px;
            padding: 3px 10px;
            font-size: 0.74rem;
            font-weight: 700;
            display: inline-block;
        }
        
        /* ============================================
           DASHBOARD STATS
        ============================================ */
        .dash-stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
            border-left: 4px solid transparent;
        }
        
        .dash-stat-card.primary { border-left-color: #4e73df; }
        .dash-stat-card.success { border-left-color: #1cc88a; }
        .dash-stat-card.info { border-left-color: #36b9cc; }
        .dash-stat-card.warning { border-left-color: #f6c23e; }
        
        .dash-stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }
        
        .dash-stat-icon.primary { background: #eef0fb; color: #4e73df; }
        .dash-stat-icon.success { background: #e8faf3; color: #1cc88a; }
        .dash-stat-icon.info { background: #e8f7fa; color: #36b9cc; }
        .dash-stat-icon.warning { background: #fef9ec; color: #f6c23e; }
        
        .dash-stat-label {
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            color: #aaa;
            margin-bottom: 4px;
        }
        
        .dash-stat-value {
            font-size: 1.6rem;
            font-weight: 800;
            color: #2d3748;
        }
        
        /* ============================================
           RESPONSIVE
        ============================================ */
        @media (max-width: 768px) {
            .srt-sidebar {
                transform: translateX(-100%);
            }
            
            .srt-sidebar.open {
                transform: translateX(0);
            }
            
            .srt-topbar {
                left: 0;
            }
            
            .srt-main {
                margin-left: 0;
            }
            
            .srt-content {
                padding: 16px;
            }
        }
        
        /* Breadcrumb */
        .srt-breadcrumb .breadcrumb {
            margin: 0;
            background: none;
            font-size: 0.8rem;
        }
        
        .srt-breadcrumb .breadcrumb-item a {
            color: var(--accent);
            text-decoration: none;
        }
        
        /* Welcome banner */
        .srt-welcome {
            background: linear-gradient(135deg, var(--accent) 0%, #6f42c1 100%);
            border-radius: 12px;
            padding: 24px 28px;
            color: #fff;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }
        
        .srt-welcome h4 {
            font-weight: 800;
            font-size: 1.2rem;
            margin: 0 0 6px;
        }
        
        .srt-welcome p {
            margin: 0;
            opacity: 0.8;
            font-size: 0.88rem;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="srt-sidebar" id="srtSidebar">
    <a class="brand" href="<?= BASE_PATH ?>/admin/dashboard">
        <?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?><span>.</span>
    </a>
    <nav class="srt-nav">
        <div class="srt-nav-label">TỔNG QUAN</div>
        <a href="<?= BASE_PATH ?>/admin/dashboard" class="<?= strpos($currentUrl ?? '', 'admin/dashboard') !== false ? 'active' : '' ?>">
            <i class="fa-solid fa-gauge-high"></i> Dashboard
        </a>

        <div class="srt-nav-label">NỘI DUNG</div>
        <a href="<?= BASE_PATH ?>/admin/products" class="<?= strpos($currentUrl ?? '', 'admin/products') !== false ? 'active' : '' ?>">
            <i class="fa-solid fa-box-open"></i> Sản phẩm
        </a>
        <a href="<?= BASE_PATH ?>/admin/categories" class="<?= strpos($currentUrl ?? '', 'admin/categories') !== false ? 'active' : '' ?>">
            <i class="fa-solid fa-tags"></i> Danh mục
        </a>
        <a href="<?= BASE_PATH ?>/admin/posts" class="<?= strpos($currentUrl ?? '', 'admin/posts') !== false ? 'active' : '' ?>">
            <i class="fa-solid fa-newspaper"></i> Tin tức
        </a>
        <a href="<?= BASE_PATH ?>/admin/services" class="<?= strpos($currentUrl ?? '', 'admin/services') !== false ? 'active' : '' ?>">
            <i class="fa-solid fa-handshake"></i> Dịch vụ
        </a>
        <a href="<?= BASE_PATH ?>/admin/faqs" class="<?= strpos($currentUrl ?? '', 'admin/faqs') !== false ? 'active' : '' ?>">
            <i class="fa-solid fa-circle-question"></i> FAQ
        </a>

        <div class="srt-nav-label">THƯƠNG MẠI</div>
        <a href="<?= BASE_PATH ?>/admin/orders" class="<?= strpos($currentUrl ?? '', 'admin/orders') !== false ? 'active' : '' ?>">
            <i class="fa-solid fa-receipt"></i> Đơn hàng
        </a>

        <div class="srt-nav-label">NGƯỜI DÙNG & HỖ TRỢ</div>
        <a href="<?= BASE_PATH ?>/admin/users" class="<?= strpos($currentUrl ?? '', 'admin/users') !== false ? 'active' : '' ?>">
            <i class="fa-solid fa-users"></i> Người dùng
        </a>
        <a href="<?= BASE_PATH ?>/admin/contacts" class="<?= strpos($currentUrl ?? '', 'admin/contacts') !== false ? 'active' : '' ?>">
            <i class="fa-solid fa-envelope"></i> Liên hệ
        </a>

        <div class="srt-nav-label">HỆ THỐNG</div>
        <a href="<?= BASE_PATH ?>/admin/settings" class="<?= strpos($currentUrl ?? '', 'admin/settings') !== false ? 'active' : '' ?>">
            <i class="fa-solid fa-gear"></i> Cài đặt & Slider
        </a>
        <a href="<?= BASE_PATH ?>/profile">
            <i class="fa-solid fa-user-pen"></i> Hồ sơ
        </a>
        <a href="<?= BASE_PATH ?>/" target="_blank">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Xem website
        </a>
        <a href="<?= BASE_PATH ?>/logout" style="color: rgba(231,74,59,.8);">
            <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
        </a>
    </nav>
</aside>

<!-- TOPBAR -->
<header class="srt-topbar" id="srtTopbar">
    <div style="display:flex;align-items:center;gap:10px;">
        <button class="srt-sidebar-toggle" id="sidebarToggleBtn">
            <i class="fa-solid fa-bars"></i>
        </button>
        <nav class="srt-breadcrumb d-none d-md-block">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="<?= BASE_PATH ?>/admin/dashboard">Admin</a>
                </li>
            </ol>
        </nav>
    </div>
    <div class="topbar-user">
        <div class="topbar-avatar">
            <?php if (!empty($adminAvatar)): ?>
                <img src="<?= BASE_PATH ?>/<?= htmlspecialchars($adminAvatar) ?>" alt="avatar">
            <?php else: ?>
                <?= strtoupper(substr($adminUsername, 0, 1)) ?>
            <?php endif; ?>
        </div>
        <span><?= htmlspecialchars($adminUsername) ?></span>
    </div>
</header>

<!-- MAIN CONTENT -->
<main class="srt-main" id="srtMain">
    <div class="srt-content">