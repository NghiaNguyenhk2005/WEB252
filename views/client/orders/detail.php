<?php include __DIR__ . '/../components/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= BASE_PATH ?>/">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="<?= BASE_PATH ?>/orders">Đơn hàng của tôi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chi tiết đơn hàng #<?= $order['id'] ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Order Items -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="fw-bold mb-0">
                        <i class="fa-solid fa-box me-2 text-primary"></i>
                        Sản phẩm trong đơn hàng
                    </h5>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($orderItems) && $orderItems->num_rows > 0): ?>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th class="text-center">Số lượng</th>
                                        <th class="text-end">Đơn giá</th>
                                        <th class="text-end">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $subtotal = 0;
                                    while ($item = $orderItems->fetch_assoc()): 
                                        $itemTotal = $item['price'] * $item['quantity'];
                                        $subtotal += $itemTotal;
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <?php if (!empty($item['image'])): ?>
                                                    <img src="<?= BASE_PATH ?>/<?= htmlspecialchars($item['image']) ?>" 
                                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;" 
                                                         alt="<?= htmlspecialchars($item['name']) ?>">
                                                <?php else: ?>
                                                    <div style="width: 60px; height: 60px; background: #f0f0f0; border-radius: 8px;" 
                                                         class="d-flex align-items-center justify-content-center">
                                                        <i class="fa-solid fa-box text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <h6 class="mb-1 fw-semibold"><?= htmlspecialchars($item['name']) ?></h6>
                                                    <small class="text-muted">Mã SP: #<?= $item['product_id'] ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark px-3 py-2"><?= number_format($item['quantity']) ?></span>
                                        </td>
                                        <td class="text-end text-muted">
                                            <?= number_format($item['price'], 0, ',', '.') ?>đ
                                        </td>
                                        <td class="text-end fw-bold text-primary">
                                            <?= number_format($itemTotal, 0, ',', '.') ?>đ
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr class="border-top">
                                        <td colspan="3" class="text-end fw-semibold py-3">Tạm tính:</td>
                                        <td class="text-end fw-semibold py-3"><?= number_format($subtotal, 0, ',', '.') ?>đ</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end fw-semibold text-muted">Phí vận chuyển:</td>
                                        <td class="text-end text-muted">0đ</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td colspan="3" class="text-end fw-bold fs-5 py-3">Tổng thanh toán:</td>
                                        <td class="text-end fw-bold fs-5 text-primary py-3">
                                            <?= number_format($order['total_price'] ?? $subtotal, 0, ',', '.') ?>đ
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fa-solid fa-box-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Không tìm thấy sản phẩm trong đơn hàng</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Order Info Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="fw-bold mb-0">
                        <i class="fa-solid fa-circle-info me-2 text-primary"></i>
                        Thông tin đơn hàng
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase mb-1">Mã đơn hàng</label>
                        <p class="fw-bold fs-5 mb-0 text-primary">#<?= $order['id'] ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase mb-1">Ngày đặt hàng</label>
                        <p class="mb-0"><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase mb-1">Trạng thái đơn hàng</label>
                        <div>
                            <?php
                            $statusConfig = [
                                'pending'   => ['label' => 'Chờ xử lý',    'color' => '#d97706', 'class' => 'bg-warning'],
                                'paid'      => ['label' => 'Đã thanh toán', 'color' => '#2563eb', 'class' => 'bg-primary'],
                                'shipping'  => ['label' => 'Đang giao',     'color' => '#0891b2', 'class' => 'bg-info'],
                                'completed' => ['label' => 'Hoàn thành',    'color' => '#16a34a', 'class' => 'bg-success'],
                                'cancelled' => ['label' => 'Đã hủy',        'color' => '#dc2626', 'class' => 'bg-danger'],
                                'refunded'  => ['label' => 'Đã hoàn tiền',  'color' => '#6b7280', 'class' => 'bg-secondary'],
                            ];
                            $status = $statusConfig[$order['status']] ?? ['label' => ucfirst($order['status']), 'class' => 'bg-secondary'];
                            ?>
                            <span class="badge <?= $status['class'] ?> px-3 py-2" style="font-size: 0.8rem;">
                                <i class="fa-solid fa-circle me-1 small"></i> <?= $status['label'] ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Info Card -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="fw-bold mb-0">
                        <i class="fa-solid fa-truck me-2 text-primary"></i>
                        Thông tin nhận hàng
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase mb-1">Người nhận</label>
                        <p class="fw-semibold mb-0"><?= htmlspecialchars($order['full_name'] ?? 'Không có thông tin') ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase mb-1">Số điện thoại</label>
                        <p class="mb-0"><?= htmlspecialchars($order['phone'] ?? 'Không có thông tin') ?></p>
                    </div>
                    <div class="mb-0">
                        <label class="text-muted small text-uppercase mb-1">Địa chỉ giao hàng</label>
                        <p class="mb-0"><?= htmlspecialchars($order['address'] ?? 'Không có thông tin') ?></p>
                    </div>
                    <?php if (!empty($order['notes'])): ?>
                    <div class="mt-3 pt-2 border-top">
                        <label class="text-muted small text-uppercase mb-1">Ghi chú</label>
                        <p class="mb-0 small text-muted"><?= nl2br(htmlspecialchars($order['notes'])) ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Action Buttons -->
            <?php if ($order['status'] === 'pending'): ?>
            <div class="mt-4">
                <form method="POST" action="<?= BASE_PATH ?>/order/cancel" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')">
                    <?= csrf_field() ?>
                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                    <button type="submit" class="btn btn-outline-danger w-100 rounded-pill py-2">
                        <i class="fa-solid fa-ban me-2"></i>Hủy đơn hàng
                    </button>
                </form>
            </div>
            <?php endif; ?>

            <!-- Back to Orders Button -->
            <div class="mt-3">
                <a href="<?= BASE_PATH ?>/orders" class="btn btn-outline-secondary w-100 rounded-pill py-2">
                    <i class="fa-solid fa-arrow-left me-2"></i>Quay lại đơn hàng
                </a>
            </div>
        </div>
    </div>
</div>

<style>
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.85rem;
    }
    .table td, .table th {
        padding: 0.75rem;
    }
}
</style>

<?php include __DIR__ . '/../components/footer.php'; ?>