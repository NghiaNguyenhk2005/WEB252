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
        }
        .srt-sidebar .brand {
            padding: 20px 24px; font-size: 1.2rem; font-weight: 800;
            color: #fff; letter-spacing: .5px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            text-decoration: none; display: block;
        }
        .srt-sidebar .brand span { color: var(--accent); }
        .srt-nav { padding: 12px 0; }
        .srt-nav-label {
            font-size: .68rem; font-weight: 800;
            text-transform: uppercase; letter-spacing: 1.2px;
            color: rgba(255,255,255,.35); padding: 14px 24px 6px;
        }
        .srt-nav a {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 24px;
            color: rgba(255,255,255,.65); font-size: .88rem; font-weight: 600;
            text-decoration: none; transition: all .2s;
            border-left: 3px solid transparent;
        }
        .srt-nav a:hover, .srt-nav a.active {
            color: #fff; background: rgba(255,255,255,.06);
            border-left-color: var(--accent);
        }
        .srt-nav a i { width: 18px; text-align: center; font-size: .95rem; }

        /* ── Topbar ──────────────────────────────────────────── */
        .srt-topbar {
            position: fixed; top: 0;
            left: var(--sidebar-width); right: 0;
            height: var(--topbar-height);
            background: #fff;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px;
            box-shadow: 0 1px 4px rgba(0,0,0,.08);
            z-index: 999;
        }
        .srt-sidebar-toggle {
            background: none; border: none; cursor: pointer;
            color: #555; font-size: 1.1rem; padding: 4px;
        }
        .topbar-user { display: flex; align-items: center; gap: 8px; font-weight: 600; font-size: .9rem; }
        .topbar-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--accent); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .85rem; overflow: hidden;
            flex-shrink: 0;
        }
        .topbar-avatar img { width: 100%; height: 100%; object-fit: cover; }

        /* ── Main content ────────────────────────────────────── */
        .srt-main { margin-left: var(--sidebar-width); padding-top: var(--topbar-height); min-height: 100vh; }
        .srt-content { padding: 28px; }

        /* ── Page header ─────────────────────────────────────── */
        .srt-page-header {
            display: flex; align-items: flex-start; justify-content: space-between;
            margin-bottom: 24px; flex-wrap: wrap; gap: 12px;
        }
        .srt-page-header h4 { margin: 0; font-weight: 800; font-size: 1.1rem; color: #2d3748; }
        .breadcrumb { margin: 4px 0 0; font-size: .8rem; }

        /* ── Cards ───────────────────────────────────────────── */
        .srt-card { background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,.07); overflow: hidden; margin-bottom: 24px; }
        .srt-card-header {
            padding: 14px 20px; border-bottom: 1px solid #f0f0f0;
            font-weight: 700; font-size: .9rem;
            display: flex; align-items: center; justify-content: space-between;
            color: #2d3748;
        }
        .srt-card-body { padding: 20px; }

        /* ── Table ───────────────────────────────────────────── */
        .srt-table { width: 100%; border-collapse: collapse; font-size: .875rem; }
        .srt-table thead th {
            background: #f8f9fc; padding: 10px 14px; text-align: left;
            font-size: .72rem; font-weight: 800; text-transform: uppercase;
            letter-spacing: .7px; color: #7a8599; border-bottom: 2px solid #e9ecef;
        }
        .srt-table tbody tr:hover { background: #f8f9fc; }
        .srt-table tbody td { padding: 12px 14px; border-bottom: 1px solid #f0f0f0; color: #444; vertical-align: middle; }

        /* ── Badges ──────────────────────────────────────────── */
        .badge-new     { background: #e3f0ff; color: #1a6fcf; border-radius: 20px; padding: 3px 10px; font-size: .75rem; font-weight: 700; white-space: nowrap; }
        .badge-read    { background: #e6f9f0; color: #1a9c5b; border-radius: 20px; padding: 3px 10px; font-size: .75rem; font-weight: 700; white-space: nowrap; }
        .badge-replied { background: #f0e6ff; color: #7c3aed; border-radius: 20px; padding: 3px 10px; font-size: .75rem; font-weight: 700; white-space: nowrap; }
        .badge-active  { background: #e6f9f0; color: #1a9c5b; border-radius: 20px; padding: 3px 10px; font-size: .75rem; font-weight: 700; white-space: nowrap; }
        .badge-banned  { background: #fff0f0; color: #e53e3e; border-radius: 20px; padding: 3px 10px; font-size: .75rem; font-weight: 700; white-space: nowrap; }
        .badge-admin   { background: #fff3e0; color: #e67e22; border-radius: 20px; padding: 3px 10px; font-size: .75rem; font-weight: 700; white-space: nowrap; }
        .badge-member  { background: #e3f0ff; color: #1a6fcf; border-radius: 20px; padding: 3px 10px; font-size: .75rem; font-weight: 700; white-space: nowrap; }

        /* ── Buttons ─────────────────────────────────────────── */
        .btn-srt-primary {
            background: var(--accent); color: #fff; border: none;
            border-radius: 6px; padding: 7px 16px; font-size: .82rem;
            font-weight: 700; cursor: pointer; transition: background .2s;
            display: inline-flex; align-items: center; gap: 4px;
        }
        .btn-srt-primary:hover { background: var(--accent-hover); color: #fff; }
        .btn-srt-danger {
            background: #e53e3e; color: #fff; border: none;
            border-radius: 6px; padding: 7px 16px; font-size: .82rem;
            font-weight: 700; cursor: pointer;
            display: inline-flex; align-items: center; gap: 4px;
        }
        .btn-srt-danger:hover { background: #c53030; }
        .btn-srt-sm { padding: 4px 10px !important; font-size: .78rem !important; border-radius: 5px !important; }

        /* ── Pagination ──────────────────────────────────────── */
        .srt-pagination { display: flex; gap: 6px; flex-wrap: wrap; }
        .srt-pagination a,
        .srt-pagination span {
            padding: 6px 12px; border-radius: 6px; font-size: .82rem;
            font-weight: 700; text-decoration: none;
            border: 1px solid #e2e8f0; color: #555; transition: all .2s;
            display: inline-block;
        }
        .srt-pagination a:hover { background: var(--accent); color: #fff; border-color: var(--accent); }
        .srt-pagination span.active { background: var(--accent); color: #fff; border-color: var(--accent); }
        .srt-pagination span.disabled { color: #bbb; pointer-events: none; }

        /* ── Alerts ──────────────────────────────────────────── */
        .srt-alert { padding: 10px 16px; border-radius: 8px; font-size: .85rem; font-weight: 600; margin-bottom: 16px; }
        .srt-alert-success { background: #e6f9f0; color: #1a9c5b; border: 1px solid #b2eed4; }
        .srt-alert-danger  { background: #fff0f0; color: #e53e3e; border: 1px solid #fbb; }

        /* ── Responsive ──────────────────────────────────────── */
        @media (max-width: 768px) {
            .srt-sidebar { transform: translateX(-100%); }
            .srt-sidebar.open { transform: translateX(0); }
            .srt-topbar { left: 0; }
            .srt-main { margin-left: 0; }
        }
    </style>
</head>
<body>

<?php
$currentUrl    = trim($_GET['url'] ?? '', '/');
$adminUsername = $_SESSION['user']['username'] ?? 'Admin';
$adminAvatar   = $_SESSION['user']['avatar']   ?? '';
$bp            = BASE_PATH;

function srtActive(string $path): string {
    global $currentUrl;
    return strpos($currentUrl, $path) === 0 ? 'active' : '';
}
?>

<!-- ── Sidebar ────────────────────────────────────────────── -->
<aside class="srt-sidebar" id="srtSidebar">
    <a class="brand" href="<?= $bp ?>/admin/contacts">
        <?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?><span>.</span>
    </a>
    <nav class="srt-nav">
        <div class="srt-nav-label">Nội dung</div>
        <a href="<?= $bp ?>/admin/dashboard" class="<?= srtActive('admin/dashboard') ?>">
            <i class="fa-solid fa-gauge"></i> Dashboard
        </a>
        <a href="<?= $bp ?>/admin/sliders" class="<?= srtActive('admin/sliders') ?>">
            <i class="fa-solid fa-images"></i> Sliders
        </a>
        <a href="<?= $bp ?>/admin/products" class="<?= srtActive('admin/products') ?>">
            <i class="fa-solid fa-box"></i> Sản phẩm
        </a>
        <a href="<?= $bp ?>/admin/posts" class="<?= srtActive('admin/posts') ?>">
            <i class="fa-solid fa-newspaper"></i> Tin tức
        </a>
        <a href="<?= $bp ?>/admin/categories" class="<?= srtActive('admin/categories') ?>">
            <i class="fa-solid fa-list"></i> Danh mục
        </a>
        <a href="<?= $bp ?>/admin/services" class="<?= srtActive('admin/services') ?>">
            <i class="fa-solid fa-grid-2"></i> Dịch vụ
        </a>
        <a href="<?= $bp ?>/admin/faqs" class="<?= srtActive('admin/faqs') ?>">
            <i class="fa-solid fa-circle-question"></i> FAQ
        </a>

        <div class="srt-nav-label">Đơn hàng & Khách</div>
        <a href="<?= $bp ?>/admin/orders" class="<?= srtActive('admin/orders') ?>">
            <i class="fa-solid fa-receipt"></i> Đơn hàng
        </a>
        <a href="<?= $bp ?>/admin/contacts" class="<?= srtActive('admin/contacts') ?>">
            <i class="fa-solid fa-envelope"></i> Liên hệ
        </a>
        <a href="<?= $bp ?>/admin/users" class="<?= srtActive('admin/users') ?>">
            <i class="fa-solid fa-users"></i> Người dùng
        </a>

        <div class="srt-nav-label">Hệ thống</div>
        <a href="<?= $bp ?>/admin/settings" class="<?= srtActive('admin/settings') ?>">
            <i class="fa-solid fa-gear"></i> Cài đặt
        </a>
        <a href="<?= $bp ?>/profile">
            <i class="fa-solid fa-user-pen"></i> Hồ sơ
        </a>
        <a href="<?= $bp ?>/">
            <i class="fa-solid fa-globe"></i> Xem website
        </a>
        <a href="<?= $bp ?>/logout">
            <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
        </a>
    </nav>
</aside>

<!-- ── Topbar ─────────────────────────────────────────────── -->
<header class="srt-topbar">
    <div style="display:flex;align-items:center;gap:12px;">
        <button class="srt-sidebar-toggle"
                onclick="document.getElementById('srtSidebar').classList.toggle('open')"
                aria-label="Toggle sidebar">
            <i class="fa-solid fa-bars"></i>
        </button>
        <span style="font-size:.85rem;color:#aaa;font-weight:600;">Admin Panel</span>
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
