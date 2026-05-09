<!doctype html>
<html class="no-js" lang="en">
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

<body>
    <div id="preloader">
        <div class="loader"></div>
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