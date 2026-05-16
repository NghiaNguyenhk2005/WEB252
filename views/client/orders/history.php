<?php require_once 'views/client/components/header.php'; ?>
<?php
if (!isset($orders) || !is_object($orders) || !property_exists($orders, 'num_rows')) {
    $orders = new class {
        public $num_rows = 0;
        public function fetch_assoc() {
            return false;
        }
    };
}
?>

<section class="py-5 bg-light min-vh-100">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3">
                <!-- Sidebar Menu (Like Profile) -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <div class="text-center mb-4">
                        <img src="<?= $_SESSION['user']['avatar'] ?? 'assets/client/img/dashboard.jpg' ?>" class="rounded-circle border p-1" width="80" height="80" style="object-fit: cover;">
                        <h6 class="fw-bold mt-3 mb-0"><?= htmlspecialchars($_SESSION['user']['username']) ?></h6>
                        <small class="text-muted"><?= htmlspecialchars($_SESSION['user']['email']) ?></small>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="index.php?url=profile" class="list-group-item list-group-item-action border-0 px-0"><i class="bi bi-person me-2"></i>Hồ sơ cá nhân</a>
                        <a href="index.php?url=orders" class="list-group-item list-group-item-action border-0 px-0 text-primary fw-bold"><i class="bi bi-box-seam me-2"></i>Lịch sử đơn hàng</a>
                        <a href="index.php?url=logout" class="list-group-item list-group-item-action border-0 px-0 text-danger"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                    <h3 class="fw-bold mb-5">Đơn hàng của tôi</h3>
                    
                    <?php if (isset($orders) && is_object($orders) && $orders->num_rows > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr class="text-muted small text-uppercase">
                                        <th>Mã đơn</th>
                                        <th>Ngày đặt</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th class="text-end">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($order = $orders->fetch_assoc()): ?>
                                        <tr>
                                            <td class="fw-bold">#<?= $order['id'] ?></td>
                                            <td><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                                            <td class="fw-bold text-primary"><?= number_format($order['total_price'], 0, ',', '.') ?>đ</td>
                                            <td>
                                            <?php 
                                                $statusMap = [
                                                    'pending'   => ['class' => 'bg-warning', 'text' => 'Đang xử lý'],
                                                    'shipping'  => ['class' => 'bg-info',    'text' => 'Đang giao'],
                                                    'completed' => ['class' => 'bg-success', 'text' => 'Hoàn thành'],
                                                    'cancelled' => ['class' => 'bg-danger',  'text' => 'Đã hủy'],
                                                    'refunded'  => ['class' => 'bg-secondary', 'text' => 'Đã hoàn tiền'],
                                                ];
                                                $statusClass = $statusMap[$order['status']]['class'] ?? 'bg-warning';
                                                $statusText = $statusMap[$order['status']]['text'] ?? 'Đang xử lý';
                                            ?>
                                                <span class="badge <?= $statusClass ?> rounded-pill px-3"><?= $statusText ?></span>
                                            </td>
                                            <td class="text-end">
                                                <a href="index.php?url=order/detail&id=<?= $order['id'] ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Chi tiết</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <p class="text-muted">Bạn chưa có đơn hàng nào.</p>
                            <a href="index.php?url=products" class="btn btn-primary rounded-pill px-4 mt-2">Bắt đầu mua sắm</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'views/client/components/footer.php'; ?>