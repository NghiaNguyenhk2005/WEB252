<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin Dashboard - TechSaaS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Assets from Srtdash template -->
    <link rel="stylesheet" href="assets/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/admin/css/themify-icons.css">
    <link rel="stylesheet" href="assets/admin/css/metisMenu.css">
    <link rel="stylesheet" href="assets/admin/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/admin/css/slicknav.min.css">
    <!-- amcharts css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="assets/admin/css/typography.css">
    <link rel="stylesheet" href="assets/admin/css/default-css.css">
    <link rel="stylesheet" href="assets/admin/css/styles.css">
    <link rel="stylesheet" href="assets/admin/css/responsive.css">
    <!-- Custom Admin Styles -->
    <link rel="stylesheet" href="assets/admin/css/admin-custom.css">
    <!-- modernizr css -->
    <script src="assets/admin/js/vendor/modernizr-2.8.3.min.js"></script>
</head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin – <?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-bg:#1a1f2e; --sidebar-width:240px; --topbar-height:60px; --accent:#4e73df; --accent-hover:#3a5fc8; }
        * { box-sizing:border-box; }
        body { font-family:'Nunito',sans-serif; background:#f4f6f9; margin:0; }

        /* Sidebar */
        .srt-sidebar { position:fixed; top:0; left:0; width:var(--sidebar-width); height:100vh; background:var(--sidebar-bg); display:flex; flex-direction:column; z-index:1000; overflow-y:auto; transition:transform .3s; }
        .srt-sidebar .brand { padding:20px 24px; font-size:1.2rem; font-weight:800; color:#fff; letter-spacing:.5px; border-bottom:1px solid rgba(255,255,255,.08); text-decoration:none; display:block; }
        .srt-sidebar .brand span { color:var(--accent); }
        .srt-nav { padding:12px 0; }
        .srt-nav-label { font-size:.68rem; font-weight:800; text-transform:uppercase; letter-spacing:1.2px; color:rgba(255,255,255,.35); padding:14px 24px 6px; }
        .srt-nav a { display:flex; align-items:center; gap:10px; padding:10px 24px; color:rgba(255,255,255,.65); font-size:.88rem; font-weight:600; text-decoration:none; transition:all .2s; border-left:3px solid transparent; }
        .srt-nav a:hover, .srt-nav a.active { color:#fff; background:rgba(255,255,255,.06); border-left-color:var(--accent); }
        .srt-nav a i { width:18px; text-align:center; font-size:.95rem; }

        /* Topbar */
        .srt-topbar { position:fixed; top:0; left:var(--sidebar-width); right:0; height:var(--topbar-height); background:#fff; display:flex; align-items:center; justify-content:space-between; padding:0 24px; box-shadow:0 1px 4px rgba(0,0,0,.08); z-index:999; }
        .srt-sidebar-toggle { background:none; border:none; cursor:pointer; color:#555; font-size:1.1rem; padding:4px; }
        .topbar-user { display:flex; align-items:center; gap:8px; font-weight:600; font-size:.9rem; }
        .topbar-avatar { width:34px; height:34px; border-radius:50%; background:var(--accent); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:.85rem; overflow:hidden; }
        .topbar-avatar img { width:100%; height:100%; object-fit:cover; }

        /* Main */
        .srt-main { margin-left:var(--sidebar-width); padding-top:var(--topbar-height); min-height:100vh; }
        .srt-content { padding:28px; }

        /* Page header */
        .srt-page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
        .srt-page-header h4 { margin:0; font-weight:800; font-size:1.1rem; color:#2d3748; }
        .breadcrumb { margin:0; font-size:.8rem; }

        /* Cards */
        .srt-card { background:#fff; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,.07); overflow:hidden; }
        .srt-card-header { padding:14px 20px; border-bottom:1px solid #f0f0f0; font-weight:700; font-size:.9rem; display:flex; align-items:center; justify-content:space-between; color:#2d3748; }
        .srt-card-body { padding:20px; }

        /* Table */
        .srt-table { width:100%; border-collapse:collapse; font-size:.875rem; }
        .srt-table thead th { background:#f8f9fc; padding:10px 14px; text-align:left; font-size:.72rem; font-weight:800; text-transform:uppercase; letter-spacing:.7px; color:#7a8599; border-bottom:2px solid #e9ecef; }
        .srt-table tbody tr:hover { background:#f8f9fc; }
        .srt-table tbody td { padding:12px 14px; border-bottom:1px solid #f0f0f0; color:#444; vertical-align:middle; }

        /* Badges */
        .badge-new     { background:#e3f0ff; color:#1a6fcf; border-radius:20px; padding:3px 10px; font-size:.75rem; font-weight:700; }
        .badge-read    { background:#e6f9f0; color:#1a9c5b; border-radius:20px; padding:3px 10px; font-size:.75rem; font-weight:700; }
        .badge-replied { background:#f0e6ff; color:#7c3aed; border-radius:20px; padding:3px 10px; font-size:.75rem; font-weight:700; }
        .badge-active  { background:#e6f9f0; color:#1a9c5b; border-radius:20px; padding:3px 10px; font-size:.75rem; font-weight:700; }
        .badge-banned  { background:#fff0f0; color:#e53e3e; border-radius:20px; padding:3px 10px; font-size:.75rem; font-weight:700; }
        .badge-admin   { background:#fff3e0; color:#e67e22; border-radius:20px; padding:3px 10px; font-size:.75rem; font-weight:700; }
        .badge-member  { background:#e3f0ff; color:#1a6fcf; border-radius:20px; padding:3px 10px; font-size:.75rem; font-weight:700; }

        /* Buttons */
        .btn-srt-primary { background:var(--accent); color:#fff; border:none; border-radius:6px; padding:7px 16px; font-size:.82rem; font-weight:700; cursor:pointer; transition:background .2s; }
        .btn-srt-primary:hover { background:var(--accent-hover); color:#fff; }
        .btn-srt-danger { background:#e53e3e; color:#fff; border:none; border-radius:6px; padding:7px 16px; font-size:.82rem; font-weight:700; cursor:pointer; }
        .btn-srt-danger:hover { background:#c53030; }
        .btn-srt-sm { padding:4px 10px !important; font-size:.78rem !important; border-radius:5px !important; }

        /* Pagination */
        .srt-pagination { display:flex; gap:6px; flex-wrap:wrap; margin-top:16px; }
        .srt-pagination a, .srt-pagination span { padding:6px 12px; border-radius:6px; font-size:.82rem; font-weight:700; text-decoration:none; border:1px solid #e2e8f0; color:#555; transition:all .2s; }
        .srt-pagination a:hover { background:var(--accent); color:#fff; border-color:var(--accent); }
        .srt-pagination span.active { background:var(--accent); color:#fff; border-color:var(--accent); }
        .srt-pagination span.disabled { color:#bbb; cursor:not-allowed; }

        /* Alerts */
        .srt-alert { padding:10px 16px; border-radius:8px; font-size:.85rem; font-weight:600; margin-bottom:16px; }
        .srt-alert-success { background:#e6f9f0; color:#1a9c5b; border:1px solid #b2eed4; }
        .srt-alert-danger  { background:#fff0f0; color:#e53e3e; border:1px solid #fbb; }

        /* Responsive */
        @media (max-width:768px) {
            .srt-sidebar { transform:translateX(-100%); }
            .srt-sidebar.open { transform:translateX(0); }
            .srt-topbar { left:0; }
            .srt-main { margin-left:0; }
        }
    </style>
</head>
<body>

<?php
$currentUrl = trim($_GET['url'] ?? '', '/');
function srtActive($path) {
    global $currentUrl;
    return strpos($currentUrl, $path) === 0 ? 'active' : '';
}
$adminUsername = $_SESSION['user']['username'] ?? 'Admin';
$adminAvatar   = $_SESSION['user']['avatar']   ?? '';
$bp            = BASE_PATH;
?>

<!-- Sidebar -->
<aside class="srt-sidebar" id="srtSidebar">
    <a class="brand" href="<?= $bp ?>/admin/contacts">
        <?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?><span>.</span>
    </a>
    <nav class="srt-nav">
        <div class="srt-nav-label">Tổng quan</div>
        <a href="<?= $bp ?>/admin/contacts" class="<?= srtActive('admin/contacts') ?>">
            <i class="fa-solid fa-envelope"></i> Liên hệ
        </a>
        <a href="<?= $bp ?>/admin/users" class="<?= srtActive('admin/users') ?>">
            <i class="fa-solid fa-users"></i> Người dùng
        </a>
        <div class="srt-nav-label">Cài đặt</div>
        <a href="<?= $bp ?>/admin/settings" class="<?= srtActive('admin/settings') ?>">
            <i class="fa-solid fa-gear"></i> Cài đặt & Slider
        </a>
        <div class="srt-nav-label">Tài khoản</div>
        <a href="<?= $bp ?>/profile">
            <i class="fa-solid fa-user-pen"></i> Hồ sơ cá nhân
        </a>
        <a href="<?= $bp ?>/logout">
            <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
        </a>
    </nav>
</aside>

<!-- Topbar -->
<header class="srt-topbar">
    <div style="display:flex;align-items:center;gap:12px;">
        <button class="srt-sidebar-toggle" onclick="document.getElementById('srtSidebar').classList.toggle('open')">
            <i class="fa-solid fa-bars"></i>
        </button>
        <span style="font-size:.85rem;color:#aaa;">Admin Panel</span>
    </div>
    <div class="page-container">
        <?php require_once 'views/admin/partials/slider.php'; ?>
        <div class="main-content">
            <!-- header area start -->
            <div class="header-area">
                <div class="row align-items-center">
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li id="full-view"><i class="ti-fullscreen"></i></li>
                            <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- header area end -->
    <div class="topbar-user">
        <div class="topbar-avatar">
            <?php if ($adminAvatar): ?>
                <img src="<?= $bp ?>/<?= htmlspecialchars($adminAvatar) ?>" alt="">
            <?php else: ?>
                <?= strtoupper(substr($adminUsername, 0, 1)) ?>
            <?php endif; ?>
        </div>
        <span><?= htmlspecialchars($adminUsername) ?></span>
    </div>
</header>

<!-- Main -->
<main class="srt-main">
<div class="srt-content">
