<?php $url = $_GET['url'] ?? ''; ?>
<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="index.php?url=admin/dashboard"><h4 class="text-white">TechSaaS</h4></a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li>
                        <a href="index.php"><i class="ti-home"></i><span>Xem Website</span></a>
                    </li>
                    <li class="<?= (strpos($url, 'admin/dashboard') !== false) ? 'active' : '' ?>">
                        <a href="index.php?url=admin/dashboard"><i class="ti-dashboard"></i><span>Bảng điều khiển</span></a>
                    </li>
                    <li class="<?= (strpos($url, 'admin/sliders') !== false) ? 'active' : '' ?>">
                        <a href="index.php?url=admin/sliders"><i class="ti-image"></i><span>Quản lý Sliders</span></a>
                    </li>
                    <li class="<?= (strpos($url, 'admin/products') !== false) ? 'active' : '' ?>">
                        <a href="index.php?url=admin/products"><i class="ti-package"></i><span>Quản lý Sản phẩm</span></a>
                    </li>
                    <li class="<?= (strpos($url, 'admin/posts') !== false) ? 'active' : '' ?>">
                        <a href="index.php?url=admin/posts"><i class="ti-write"></i><span>Quản lý Tin tức</span></a>
                    </li>
                    <li class="<?= (strpos($url, 'admin/orders') !== false) ? 'active' : '' ?>">
                        <a href="index.php?url=admin/orders"><i class="ti-receipt"></i><span>Quản lý Đơn hàng</span></a>
                    </li>
                    <li class="<?= (strpos($url, 'admin/categories') !== false) ? 'active' : '' ?>">
                        <a href="index.php?url=admin/categories"><i class="ti-list"></i><span>Quản lý Danh mục</span></a>
                    </li>
                    <li class="<?= (strpos($url, 'admin/services') !== false) ? 'active' : '' ?>">
                        <a href="index.php?url=admin/services"><i class="ti-layout-grid2"></i><span>Quản lý Dịch vụ</span></a>
                    </li>
                    <li class="<?= (strpos($url, 'admin/faqs') !== false) ? 'active' : '' ?>">
                        <a href="index.php?url=admin/faqs"><i class="ti-help-alt"></i><span>Quản lý FAQ</span></a>
                    </li>
                    <li class="<?= (strpos($url, 'admin/settings') !== false) ? 'active' : '' ?>">
                        <a href="index.php?url=admin/settings"><i class="ti-settings"></i><span>Cấu hình hệ thống</span></a>
                    </li>
                    <li class="<?= (strpos($url, 'admin/contacts') !== false) ? 'active' : '' ?>">
                        <a href="index.php?url=admin/contacts"><i class="ti-email"></i><span>Quản lý liên hệ</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>