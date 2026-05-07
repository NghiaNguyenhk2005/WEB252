<?php 
// 1. Include layout parts
require_once "views/admin/partials/header.php"; 
require_once "views/admin/partials/sidebar.php"; 
?>

<!-- 2. Main Content Area (Srtdash Structure)[cite: 10] -->
<div class="main-content">
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Cấu hình</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="/admin">Dashboard</a></li>
                        <li><span>Cài đặt hệ thống</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <div class="main-content-inner">
        <!-- The form we built previously goes here[cite: 10] -->
        <div class="row">
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Thông tin doanh nghiệp</h4>
                        <form action="/admin/settings/update" method="POST" enctype="multipart/form-data">
                            <!-- Form fields for site_name, site_logo, company_phone, etc.[cite: 10] -->
                            <div class="form-group">
                                <label for="site_name">Tên Website</label>
                                <input class="form-control" type="text" name="site_name" 
                                       value="<?= htmlspecialchars($globalSettings['site_name'] ?? '') ?>">
                            </div>
                            <!-- ... other fields ... -->
                            <button type="submit" class="btn btn-primary mt-4">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
// 3. Include footer scripts
require_once "views/admin/partials/footer.php"; 
?>
