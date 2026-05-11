<?php 
$currentUrl = trim($_GET['url'] ?? ''); 

// Helper function to check if menu item is active
function isActive($currentUrl, $paths) {
    foreach ((array)$paths as $path) {
        if (strpos($currentUrl, $path) !== false) {
            return 'active';
        }
    }
    return '';
}
?>

<!-- Sidebar Toggle Button -->
<button class="sidebar-toggle" id="sidebarToggle">
    <i class="fa-solid fa-bars"></i>
</button>

<div class="sidebar-menu" id="sidebarMenu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="<?= BASE_PATH ?>/admin/dashboard">
                <h4><?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?></h4>
            </a>
        </div>
        <button class="sidebar-close" id="sidebarClose">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
    
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <!-- TỔNG QUAN -->
                    <li class="menu-title">TỔNG QUAN</li>
                    <li class="<?= isActive($currentUrl, ['admin/dashboard']) ?>">
                        <a href="<?= BASE_PATH ?>/admin/dashboard">
                            <i class="ti-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    <!-- NỘI DUNG -->
                    <li class="menu-title">NỘI DUNG</li>
                    <li class="<?= isActive($currentUrl, ['admin/products']) ?>">
                        <a href="<?= BASE_PATH ?>/admin/products">
                            <i class="ti-package"></i>
                            <span>Sản phẩm</span>
                        </a>
                    </li>
                    <li class="<?= isActive($currentUrl, ['admin/categories']) ?>">
                        <a href="<?= BASE_PATH ?>/admin/categories">
                            <i class="ti-list"></i>
                            <span>Danh mục</span>
                        </a>
                    </li>
                    <li class="<?= isActive($currentUrl, ['admin/posts']) ?>">
                        <a href="<?= BASE_PATH ?>/admin/posts">
                            <i class="ti-write"></i>
                            <span>Tin tức</span>
                        </a>
                    </li>
                    <li class="<?= isActive($currentUrl, ['admin/services']) ?>">
                        <a href="<?= BASE_PATH ?>/admin/services">
                            <i class="ti-layout-grid2"></i>
                            <span>Dịch vụ</span>
                        </a>
                    </li>
                    <li class="<?= isActive($currentUrl, ['admin/faqs']) ?>">
                        <a href="<?= BASE_PATH ?>/admin/faqs">
                            <i class="ti-help-alt"></i>
                            <span>FAQ</span>
                        </a>
                    </li>
                    
                    <!-- THƯƠNG MẠI -->
                    <li class="menu-title">THƯƠNG MẠI</li>
                    <li class="<?= isActive($currentUrl, ['admin/orders']) ?>">
                        <a href="<?= BASE_PATH ?>/admin/orders">
                            <i class="ti-receipt"></i>
                            <span>Đơn hàng</span>
                        </a>
                    </li>
                    
                    <!-- NGƯỜI DÙNG & HỖ TRỢ -->
                    <li class="menu-title">NGƯỜI DÙNG & HỖ TRỢ</li>
                    <li class="<?= isActive($currentUrl, ['admin/users']) ?>">
                        <a href="<?= BASE_PATH ?>/admin/users">
                            <i class="ti-user"></i>
                            <span>Người dùng</span>
                        </a>
                    </li>
                    <li class="<?= isActive($currentUrl, ['admin/contacts']) ?>">
                        <a href="<?= BASE_PATH ?>/admin/contacts">
                            <i class="ti-email"></i>
                            <span>Liên hệ</span>
                        </a>
                    </li>
                    
                    <!-- HỆ THỐNG -->
                    <li class="menu-title">HỆ THỐNG</li>
                    <li class="<?= isActive($currentUrl, ['admin/settings', 'admin/sliders']) ?>">
                        <a href="<?= BASE_PATH ?>/admin/settings">
                            <i class="ti-settings"></i>
                            <span>Cài đặt & Slider</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= BASE_PATH ?>/profile">
                            <i class="ti-user"></i>
                            <span>Hồ sơ</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= BASE_PATH ?>/" target="_blank">
                            <i class="ti-world"></i>
                            <span>Xem website</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= BASE_PATH ?>/logout">
                            <i class="ti-shift-left"></i>
                            <span>Đăng xuất</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<style>
/* Reset margins */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Sidebar Styles */
.sidebar-menu {
    position: fixed;
    top: 0;
    left: 0;
    width: 280px;
    height: 100vh;
    background: #1a1a2e;
    color: #fff;
    z-index: 1000;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow-y: auto;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
}

/* Sidebar Closed State - using transform instead of left for better performance */
.sidebar-menu.closed {
    transform: translateX(-100%);
}

/* Sidebar Toggle Button */
.sidebar-toggle {
    position: fixed;
    top: 15px;
    left: 15px;
    z-index: 1001;
    background: var(--accent, #4361ee);
    border: none;
    color: white;
    width: 45px;
    height: 45px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.sidebar-toggle:hover {
    background: #3a0ca3;
    transform: scale(1.05);
}

/* Sidebar Close Button (mobile) */
.sidebar-close {
    display: none;
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: white;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
}

.sidebar-close:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: rotate(90deg);
}

/* Sidebar Header */
.sidebar-header {
    padding: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 20px;
    position: relative;
}

.sidebar-header .logo h4 {
    margin: 0;
    font-size: 1.3rem;
    color: white;
}

/* Menu Title */
.menu-title {
    padding: 10px 20px;
    font-size: 0.7rem;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.4);
    letter-spacing: 1px;
    font-weight: 600;
}

/* Menu Items */
.metismenu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.metismenu li {
    position: relative;
}

.metismenu li a {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.metismenu li a i {
    width: 30px;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

/* Hover Animation */
.metismenu li a:hover {
    background: rgba(255, 255, 255, 0.08);
    color: white;
    padding-left: 25px;
}

.metismenu li a:hover i {
    transform: translateX(3px);
}

/* Active State */
.metismenu li.active > a {
    background: linear-gradient(90deg, var(--accent, #4361ee) 0%, rgba(67, 97, 238, 0.7) 100%);
    color: white;
    border-left: 3px solid white;
}

.metismenu li.active > a i {
    transform: scale(1.1);
    color: white;
}

/* Main Content Adjustment - FIXED */
.main-content {
    margin-left: 280px;
    transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 20px;
    min-height: 100vh;
}

.main-content.expanded {
    margin-left: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .sidebar-menu {
        transform: translateX(-100%);
    }
    
    .sidebar-menu.open {
        transform: translateX(0);
    }
    
    .sidebar-toggle {
        display: flex;
    }
    
    .sidebar-close {
        display: flex;
    }
    
    .main-content {
        margin-left: 0;
    }
}

@media (min-width: 769px) {
    .sidebar-toggle {
        display: none;
    }
    
    .sidebar-close {
        display: none;
    }
}

/* Scrollbar Styling */
.sidebar-menu::-webkit-scrollbar {
    width: 5px;
}

.sidebar-menu::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

.sidebar-menu::-webkit-scrollbar-thumb {
    background: var(--accent, #4361ee);
    border-radius: 5px;
}

.sidebar-menu::-webkit-scrollbar-thumb:hover {
    background: #3a0ca3;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebarMenu');
    const toggleBtn = document.getElementById('sidebarToggle');
    const closeBtn = document.getElementById('sidebarClose');
    const mainContent = document.querySelector('.main-content');
    
    // Check saved state in localStorage (desktop only)
    const isSidebarClosed = localStorage.getItem('sidebarClosed') === 'true';
    
    if (isSidebarClosed && window.innerWidth > 768) {
        sidebar.classList.add('closed');
        if (mainContent) mainContent.classList.add('expanded');
    }
    
    // Toggle sidebar on desktop
    if (toggleBtn && window.innerWidth > 768) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('closed');
            if (mainContent) mainContent.classList.toggle('expanded');
            // Save state
            localStorage.setItem('sidebarClosed', sidebar.classList.contains('closed'));
        });
    }
    
    // Mobile: Open sidebar when toggle clicked
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('open');
            }
        });
    }
    
    // Close sidebar on mobile when X clicked
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            sidebar.classList.remove('open');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768) {
            if (sidebar && toggleBtn) {
                if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                    sidebar.classList.remove('open');
                }
            }
        }
    });
    
    // Add active class based on current URL
    const currentPath = window.location.pathname;
    const menuLinks = document.querySelectorAll('.metismenu li a');
    
    menuLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href && href !== '#' && currentPath.includes(href)) {
            link.closest('li').classList.add('active');
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('open');
            const isClosed = localStorage.getItem('sidebarClosed') === 'true';
            if (isClosed) {
                sidebar.classList.add('closed');
                if (mainContent) mainContent.classList.add('expanded');
            } else {
                sidebar.classList.remove('closed');
                if (mainContent) mainContent.classList.remove('expanded');
            }
        } else {
            sidebar.classList.remove('closed');
            if (mainContent) mainContent.classList.remove('expanded');
        }
    });
});
</script>