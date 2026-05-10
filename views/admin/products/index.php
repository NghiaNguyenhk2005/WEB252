<?php require_once 'views/admin/partials/header.php'; ?>

<div class="main-content-inner p-4">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-center mb-5 pb-3 border-bottom">
                        <div>
                            <h4 class="fw-bold mb-1">Danh sách Sản phẩm</h4>
                            <p class="text-muted small mb-0">Quản lý kho hàng và thông tin sản phẩm của bạn.</p>
                        </div>
                        <a href="index.php?url=admin/products/create" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="ti-plus me-2"></i>Thêm sản phẩm mới
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light-gray text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4">Sản phẩm</th>
                                    <th>Giá bán</th>
                                    <th class="text-center">Tồn kho</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($products) && is_object($products) && $products->num_rows > 0): ?>
                                    <?php while($product = $products->fetch_assoc()): ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <img src="<?= $product['image'] ?? 'assets/client/img/dashboard.jpg' ?>" width="55" height="55" class="rounded-3 shadow-sm me-3" style="object-fit: cover;">
                                                    <div>
                                                        <h6 class="fw-bold mb-0 text-dark"><?= htmlspecialchars($product['name'] ?? '') ?></h6>
                                                        <span class="text-muted extra-small">ID: #<?= $product['id'] ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-primary"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</span>
                                            </td>
                                            <td class="text-center">
                                                <?php if($product['stock'] > 10): ?>
                                                    <span class="badge bg-success-light text-success rounded-pill px-3">Còn hàng (<?= $product['stock'] ?>)</span>
                                                <?php elseif($product['stock'] > 0): ?>
                                                    <span class="badge bg-warning-light text-warning rounded-pill px-3">Sắp hết (<?= $product['stock'] ?>)</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger-light text-danger rounded-pill px-3">Hết hàng</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <button class="btn btn-light btn-sm rounded-circle" type="button" data-toggle="dropdown">
                                                        <i class="ti-more-alt"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right shadow border-0 rounded-3">
                                                        <a class="dropdown-item py-2" href="#"><i class="ti-pencil me-2 text-primary"></i>Chỉnh sửa</a>
                                                        <a class="dropdown-item py-2 text-danger" href="#"><i class="ti-trash me-2"></i>Xóa sản phẩm</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="py-5 text-center text-muted">
                                            <i class="ti-package display-4 opacity-25 d-block mb-3"></i>
                                            Chưa có sản phẩm nào được tạo.
                                        </td>
                                    </tr>
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