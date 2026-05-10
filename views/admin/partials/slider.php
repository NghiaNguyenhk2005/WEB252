<?php $currentUrl = trim($_GET['url'] ?? ''); ?>
<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="<?= BASE_PATH ?>/admin/dashboard">
                <h4 class="text-white"><?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?></h4>
            </a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li>
                        <a href="<?= BASE_PATH ?>/"><i class="ti-home"></i><span>Xem Website</span></a>
                    </li>
                    <li class="<?= strpos($currentUrl, 'admin/dashboard')  !== false ? 'active' : '' ?>">
                        <a href="<?= BASE_PATH ?>/admin/dashboard"><i class="ti-dashboard"></i><span>Bảng điều khiển</span></a>
                    </li>
                    <li class="<?= strpos($currentUrl, 'admin/sliders')    !== false ? 'active' : '' ?>">
                        <a href="<?= BASE_PATH ?>/admin/sliders"><i class="ti-image"></i><span>Quản lý Sliders</span></a>
                    </li>
                    <li class="<?= strpos($currentUrl, 'admin/products')   !== false ? 'active' : '' ?>">
                        <a href="<?= BASE_PATH ?>/admin/products"><i class="ti-package"></i><span>Quản lý Sản phẩm</span></a>
                    </li>
                    <li class="<?= strpos($currentUrl, 'admin/posts')      !== false ? 'active' : '' ?>">
                        <a href="<?= BASE_PATH ?>/admin/posts"><i class="ti-write"></i><span>Quản lý Tin tức</span></a>
                    </li>
                    <li class="<?= strpos($currentUrl, 'admin/orders')     !== false ? 'active' : '' ?>">
                        <a href="<?= BASE_PATH ?>/admin/orders"><i class="ti-receipt"></i><span>Quản lý Đơn hàng</span></a>
                    </li>
                    <li class="<?= strpos($currentUrl, 'admin/categories') !== false ? 'active' : '' ?>">
                        <a href="<?= BASE_PATH ?>/admin/categories"><i class="ti-list"></i><span>Quản lý Danh mục</span></a>
                    </li>
                    <li class="<?= strpos($currentUrl, 'admin/services')   !== false ? 'active' : '' ?>">
                        <a href="<?= BASE_PATH ?>/admin/services"><i class="ti-layout-grid2"></i><span>Quản lý Dịch vụ</span></a>
                    </li>
                    <li class="<?= strpos($currentUrl, 'admin/faqs')       !== false ? 'active' : '' ?>">
                        <a href="<?= BASE_PATH ?>/admin/faqs"><i class="ti-help-alt"></i><span>Quản lý FAQ</span></a>
                    </li>
                    <li class="<?= strpos($currentUrl, 'admin/contacts')   !== false ? 'active' : '' ?>">
                        <a href="<?= BASE_PATH ?>/admin/contacts"><i class="ti-email"></i><span>Quản lý Liên hệ</span></a>
                    </li>
                    <li class="<?= strpos($currentUrl, 'admin/settings')   !== false ? 'active' : '' ?>">
                        <a href="<?= BASE_PATH ?>/admin/settings"><i class="ti-settings"></i><span>Cấu hình hệ thống</span></a>
                    </li>
                    <li class="<?= strpos($currentUrl, 'admin/users')      !== false ? 'active' : '' ?>">
                        <a href="<?= BASE_PATH ?>/admin/users"><i class="ti-user"></i><span>Quản lý Người dùng</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
