<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="/admin/dashboard"><h4 class="text-white">TechSaaS</h4></a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li>
                        <a href="/admin/dashboard"><i class="ti-dashboard"></i><span>dashboard</span></a>
                    </li>
                    <li class="<?= (strpos($_GET['url'], 'admin/settings') !== false) ? 'active' : '' ?>">
                        <a href="/admin/settings"><i class="ti-settings"></i><span>Cấu hình hệ thống</span></a>
                    </li>
                    <li class="<?= (strpos($_GET['url'], 'admin/contacts') !== false) ? 'active' : '' ?>">
                        <a href="/admin/contacts"><i class="ti-email"></i><span>Quản lý liên hệ</span></a>
                    </li>
                    <li>
                        <a href="/admin/services"><i class="ti-layout-grid2"></i><span>Quản lý dịch vụ</span></a>
                    </li>
                    <li>
                        <a href="/admin/sliders"><i class="ti-image"></i><span>Quản lý Sliders</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>