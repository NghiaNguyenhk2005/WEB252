<style>
.srt-card,
.srt-card-body,
.table-responsive,
.dropdown,
.srt-table,
.srt-table tbody,
.srt-table tr,
.srt-table td {
    overflow: visible !important;
}

.dropdown-menu {
    z-index: 99999 !important;
    position: absolute !important;
}

.srt-table {
    position: relative;
}
.badge-refunded {
    background: #fef3c7;
    color: #d97706;
    border-radius: 20px;
    padding: 3px 10px;
    font-size: 0.74rem;
    font-weight: 700;
    white-space: nowrap;
    display: inline-block;
}
</style>

<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="srt-page-header">
    <div>
        <h4><i class="fa-solid fa-receipt me-2" style="color:var(--accent);"></i>Quản lý Đơn hàng</h4>
    </div>
    <?php if (!empty($total)): ?>
    <div class="srt-stat-pill">Tổng: <strong><?= (int)$total ?></strong> đơn hàng</div>
    <?php endif; ?>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="srt-alert srt-alert-success"><i class="fa-solid fa-check-circle"></i>Cập nhật trạng thái thành công.</div>
<?php endif; ?>

<div class="srt-card">
    <div class="srt-card-header">
        <span><i class="fa-solid fa-list me-2"></i>Danh sách đơn hàng</span>
    </div>
    <!-- FIX 3: overflow:visible so status dropdown isn't clipped -->
    <div style="overflow:visible;">
        <table class="srt-table">
            <thead>
                <tr>
                    <th style="width:70px;">Mã đơn</th>
                    <th>Khách hàng</th>
                    <th style="width:130px;">Tổng tiền</th>
                    <th style="width:110px;">Ngày đặt</th>
                    <th style="width:165px;">Trạng thái</th>
                    <th style="width:90px;text-align:center;">Chi tiết</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $statusLabels = [
                'pending'   => ['Chờ xử lý',    'badge-pending'],
                'paid'      => ['Đã thanh toán', 'badge-active'],
                'shipping'  => ['Đang giao',     'badge-shipping'],
                'completed' => ['Hoàn thành',    'badge-completed'],
                'cancelled' => ['Đã huỷ',        'badge-banned'],
                'refunded'  => ['Đã hoàn tiền',  'badge-refunded'],
            ];

            if (isset($orders) && is_object($orders) && $orders->num_rows > 0):
                while ($order = $orders->fetch_assoc()):
                    $st = $statusLabels[$order['status']] ?? ['Không rõ', 'badge-member'];
            ?>
                <!-- FIX 3: position:relative on tr allows dropdown to escape overflow -->
                <tr style="position:relative;">
                    <td>
                        <span class="fw-bold" style="color:var(--accent);">#<?= $order['id'] ?></span>
                    </td>
                    <td>
                        <div class="fw-semibold" style="font-size:.88rem;">
                            <?= htmlspecialchars($order['username'] ?? $order['full_name'] ?? 'Khách') ?>
                        </div>
                        <?php if (!empty($order['phone'])): ?>
                            <div style="font-size:.78rem;color:#aaa;"><?= htmlspecialchars($order['phone']) ?></div>
                        <?php endif; ?>
                    </td>
                    <td style="font-weight:700;color:#1a9c5b;">
                        <?= number_format($order['total_price'] ?? 0, 0, ',', '.') ?>đ
                    </td>
                    <td style="font-size:.82rem;color:#888;white-space:nowrap;">
                        <?= $order['created_at'] ? date('d/m/Y H:i', strtotime($order['created_at'])) : '—' ?>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button"
                                    class="btn-srt-primary btn-srt-sm dropdown-toggle"
                                    data-bs-toggle="dropdown"
                                    data-bs-boundary="viewport"
                                    style="min-width:130px;justify-content:space-between;
                                        <?php
                                        $colors = [
                                            'pending'   => 'background:#d97706;',
                                            'paid'      => 'background:#2563eb;',
                                            'shipping'  => 'background:#0891b2;',
                                            'completed' => 'background:#16a34a;',
                                            'cancelled' => 'background:#dc2626;',
                                            'refunded'  => 'background:#6b7280;',
                                        ];
                                        echo $colors[$order['status']] ?? '';
                                        ?>">
                                <span><?= $st[0] ?></span>
                                <i class="fa-solid fa-chevron-down" style="font-size:.65rem;"></i>
                            </button>
                            <!-- FIX 3: dropdown-menu-end + z-index to ensure it appears above table rows -->
                            <ul class="dropdown-menu shadow border-0" style="font-size:.82rem;min-width:155px;z-index:1055;">
                                <?php foreach ($statusLabels as $val => [$label, $badgeCls]): ?>
                                <li>
                                    <form method="POST" action="<?= BASE_PATH ?>/admin/orders/update">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id" value="<?= $order['id'] ?>">
                                        <input type="hidden" name="status" value="<?= $val ?>">
                                        <button type="submit"
                                                class="dropdown-item d-flex align-items-center gap-2 <?= $order['status'] === $val ? 'fw-bold' : '' ?>">
                                            <?php if ($order['status'] === $val): ?>
                                                <i class="fa-solid fa-check text-success" style="width:14px;"></i>
                                            <?php else: ?>
                                                <span style="width:14px;display:inline-block;"></span>
                                            <?php endif; ?>
                                            <?= $label ?>
                                        </button>
                                    </form>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </td>
                    <td style="text-align:center;">
                        <button type="button"
                                class="btn-srt-secondary btn-srt-sm"
                                title="Xem chi tiết đơn hàng"
                                onclick="showOrderDetail(<?= $order['id'] ?>)">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </td>
                </tr>
            <?php endwhile; else: ?>
                <tr>
                    <td colspan="6" class="text-center py-5" style="color:#aaa;">
                        <i class="fa-solid fa-receipt fa-2x mb-2 d-block" style="opacity:.3;"></i>
                        Chưa có đơn hàng nào.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($pages) && $pages > 1): ?>
    <div style="padding:16px 20px;">
        <div class="srt-pagination">
            <?php if (($page ?? 1) > 1): ?>
                <a href="<?= BASE_PATH ?>/admin/orders?page=<?= ($page ?? 1) - 1 ?>"><i class="fa-solid fa-chevron-left"></i></a>
            <?php else: ?>
                <span class="disabled"><i class="fa-solid fa-chevron-left"></i></span>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <?php if ($i == ($page ?? 1)): ?>
                    <span class="active"><?= $i ?></span>
                <?php elseif (abs($i - ($page ?? 1)) <= 2 || $i == 1 || $i == $pages): ?>
                    <a href="<?= BASE_PATH ?>/admin/orders?page=<?= $i ?>"><?= $i ?></a>
                <?php elseif (abs($i - ($page ?? 1)) == 3): ?>
                    <span class="disabled">…</span>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if (($page ?? 1) < $pages): ?>
                <a href="<?= BASE_PATH ?>/admin/orders?page=<?= ($page ?? 1) + 1 ?>"><i class="fa-solid fa-chevron-right"></i></a>
            <?php else: ?>
                <span class="disabled"><i class="fa-solid fa-chevron-right"></i></span>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Order Detail Modal -->
<div class="modal fade" id="orderDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:520px;">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header" style="border-bottom:1px solid #f0f0f0;">
                <h6 class="modal-title fw-bold">
                    <i class="fa-solid fa-receipt me-2" style="color:var(--accent);"></i>
                    Chi tiết đơn hàng #<span id="display-id"></span>
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div id="modal-spinner" class="text-center py-5">
                    <div class="spinner-border" style="color:var(--accent);" role="status"></div>
                    <p class="text-muted mt-2 small">Đang tải...</p>
                </div>
                <div id="modal-data" class="d-none">

                    <!-- EXTRA ORDER INFO -->
                    <div id="order-extra-info"
                        style="
                            padding:20px 22px;
                            background:#fafbfc;
                            border-bottom:1px solid #f1f1f1;
                        ">
                    </div>

                    <div class="d-flex justify-content-between align-items-center p-4 pb-3"
                        style="border-bottom:1px solid #f5f5f5;">

                        <div style="font-size:.85rem;color:#888;">
                            <i class="fa-solid fa-calendar me-1"></i>
                            <span id="display-date"></span>
                        </div>

                        <div class="fw-bold"
                            style="font-size:1rem;color:#1a9c5b;"
                            id="display-total">
                        </div>

                    </div>

                    <div style="padding:0 0 8px;">
                        <table style="width:100%;font-size:.85rem;border-collapse:collapse;">

                            <thead>
                                <tr style="background:#f8f9fc;">

                                    <th style="padding:10px 20px;
                                            text-align:left;
                                            font-size:.72rem;
                                            text-transform:uppercase;
                                            letter-spacing:.7px;
                                            color:#888;
                                            font-weight:800;">
                                        Sản phẩm
                                    </th>

                                    <th style="padding:10px 14px;
                                            text-align:center;
                                            font-size:.72rem;
                                            text-transform:uppercase;
                                            letter-spacing:.7px;
                                            color:#888;
                                            font-weight:800;">
                                        SL
                                    </th>

                                    <th style="padding:10px 20px;
                                            text-align:right;
                                            font-size:.72rem;
                                            text-transform:uppercase;
                                            letter-spacing:.7px;
                                            color:#888;
                                            font-weight:800;">
                                        Thành tiền
                                    </th>

                                </tr>
                            </thead>

                            <tbody id="display-items"></tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
function showOrderDetail(id) {
    const modal = new bootstrap.Modal(document.getElementById('orderDetailModal'));
    document.getElementById('display-id').textContent = id;
    document.getElementById('modal-data').classList.add('d-none');
    document.getElementById('modal-spinner').innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border" style="color:var(--accent);" role="status"></div>
            <p class="text-muted mt-2 small">Đang tải...</p>
        </div>`;
    modal.show();

    // FIX 2: Use BASE_PATH clean URL, not index.php?url=
    fetch(`<?= BASE_PATH ?>/admin/orders/detail?id=${id}`)
        .then(r => {
            // FIX 2: Check content-type before parsing to catch HTML error pages
            const ct = r.headers.get('content-type') || '';
            if (!ct.includes('application/json')) {
                throw new Error('Server trả về HTML thay vì JSON (HTTP ' + r.status + '). Kiểm tra lỗi PHP.');
            }
            return r.json();
        })
        .then(data => {
            if (data.error) throw new Error(data.error);

            document.getElementById('display-date').textContent = data.order.created_at ?? '—';
            document.getElementById('display-total').textContent =
                new Intl.NumberFormat('vi-VN')
                    .format(data.order.total_price ?? 0) + 'đ';

            // EXTRA ORDER INFO
            document.getElementById('order-extra-info').innerHTML = `
                <div class="row g-4" style="font-size:.84rem;line-height:1.45;">
                    <div class="col-6">
                    <div style="
                        color:#9ca3af;
                        font-size:.72rem;
                        font-weight:700;
                        text-transform:uppercase;
                        letter-spacing:.5px;
                        margin-bottom:3px;
                    ">
                        Khách hàng
                    </div>   
                        <div class="fw-semibold">
                            ${data.order.full_name ?? data.order.user?.username ?? 'Khách'}
                        </div>
                    </div>

                    <div class="col-6">
                        <div style="color:#999;">Số điện thoại</div>
                        <div>
                            ${data.order.phone ?? '—'}
                        </div>
                    </div>

                    <div class="col-6">
                        <div style="color:#999;">Tài khoản</div>
                        <div>
                            ${data.order.user?.username ?? 'Guest'}
                        </div>
                    </div>

                    <div class="col-6">
                        <div style="color:#999;">Email</div>
                        <div>
                            ${data.order.user?.email ?? '—'}
                        </div>
                    </div>

                    <div class="col-6">
                        <div style="color:#999;">Trạng thái</div>

                        <div class="fw-bold text-capitalize"
                            style="
                                color:
                                ${
                                    data.order.status === 'completed'
                                    ? '#16a34a'
                                    : data.order.status === 'cancelled'
                                    ? '#dc2626'
                                    : data.order.status === 'shipping'
                                    ? '#0891b2'
                                    : data.order.status === 'paid'
                                    ? '#2563eb'
                                    : '#d97706'
                                };
                            ">
                            ${
                                data.order.status === 'pending'
                                ? 'Chờ xử lý'
                                : data.order.status === 'paid'
                                ? 'Đã thanh toán'
                                : data.order.status === 'shipping'
                                ? 'Đang giao'
                                : data.order.status === 'completed'
                                ? 'Hoàn thành'
                                : 'Đã huỷ'
                            }
                        </div>
                    </div>

                    <div class="col-6">
                        <div style="color:#999;">Thanh toán</div>
                        <div>
                            ${data.order.payment_method ?? 'COD'}
                        </div>
                    </div>
                    <div class="col-12">
                        <div style="color:#999;">Địa chỉ</div>
                        <div>
                            ${data.order.address ?? '—'}
                        </div>
                    </div>
                    ${
                        data.order.note
                        ? `
                        <div class="col-12">
                            <div style="color:#999;">Ghi chú</div>
                            <div>${data.order.note}</div>
                        </div>
                        `
                        : ''
                    }

                </div>
            `;
            let rows = '';
            if (data.items && data.items.length > 0) {
                data.items.forEach(item => {
                    const subtotal = (item.price ?? 0) * (item.quantity ?? 1);
                    rows += `
                    <tr style="border-bottom:1px solid #f5f5f5;">

                        <td style="padding:12px 20px;">

                            <div style="
                                display:flex;
                                align-items:center;
                                gap:12px;
                            ">

                                <img
                                    src="<?= BASE_PATH ?>/${item.image ?? 'uploads/products/default.png'}"
                                    alt="${item.product_name ?? 'Product'}"
                                    style="
                                        width:52px;
                                        height:52px;
                                        object-fit:cover;
                                        border-radius:12px;
                                        border:1px solid #eee;
                                        background:#fff;
                                        flex-shrink:0;
                                    "
                                >

                                <div>

                                    <div style="
                                        font-weight:600;
                                        color:#222;
                                        margin-bottom:2px;
                                    ">
                                        ${item.product_name ?? 'Sản phẩm'}
                                    </div>

                                    <div style="
                                        font-size:.78rem;
                                        color:#999;
                                    ">
                                        ${new Intl.NumberFormat('vi-VN')
                                            .format(item.price ?? 0)}đ/cái
                                    </div>

                                </div>

                            </div>

                        </td>

                        <td style="
                            padding:10px 14px;
                            text-align:center;
                            color:#555;
                            font-weight:600;
                        ">
                            ${item.quantity}
                        </td>

                        <td style="
                            padding:10px 20px;
                            text-align:right;
                            font-weight:700;
                            color:#16a34a;
                            white-space:nowrap;
                        ">
                            ${new Intl.NumberFormat('vi-VN')
                                .format(subtotal)}đ
                        </td>

                    </tr>
                    `;
                });
            } else {
                rows = '<tr><td colspan="3" style="padding:20px;text-align:center;color:#aaa;">Không có sản phẩm.</td></tr>';
            }
            document.getElementById('display-items').innerHTML = rows;
            document.getElementById('modal-spinner').classList.add('d-none');
            document.getElementById('modal-data').classList.remove('d-none');
        })
        .catch(err => {
            document.getElementById('modal-spinner').innerHTML = `
                <div class="text-center py-4">
                    <i class="fa-solid fa-circle-exclamation fa-2x text-danger mb-2 d-block"></i>
                    <p class="text-danger small">${err.message}</p>
                </div>`;
        });
}
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
