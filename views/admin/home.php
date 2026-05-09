<?php require_once 'views/admin/partials/header.php'; ?>

<div class="main-content-inner p-4">
    <!-- 1. WELCOME SECTION -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 bg-gradient-primary text-white p-4 overflow-hidden position-relative">
                <div class="row align-items-center">
                    <div class="col-md-8 position-relative z-1">
                        <h2 class="fw-bold mb-2">Chào mừng trở lại, <?= htmlspecialchars($_SESSION['user']['username'] ?? 'Admin') ?>!</h2>
                        <p class="opacity-75 mb-0">Hệ thống đang hoạt động ổn định. Bạn có <span class="fw-bold"><?= $stats['orders'] ?? 0 ?></span> đơn hàng cần xử lý hôm nay.</p>
                    </div>
                    <div class="col-md-4 text-right d-none d-md-block position-relative z-1">
                        <i class="ti-stats-up display-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. STATS CARDS -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-left-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Doanh thu (Tháng)</div>
                            <?php 
                                $revenueQuery = $this->conn->query("SELECT SUM(total_price) FROM orders WHERE status='completed'");
                                $revenue = ($revenueQuery && $row = $revenueQuery->fetch_row()) ? ($row[0] ?? 0) : 0;
                            ?>
                            <h3 class="fw-bold mb-0 text-dark"><?= number_format($revenue, 0, ',', '.') ?>đ</h3>
                        </div>
                        <div class="icon-circle bg-primary-light">
                            <i class="ti-money text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-left-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sản phẩm hiện có</div>
                            <h3 class="fw-bold mb-0 text-dark"><?= $stats['products'] ?? 0 ?></h3>
                        </div>
                        <div class="icon-circle bg-success-light">
                            <i class="ti-package text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-left-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Đơn hàng mới</div>
                            <?php 
                                $pendingOrdersQuery = $this->conn->query("SELECT COUNT(*) FROM orders WHERE status='pending'");
                                $pendingOrders = ($pendingOrdersQuery && $row = $pendingOrdersQuery->fetch_row()) ? $row[0] : 0;
                            ?>
                            <h3 class="fw-bold mb-0 text-dark"><?= $pendingOrders ?></h3>
                        </div>
                        <div class="icon-circle bg-info-light">
                            <i class="ti-receipt text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-left-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Thành viên</div>
                            <h3 class="fw-bold mb-0 text-dark"><?= $stats['users'] ?? 0 ?></h3>
                        </div>
                        <div class="icon-circle bg-warning-light">
                            <i class="ti-user text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. ALERTS & RECENT ACTIVITY -->
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="m-0 font-weight-bold text-dark"><i class="ti-bell me-2 text-primary"></i>Thông báo hệ thống</h6>
                </div>
                <div class="card-body">
                    <?php if (isset($stats['pending_faqs']) && $stats['pending_faqs'] > 0): ?>
                        <div class="alert alert-warning border-0 rounded-3 small mb-3">
                            Bạn có <b><?= $stats['pending_faqs'] ?></b> câu hỏi FAQ đang chờ trả lời. 
                            <a href="index.php?url=admin/faqs" class="alert-link">Xử lý ngay</a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($stats['new_contacts']) && $stats['new_contacts'] > 0): ?>
                        <div class="alert alert-info border-0 rounded-3 small mb-3">
                            <b><?= $stats['new_contacts'] ?></b> liên hệ mới từ khách hàng chưa đọc.
                            <a href="index.php?url=admin/contacts" class="alert-link">Xem hộp thư</a>
                        </div>
                    <?php endif; ?>

                    <?php if ((!isset($stats['pending_faqs']) || $stats['pending_faqs'] == 0) && (!isset($stats['new_contacts']) || $stats['new_contacts'] == 0)): ?>
                        <div class="text-center py-4">
                            <i class="ti-check-box display-4 text-muted opacity-25"></i>
                            <p class="text-muted mt-2">Không có việc cần xử lý gấp.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-dark"><i class="ti-shopping-cart me-2 text-success"></i>Đơn hàng mới nhất</h6>
                    <a href="index.php?url=admin/orders" class="small text-primary text-decoration-none">Tất cả đơn hàng &rarr;</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="text-muted small text-uppercase">
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Khách hàng</th>
                                    <th>Số tiền</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($recentOrders) && is_object($recentOrders) && $recentOrders->num_rows > 0): ?>
                                    <?php while($order = $recentOrders->fetch_assoc()): ?>
                                    <tr>
                                        <td class="fw-bold">#<?= $order['id'] ?></td>
                                        <td><?= htmlspecialchars($order['username']) ?></td>
                                        <td class="text-primary fw-bold"><?= number_format($order['total_price'], 0, ',', '.') ?>đ</td>
                                        <td>
                                            <?php 
                                                $s = $order['status'];
                                                $badge = 'secondary';
                                                if($s == 'pending') $badge = 'warning';
                                                if($s == 'completed') $badge = 'success';
                                                if($s == 'shipping') $badge = 'info';
                                                if($s == 'cancelled') $badge = 'danger';
                                            ?>
                                            <span class="badge bg-<?= $badge ?> rounded-pill px-3"><?= ucfirst($s) ?></span>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center py-4 text-muted">Chưa có đơn hàng mới</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/admin/partials/footer.php'; ?>