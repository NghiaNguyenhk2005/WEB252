<?php require_once 'views/client/components/header.php'; ?>

<section class="py-5 bg-light">
    <div class="container py-5">
        <h2 class="fw-bold mb-5">Thanh toán</h2>
        
        <form action="index.php?url=checkout/process" method="POST">
            <div class="row g-5">
                <!-- Shipping Info -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                        <h4 class="fw-bold mb-4">Thông tin giao hàng</h4>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">Họ và tên người nhận</label>
                                <input type="text" name="full_name" class="form-control rounded-pill px-3" value="<?= htmlspecialchars($_SESSION['user']['username']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Số điện thoại</label>
                                <input type="tel" name="phone" class="form-control rounded-pill px-3" placeholder="0xxx xxx xxx" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control rounded-pill px-3 bg-light" value="<?= htmlspecialchars($_SESSION['user']['email']) ?>" readonly>
                            </div>
                            <div class="col-12 mt-3">
                                <label class="form-label fw-bold">Địa chỉ nhận hàng</label>
                                <input type="text" name="address" class="form-control rounded-pill px-3" placeholder="Số nhà, tên đường, phường/xã..." required>
                            </div>
                            <div class="col-12 mt-3">
                                <label class="form-label fw-bold">Ghi chú (Tùy chọn)</label>
                                <textarea name="notes" class="form-control rounded-4 px-3" rows="3" placeholder="Yêu cầu đặc biệt về giao hàng..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 p-4 mt-4">
                        <h4 class="fw-bold mb-4">Phương thức thanh toán</h4>
                        <div class="form-check p-3 border rounded-3 mb-3 bg-white">
                            <input class="form-check-input ms-0 me-3" type="radio" name="payment" id="cod" checked>
                            <label class="form-check-label d-flex align-items-center" for="cod">
                                <i class="bi bi-cash-stack fs-4 me-3 text-success"></i>
                                <div>
                                    <p class="mb-0 fw-bold">Thanh toán khi nhận hàng (COD)</p>
                                    <small class="text-muted">Thanh toán bằng tiền mặt khi shipper giao hàng</small>
                                </div>
                            </label>
                        </div>
                        <div class="form-check p-3 border rounded-3 bg-light opacity-50">
                            <input class="form-check-input ms-0 me-3" type="radio" name="payment" disabled>
                            <label class="form-check-label d-flex align-items-center">
                                <i class="bi bi-credit-card fs-4 me-3 text-primary"></i>
                                <div>
                                    <p class="mb-0 fw-bold">Chuyển khoản / Ví điện tử</p>
                                    <small class="text-muted">Đang bảo trì...</small>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top sticky-top-mobile-off">
                        <h4 class="fw-bold mb-4">Đơn hàng của bạn</h4>
                        <div class="order-items mb-4">
                            <?php foreach($items as $item): ?>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="position-relative">
                                            <img src="<?= $item['image'] ?? 'assets/client/img/dashboard.jpg' ?>" width="50" height="50" class="rounded-3 border" style="object-fit: cover;">
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary" style="font-size: 0.6rem;"><?= $item['quantity'] ?></span>
                                        </div>
                                        <div class="ms-3">
                                            <p class="mb-0 small fw-bold text-truncate" style="max-width: 150px;"><?= htmlspecialchars($item['name']) ?></p>
                                        </div>
                                    </div>
                                    <span class="small fw-medium"><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ</span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-2 mt-4">
                            <span class="text-muted">Tạm tính</span>
                            <span class="fw-medium"><?= number_format($total, 0, ',', '.') ?>đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted">Phí vận chuyển</span>
                            <span class="text-success fw-medium">Miễn phí</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-5">
                            <span class="fw-bold fs-4">Tổng cộng</span>
                            <span class="fw-bold fs-4 text-primary"><?= number_format($total, 0, ',', '.') ?>đ</span>
                        </div>

                        <button type="submit" class="btn btn-gradient btn-lg w-100 rounded-pill py-3 shadow">Đặt hàng ngay</button>
                        <p class="text-center small text-muted mt-3 mb-0"><i class="bi bi-shield-check me-2"></i>Thông tin đặt hàng của bạn được bảo mật tuyệt đối</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<?php require_once 'views/client/components/footer.php'; ?>