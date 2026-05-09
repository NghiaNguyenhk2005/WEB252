<?php require_once 'views/client/components/header.php'; ?>

<section class="py-5 bg-light min-vh-100">
    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?url=orders" class="text-decoration-none">Đơn hàng của tôi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết đơn hàng #<?= $order['id'] ?></li>
            </ol>
        </nav>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h5 class="fw-bold mb-4">Sản phẩm trong đơn hàng</h5>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <tbody>
                                <?php if (isset($items) && is_object($items)): ?>
                                    <?php while($item = $items->fetch_assoc()): ?>
                                    <tr class="border-bottom">
                                        <td style="width: 80px;">
                                            <img src="<?= $item['image'] ?? 'assets/client/img/dashboard.jpg' ?>" width="60" height="60" class="rounded-3 border" style="object-fit: cover;">
                                        </td>
                                        <td>
                                            <h6 class="fw-bold mb-0"><?= htmlspecialchars($item['name']) ?></h6>
                                            <small class="text-muted">Đơn giá: <?= number_format($item['price'], 0, ',', '.') ?>đ</small>
                                        </td>
                                        <td class="text-center text-muted">x<?= $item['quantity'] ?></td>
                                        <td class="text-end fw-bold text-primary"><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ</td>
                                    </tr>
                                <?php endwhile; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between mt-4 px-2">
                        <span class="fw-bold fs-5">Tổng tiền thanh toán</span>
                        <span class="fw-bold fs-5 text-primary"><?= number_format($order['total_price'], 0, ',', '.') ?>đ</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h5 class="fw-bold mb-4">Thông tin nhận hàng</h5>
                    <div class="mb-3">
                        <p class="mb-1 text-muted small">Người nhận</p>
                        <p class="mb-0 fw-bold"><?= isset($order['full_name']) ? htmlspecialchars($order['full_name']) : '' ?></p>
                    </div>
                    <div class="mb-3">
                        <p class="mb-1 text-muted small">Số điện thoại</p>
                        <p class="mb-0 fw-bold"><?= isset($order['phone']) ? htmlspecialchars($order['phone']) : '' ?></p>
                    </div>
                    <div class="mb-3">
                        <p class="mb-1 text-muted small">Địa chỉ</p>
                        <p class="mb-0 fw-bold"><?= htmlspecialchars($order['address']) ?></p>
                    </div>
                    <div class="mb-0">
                        <p class="mb-1 text-muted small">Trạng thái đơn hàng</p>
                        <?php 
                            $statusClass = 'bg-warning';
                            $statusText = 'Đang xử lý';
                            if($order['status'] === 'shipping') { $statusClass = 'bg-info'; $statusText = 'Đang giao'; }
                            if($order['status'] === 'completed') { $statusClass = 'bg-success'; $statusText = 'Hoàn thành'; }
                            if($order['status'] === 'cancelled') { $statusClass = 'bg-danger'; $statusText = 'Đã hủy'; }
                        ?>
                        <span class="badge <?= $statusClass ?> rounded-pill px-3"><?= $statusText ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'views/client/components/footer.php'; ?>