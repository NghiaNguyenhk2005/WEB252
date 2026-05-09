<?php require_once 'views/client/components/header.php'; ?>

<section class="py-5 bg-light min-vh-100">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h2 class="fw-bold mb-0">Giỏ hàng của bạn</h2>
                <p class="text-muted mb-0">Quản lý các sản phẩm bạn đã chọn</p>
            </div>
            <a href="index.php?url=products" class="text-decoration-none small fw-bold"><i class="bi bi-arrow-left me-1"></i> Tiếp tục mua sắm</a>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <div id="cart-content">
                    <?php if (isset($items) && is_object($items) && $items->num_rows > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle">
                                <thead>
                                    <tr class="text-muted small text-uppercase border-bottom">
                                        <th class="pb-3">Sản phẩm</th>
                                        <th class="pb-3 text-center">Số lượng</th>
                                        <th class="pb-3 text-end">Thành tiền</th>
                                        <th class="pb-3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total = 0;
                                    while($item = $items->fetch_assoc()): 
                                        $subtotal = ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
                                        $total += $subtotal;
                                    ?>
                                        <tr class="border-bottom item-row" data-product-id="<?= $item['product_id'] ?>">
                                            <td class="py-4" style="min-width: 250px;">
                                                <div class="d-flex align-items-center">
                                                    <img src="<?= $item['image'] ?? 'assets/client/img/dashboard.jpg' ?>" width="70" height="70" class="rounded-3 me-3 shadow-sm" style="object-fit: cover;">
                                                    <div>
                                                        <h6 class="fw-bold mb-1"><?= htmlspecialchars($item['name']) ?></h6>
                                                        <p class="mb-0 small text-muted"><?= number_format($item['price'], 0, ',', '.') ?>đ / sản phẩm</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4" style="width: 140px;">
                                                <div class="input-group input-group-sm border rounded-pill overflow-hidden mx-auto" style="width: 110px;">
                                                    <button class="btn btn-link text-dark text-decoration-none btn-update-qty px-2" data-action="minus" type="button">-</button>
                                                    <input type="text" class="form-control text-center border-0 bg-transparent qty-input" value="<?= $item['quantity'] ?>" readonly>
                                                    <button class="btn btn-link text-dark text-decoration-none btn-update-qty px-2" data-action="plus" type="button">+</button>
                                                </div>
                                            </td>
                                            <td class="py-4 text-end fw-bold text-primary item-subtotal">
                                                <?= number_format($subtotal, 0, ',', '.') ?>đ
                                            </td>
                                            <td class="py-4 text-end">
                                                <button class="btn btn-link text-danger btn-remove-item p-0" title="Xóa" type="button">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-cart-x display-1 text-muted opacity-25 mb-4"></i>
                            <h5 class="text-muted">Giỏ hàng của bạn đang trống</h5>
                            <p class="small text-muted mb-4">Hãy khám phá thêm nhiều sản phẩm tuyệt vời của TechSaaS nhé!</p>
                            <a href="index.php?url=products" class="btn btn-primary rounded-pill px-5 py-2 shadow-sm">Mua sắm ngay</a>
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 sticky-top sticky-top-mobile-off">
                    <h5 class="fw-bold mb-4">Tóm tắt đơn hàng</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Tạm tính</span>
                        <span class="fw-medium cart-total-display"><?= number_format($total ?? 0, 0, ',', '.') ?>đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-muted">Phí vận chuyển</span>
                        <span class="text-success fw-medium">Miễn phí</span>
                    </div>
                    <hr class="mb-4">
                    <div class="d-flex justify-content-between mb-5">
                        <span class="fw-bold fs-5">Tổng tiền</span>
                        <span class="fw-bold fs-4 text-primary cart-total-display"><?= number_format($total ?? 0, 0, ',', '.') ?>đ</span>
                    </div>
                    
                    <a href="index.php?url=checkout" class="btn btn-gradient btn-lg w-100 rounded-pill py-3 shadow <?= ($total ?? 0) <= 0 ? 'disabled' : '' ?>" id="btn-checkout">Tiến hành thanh toán</a>
                    <div class="mt-4 text-center">
                        <p class="small text-muted mb-0">Hỗ trợ thanh toán: <b>COD, Chuyển khoản</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cartContent = document.getElementById('cart-content');

    if (cartContent) {
        cartContent.addEventListener('click', function(e) {
            const btnUpdate = e.target.closest('.btn-update-qty');
            if (btnUpdate) {
                const row = btnUpdate.closest('.item-row');
                const productId = row.dataset.productId;
                const input = row.querySelector('.qty-input');
                let currentQty = parseInt(input.value);
                const action = btnUpdate.dataset.action;

                if (action === 'plus') currentQty++;
                else if (action === 'minus' && currentQty > 1) currentQty--;
                else if (action === 'minus' && currentQty === 1) {
                    if(!confirm('Bạn muốn xóa sản phẩm này khỏi giỏ hàng?')) return;
                    currentQty = 0;
                }

                updateCart(productId, currentQty, row);
            }

            const btnRemove = e.target.closest('.btn-remove-item');
            if (btnRemove) {
                if(!confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) return;
                const row = btnRemove.closest('.item-row');
                updateCart(row.dataset.productId, 0, row);
            }
        });
    }

    function updateCart(productId, qty, row) {
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', qty);

        fetch('index.php?url=cart/update', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.removed) {
                    row.remove();
                    if (document.querySelectorAll('.item-row').length === 0) {
                        location.reload(); 
                    }
                } else {
                    row.querySelector('.qty-input').value = qty;
                    row.querySelector('.item-subtotal').innerText = data.item_subtotal;
                }
                
                document.querySelectorAll('.cart-total-display').forEach(el => el.innerText = data.total);
                
                const badge = document.querySelector('.nav-link .badge.bg-danger');
                if (badge) {
                    if (data.cart_count > 0) {
                        badge.innerText = data.cart_count;
                    } else {
                        badge.remove();
                    }
                }
                
                if (data.cart_count === 0) {
                    const checkoutBtn = document.getElementById('btn-checkout');
                    if (checkoutBtn) checkoutBtn.classList.add('disabled');
                }
            }
        })
        .catch(err => console.error('Error updating cart:', err));
    }
});
</script>

<?php require_once 'views/client/components/footer.php'; ?>