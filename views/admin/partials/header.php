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
        /* ── Breadcrumb fix (Bootstrap 5 requires CSS var) ── */
        .srt-breadcrumb { --bs-breadcrumb-divider: '›'; --bs-breadcrumb-item-padding-x: 0.5rem; }
        .srt-breadcrumb .breadcrumb { margin: 0; padding: 0; background: none; font-size: .8rem; }
        .srt-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
            content: var(--bs-breadcrumb-divider); color: #aaa;
        }
        .srt-breadcrumb .breadcrumb-item a { color: var(--accent); text-decoration: none; }
        .srt-breadcrumb .breadcrumb-item a:hover { text-decoration: underline; }
        .srt-breadcrumb .breadcrumb-item.active { color: #888; }

        :root {
            --sidebar-bg: #1a1f2e;
            --sidebar-width: 240px;
            --topbar-height: 60px;
            --accent: #4e73df;
            --accent-hover: #3a5fc8;
        }
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: 'Nunito', sans-serif; background: #f4f6f9; margin: 0; }

        /* ── Sidebar ─────────────────────────────────────────── */
        .srt-sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-width); height: 100vh;
            background: var(--sidebar-bg);
            display: flex; flex-direction: column;
            z-index: 1000; overflow-y: auto;
            transition: transform .3s;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,.1) transparent;
        }
        .srt-sidebar .brand {
            padding: 20px 24px; font-size: 1.2rem; font-weight: 800;
            color: #fff; letter-spacing: .5px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            text-decoration: none; display: block; flex-shrink: 0;
        }
        .srt-sidebar .brand span { color: var(--accent); }
        .srt-nav { padding: 12px 0; flex: 1; }
        .srt-nav-label {
            font-size: .68rem; font-weight: 800;
            text-transform: uppercase; letter-spacing: 1.2px;
            color: rgba(255,255,255,.3); padding: 14px 24px 6px;
        }
        .srt-nav a {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 24px;
            color: rgba(255,255,255,.65); font-size: .88rem; font-weight: 600;
            text-decoration: none; transition: all .15s;
            border-left: 3px solid transparent;
        }
        .srt-nav a:hover { color: #fff; background: rgba(255,255,255,.05); border-left-color: rgba(255,255,255,.3); }
        .srt-nav a.active { color: #fff; background: rgba(78,115,223,.2); border-left-color: var(--accent); }
        .srt-nav a i { width: 18px; text-align: center; font-size: .9rem; flex-shrink: 0; }

        /* ── Topbar ──────────────────────────────────────────── */
        .srt-topbar {
            position: fixed; top: 0;
            left: var(--sidebar-width); right: 0;
            height: var(--topbar-height);
            background: #fff;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px;
            box-shadow: 0 1px 0 #e9ecef;
            z-index: 999;
        }
        .srt-sidebar-toggle {
            background: none; border: none; cursor: pointer;
            color: #6c757d; font-size: 1.05rem; padding: 6px 8px;
            border-radius: 6px; transition: background .15s;
        }
        .srt-sidebar-toggle:hover { background: #f4f6f9; }
        .topbar-user { display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: .88rem; color: #444; }
        .topbar-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--accent); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: .85rem; overflow: hidden; flex-shrink: 0;
            box-shadow: 0 0 0 2px rgba(78,115,223,.3);
        }
        .topbar-avatar img { width: 100%; height: 100%; object-fit: cover; }

        /* ── Main content ────────────────────────────────────── */
        .srt-main { margin-left: var(--sidebar-width); padding-top: var(--topbar-height); min-height: 100vh; }
        .srt-content { padding: 24px 28px; }

        /* ── Page header ─────────────────────────────────────── */
        .srt-page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 24px; flex-wrap: wrap; gap: 12px;
        }
        .srt-page-header h4 { margin: 0; font-weight: 800; font-size: 1.1rem; color: #2d3748; }
        .srt-page-header .srt-breadcrumb { margin-top: 3px; }

        /* ── Stat pill (right side of page header) ───────────── */
        .srt-stat-pill {
            padding: 6px 16px; background: #f0f4ff;
            border-radius: 20px; border: 1px solid #d0daf5;
            font-weight: 700; font-size: .83rem; color: #444;
        }
        .srt-stat-pill strong { color: var(--accent); }

        /* ── Cards ───────────────────────────────────────────── */
        .srt-card {
            background: #fff; border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 1px 8px rgba(0,0,0,.04);
            overflow: hidden; margin-bottom: 24px;
        }
        .srt-card-header {
            padding: 14px 20px; border-bottom: 1px solid #f0f0f0;
            font-weight: 700; font-size: .88rem;
            display: flex; align-items: center; justify-content: space-between;
            color: #2d3748; background: #fafbff;
        }
        .srt-card-body { padding: 20px; }

        /* ── Dashboard stat cards ────────────────────────────── */
        .dash-stat-card {
            background: #fff; border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 1px 8px rgba(0,0,0,.04);
            padding: 20px 24px; display: flex; align-items: center; gap: 16px;
            margin-bottom: 20px; border-left: 4px solid transparent;
        }
        .dash-stat-card.primary   { border-left-color: #4e73df; }
        .dash-stat-card.success   { border-left-color: #1cc88a; }
        .dash-stat-card.info      { border-left-color: #36b9cc; }
        .dash-stat-card.warning   { border-left-color: #f6c23e; }
        .dash-stat-card.danger    { border-left-color: #e74a3b; }
        .dash-stat-icon {
            width: 52px; height: 52px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; flex-shrink: 0;
        }
        .dash-stat-icon.primary { background: #eef0fb; color: #4e73df; }
        .dash-stat-icon.success { background: #e8faf3; color: #1cc88a; }
        .dash-stat-icon.info    { background: #e8f7fa; color: #36b9cc; }
        .dash-stat-icon.warning { background: #fef9ec; color: #f6c23e; }
        .dash-stat-icon.danger  { background: #fdecea; color: #e74a3b; }
        .dash-stat-label { font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .7px; color: #aaa; margin-bottom: 4px; }
        .dash-stat-value { font-size: 1.6rem; font-weight: 800; color: #2d3748; line-height: 1; }

        /* ── Table ───────────────────────────────────────────── */
        .srt-table { width: 100%; border-collapse: collapse; font-size: .875rem; }
        .srt-table thead th {
            background: #f8f9fc; padding: 10px 14px; text-align: left;
            font-size: .7rem; font-weight: 800; text-transform: uppercase;
            letter-spacing: .8px; color: #7a8599; border-bottom: 2px solid #e9ecef;
            white-space: nowrap;
        }
        .srt-table tbody tr { transition: background .1s; }
        .srt-table tbody tr:hover { background: #f8f9fc; }
        .srt-table tbody td {
            padding: 11px 14px; border-bottom: 1px solid #f0f0f0;
            color: #444; vertical-align: middle;
        }

        /* ── Badges ──────────────────────────────────────────── */
        .badge-new     { background: #e3f0ff; color: #1a6fcf; border-radius: 20px; padding: 3px 10px; font-size: .74rem; font-weight: 700; white-space: nowrap; display: inline-block; }
        .badge-read    { background: #e6f9f0; color: #1a9c5b; border-radius: 20px; padding: 3px 10px; font-size: .74rem; font-weight: 700; white-space: nowrap; display: inline-block; }
        .badge-replied { background: #f0e6ff; color: #7c3aed; border-radius: 20px; padding: 3px 10px; font-size: .74rem; font-weight: 700; white-space: nowrap; display: inline-block; }
        .badge-active  { background: #e6f9f0; color: #1a9c5b; border-radius: 20px; padding: 3px 10px; font-size: .74rem; font-weight: 700; white-space: nowrap; display: inline-block; }
        .badge-banned  { background: #fff0f0; color: #e53e3e; border-radius: 20px; padding: 3px 10px; font-size: .74rem; font-weight: 700; white-space: nowrap; display: inline-block; }
        .badge-admin   { background: #fff3e0; color: #e67e22; border-radius: 20px; padding: 3px 10px; font-size: .74rem; font-weight: 700; white-space: nowrap; display: inline-block; }
        .badge-member  { background: #e3f0ff; color: #1a6fcf; border-radius: 20px; padding: 3px 10px; font-size: .74rem; font-weight: 700; white-space: nowrap; display: inline-block; }
        .badge-pending   { background: #fef9ec; color: #d68910; border-radius: 20px; padding: 3px 10px; font-size: .74rem; font-weight: 700; white-space: nowrap; display: inline-block; }
        .badge-completed { background: #e6f9f0; color: #1a9c5b; border-radius: 20px; padding: 3px 10px; font-size: .74rem; font-weight: 700; white-space: nowrap; display: inline-block; }
        .badge-shipping  { background: #e3f0ff; color: #1a6fcf; border-radius: 20px; padding: 3px 10px; font-size: .74rem; font-weight: 700; white-space: nowrap; display: inline-block; }

        /* ── Action Buttons (fixed: no display:inline-flex conflicts) ── */
        .btn-srt-primary {
            background: var(--accent); color: #fff !important; border: none;
            border-radius: 6px; padding: 6px 14px; font-size: .82rem;
            font-weight: 700; cursor: pointer; transition: background .15s;
            display: inline-flex; align-items: center; justify-content: center;
            gap: 5px; line-height: 1.4; text-decoration: none;
            white-space: nowrap; vertical-align: middle;
        }
        .btn-srt-primary:hover { background: var(--accent-hover); }

        .btn-srt-danger {
            background: #e53e3e; color: #fff !important; border: none;
            border-radius: 6px; padding: 6px 14px; font-size: .82rem;
            font-weight: 700; cursor: pointer; transition: background .15s;
            display: inline-flex; align-items: center; justify-content: center;
            gap: 5px; line-height: 1.4; text-decoration: none;
            white-space: nowrap; vertical-align: middle;
        }
        .btn-srt-danger:hover { background: #c53030; }

        .btn-srt-warning {
            background: #f59e0b; color: #fff !important; border: none;
            border-radius: 6px; padding: 6px 14px; font-size: .82rem;
            font-weight: 700; cursor: pointer; transition: background .15s;
            display: inline-flex; align-items: center; justify-content: center;
            gap: 5px; line-height: 1.4; white-space: nowrap; vertical-align: middle;
        }
        .btn-srt-warning:hover { background: #d97706; }

        .btn-srt-secondary {
            background: #6c757d; color: #fff !important; border: none;
            border-radius: 6px; padding: 6px 14px; font-size: .82rem;
            font-weight: 700; cursor: pointer; transition: background .15s;
            display: inline-flex; align-items: center; justify-content: center;
            gap: 5px; line-height: 1.4; white-space: nowrap; vertical-align: middle;
        }
        .btn-srt-secondary:hover { background: #5a6268; }

        /* Small variant */
        .btn-srt-sm { padding: 4px 9px !important; font-size: .76rem !important; border-radius: 5px !important; gap: 3px !important; }

        /* Fix dropdown-toggle caret inside btn-srt-* */
        .btn-srt-primary.dropdown-toggle::after,
        .btn-srt-danger.dropdown-toggle::after { display: none; }

        /* ── Action group ────────────────────────────────────── */
        .srt-actions { display: flex; align-items: center; gap: 4px; flex-wrap: nowrap; }

        /* ── Pagination ──────────────────────────────────────── */
        .srt-pagination { display: flex; gap: 4px; flex-wrap: wrap; }
        .srt-pagination a,
        .srt-pagination span {
            min-width: 32px; height: 32px;
            padding: 0 10px; border-radius: 6px; font-size: .82rem;
            font-weight: 700; text-decoration: none;
            border: 1px solid #e2e8f0; color: #555; transition: all .15s;
            display: inline-flex; align-items: center; justify-content: center;
        }
        .srt-pagination a:hover { background: var(--accent); color: #fff; border-color: var(--accent); }
        .srt-pagination span.active { background: var(--accent); color: #fff; border-color: var(--accent); }
        .srt-pagination span.disabled { color: #ccc; pointer-events: none; }

        /* ── Alerts ──────────────────────────────────────────── */
        .srt-alert {
            padding: 11px 16px; border-radius: 8px; font-size: .85rem;
            font-weight: 600; margin-bottom: 16px;
            display: flex; align-items: center; gap: 8px;
        }
        .srt-alert-success { background: #e6f9f0; color: #1a9c5b; border: 1px solid #b2eed4; }
        .srt-alert-danger  { background: #fff0f0; color: #e53e3e; border: 1px solid #fcc; }
        .srt-alert-warning { background: #fef9ec; color: #a07000; border: 1px solid #f6df8c; }
        .srt-alert-info    { background: #e3f0ff; color: #1a5fcf; border: 1px solid #b0cfff; }

        /* ── Welcome banner (dashboard) ──────────────────────── */
        .srt-welcome {
            background: linear-gradient(135deg, var(--accent) 0%, #6f42c1 100%);
            border-radius: 12px; padding: 24px 28px; color: #fff;
            margin-bottom: 24px; position: relative; overflow: hidden;
        }
        .srt-welcome::after {
            content: '\f080'; font-family: 'Font Awesome 6 Free'; font-weight: 900;
            position: absolute; right: 28px; top: 50%; transform: translateY(-50%);
            font-size: 4rem; opacity: .12; pointer-events: none;
        }
        .srt-welcome h4 { font-weight: 800; font-size: 1.2rem; margin: 0 0 6px; }
        .srt-welcome p  { margin: 0; opacity: .8; font-size: .88rem; }

        /* ── Responsive ──────────────────────────────────────── */
        @media (max-width: 768px) {
            .srt-sidebar { transform: translateX(-100%); }
            .srt-sidebar.open { transform: translateX(0); box-shadow: 4px 0 20px rgba(0,0,0,.3); }
            .srt-topbar { left: 0; }
            .srt-main { margin-left: 0; }
            .srt-content { padding: 16px; }
        }
    </style>
</head>
<body>

<?php
$currentUrl    = trim($_GET['url'] ?? '', '/');
$adminUsername = $_SESSION['user']['username'] ?? 'Admin';
$adminAvatar   = $_SESSION['user']['avatar']   ?? '';
$bp            = BASE_PATH;

if (!function_exists('srtActive')) {
    function srtActive(string $path): string {
        global $currentUrl;
        return strpos($currentUrl, $path) === 0 ? 'active' : '';
    }
}
?>

<!-- ── Sidebar ────────────────────────────────────────────── -->
<aside class="srt-sidebar" id="srtSidebar">
    <a class="brand" href="<?= $bp ?>/admin/dashboard">
        <?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?><span>.</span>
    </a>
    <nav class="srt-nav">
        <div class="srt-nav-label">Tổng quan</div>
        <a href="<?= $bp ?>/admin/dashboard" class="<?= srtActive('admin/dashboard') ?>">
            <i class="fa-solid fa-gauge-high"></i> Dashboard
        </a>

        <div class="srt-nav-label">Nội dung</div>
        <a href="<?= $bp ?>/admin/products" class="<?= srtActive('admin/products') ?>">
            <i class="fa-solid fa-box-open"></i> Sản phẩm
        </a>
        <a href="<?= $bp ?>/admin/categories" class="<?= srtActive('admin/categories') ?>">
            <i class="fa-solid fa-tags"></i> Danh mục
        </a>
        <a href="<?= $bp ?>/admin/posts" class="<?= srtActive('admin/posts') ?>">
            <i class="fa-solid fa-newspaper"></i> Tin tức
        </a>
        <a href="<?= $bp ?>/admin/services" class="<?= srtActive('admin/services') ?>">
            <i class="fa-solid fa-handshake"></i> Dịch vụ
        </a>
        <a href="<?= $bp ?>/admin/faqs" class="<?= srtActive('admin/faqs') ?>">
            <i class="fa-solid fa-circle-question"></i> FAQ
        </a>
        <div class="srt-nav-label">Thương mại</div>
        <a href="<?= $bp ?>/admin/orders" class="<?= srtActive('admin/orders') ?>">
            <i class="fa-solid fa-receipt"></i> Đơn hàng
        </a>

        <div class="srt-nav-label">Người dùng & Hỗ trợ</div>
        <a href="<?= $bp ?>/admin/users" class="<?= srtActive('admin/users') ?>">
            <i class="fa-solid fa-users"></i> Người dùng
        </a>
        <a href="<?= $bp ?>/admin/contacts" class="<?= srtActive('admin/contacts') ?>">
            <i class="fa-solid fa-envelope"></i> Liên hệ
        </a>

        <div class="srt-nav-label">Hệ thống</div>
        <a href="<?= $bp ?>/admin/settings" class="<?= srtActive('admin/settings') ?>">
            <i class="fa-solid fa-gear"></i> Cài đặt & Slider
        </a>
        <a href="<?= $bp ?>/profile">
            <i class="fa-solid fa-user-pen"></i> Hồ sơ
        </a>
        <a href="<?= $bp ?>/" target="_blank">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Xem website
        </a>
        <a href="<?= $bp ?>/logout" style="color: rgba(231,74,59,.8);">
            <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
        </a>
    </nav>
</aside>

<!-- ── Topbar ─────────────────────────────────────────────── -->
<header class="srt-topbar">
    <div style="display:flex;align-items:center;gap:10px;">
        <button class="srt-sidebar-toggle"
                onclick="document.getElementById('srtSidebar').classList.toggle('open')"
                aria-label="Toggle sidebar">
            <i class="fa-solid fa-bars"></i>
        </button>
        <nav class="srt-breadcrumb d-none d-md-block">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="<?= $bp ?>/admin/dashboard">Admin</a>
                </li>
                <!-- Per-page breadcrumb added via JS below -->
            </ol>
        </nav>
    </div>
    <div class="topbar-user">
        <div class="topbar-avatar">
            <?php if ($adminAvatar): ?>
                <img src="<?= $bp ?>/<?= htmlspecialchars($adminAvatar) ?>" alt="avatar">
            <?php else: ?>
                <?= strtoupper(substr($adminUsername, 0, 1)) ?>
            <?php endif; ?>
        </div>
        <span><?= htmlspecialchars($adminUsername) ?></span>
    </div>
</header>

<!-- ── Main wrapper ───────────────────────────────────────── -->
<main class="srt-main">
<div class="srt-content">
