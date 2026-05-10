<?php require_once 'views/admin/partials/header.php'; ?>

<div class="main-content-inner p-4">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-center mb-5 pb-3 border-bottom">
                        <div>
                            <h4 class="fw-bold mb-1">Quản lý Đơn hàng</h4>
                            <p class="text-muted small mb-0">Theo dõi và cập nhật trạng thái đơn hàng của khách hàng.</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light-gray text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4">Mã đơn</th>
                                    <th>Khách hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Ngày đặt</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($orders) && is_object($orders) && $orders->num_rows > 0): ?>
                                    <?php while($order = $orders->fetch_assoc()): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold text-dark">#<?= $order['id'] ?></td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold"><?= htmlspecialchars($order['full_name'] ?? '') ?></span>
                                                    <span class="text-muted extra-small"><?= htmlspecialchars($order['phone'] ?? '') ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-primary"><?= number_format($order['total_price'] ?? 0, 0, ',', '.') ?>đ</span>
                                            </td>
                                            <td>
                                                <span class="text-muted small"><?= date('d/m/Y', strtotime($order['created_at'])) ?></span><br>
                                                <span class="extra-small text-muted"><?= date('H:i', strtotime($order['created_at'])) ?></span>
                                            </td>
                                            <td class="text-center">
                                                <form action="index.php?url=admin/orders/update" method="POST" id="form-status-<?= $order['id'] ?>">
                                                    <input type="hidden" name="id" value="<?= $order['id'] ?>">
                                                    <?php 
                                                        $s = $order['status'];
                                                        $badgeClass = 'bg-warning';
                                                        if($s == 'completed') $badgeClass = 'bg-success';
                                                        if($s == 'shipping') $badgeClass = 'bg-info';
                                                        if($s == 'cancelled') $badgeClass = 'bg-danger';
                                                    ?>
                                                    <select name="status" class="form-select form-select-sm rounded-pill border-0 px-3 py-1 shadow-sm <?= $badgeClass ?> text-white small cursor-pointer" onchange="this.form.submit()">
                                                        <option value="pending" <?= $s == 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                                                        <option value="shipping" <?= $s == 'shipping' ? 'selected' : '' ?>>Đang giao</option>
                                                        <option value="completed" <?= $s == 'completed' ? 'selected' : '' ?>>Hoàn thành</option>
                                                        <option value="cancelled" <?= $s == 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
                                                    </select>
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                <a href="index.php?url=order/detail&id=<?= $order['id'] ?>" target="_blank" class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-muted border shadow-xs">
                                                    <i class="ti-eye me-1"></i>Chi tiết
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="py-5 text-center text-muted">
                                            <i class="ti-receipt display-4 opacity-25 d-block mb-3"></i>
                                            Chưa có đơn hàng nào.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if (isset($totalPages) && $totalPages > 1): ?>
                        <nav class="mt-5">
                            <ul class="pagination justify-content-end">
                                <?php for($i=1; $i<=$totalPages; $i++): ?>
                                    <li class="page-item <?= (isset($page) && $i == $page) ? 'active' : '' ?>">
                                        <a class="page-link rounded-circle mx-1" href="index.php?url=admin/orders&page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/admin/partials/footer.php'; ?>