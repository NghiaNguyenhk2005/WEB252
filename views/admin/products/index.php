<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="srt-page-header">
    <div>
        <h4><i class="fa-solid fa-box-open me-2" style="color:var(--accent);"></i>Quản lý Sản phẩm</h4>
    </div>
    <a href="<?= BASE_PATH ?>/admin/products/create" class="btn-srt-primary text-decoration-none">
        <i class="fa-solid fa-plus"></i> Thêm sản phẩm
    </a>
</div>

<div class="srt-card">
    <div class="srt-card-header">
        <span><i class="fa-solid fa-list me-2"></i>Danh sách sản phẩm</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="srt-table">
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Sản phẩm</th>
                    <th style="width:130px;">Giá bán</th>
                    <th style="width:120px;text-align:center;">Tồn kho</th>
                    <th style="width:110px;text-align:center;">Hành động</th>
                </tr>
            </thead>
            <tbody>
            <?php if (isset($products) && is_object($products) && $products->num_rows > 0):
                while ($product = $products->fetch_assoc()): ?>
                <tr>
                    <td style="color:#aaa;font-size:.82rem;">#<?= $product['id'] ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="<?= BASE_PATH ?>/<?= htmlspecialchars($product['image'] ?? 'assets/client/img/dashboard.jpg') ?>"
                                 width="50" height="50"
                                 class="rounded-3 flex-shrink-0"
                                 style="object-fit:cover;border:1px solid #eee;"
                                 onerror="this.src='<?= BASE_PATH ?>/assets/client/img/dashboard.jpg'">
                            <div>
                                <div class="fw-semibold" style="font-size:.88rem;"><?= htmlspecialchars($product['name']) ?></div>
                                <div style="font-size:.77rem;color:#aaa;"><?= htmlspecialchars($product['slug'] ?? '') ?></div>
                            </div>
                        </div>
                    </td>
                    <td style="font-weight:700;color:var(--accent);">
                        <?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ
                    </td>
                    <td style="text-align:center;">
                        <?php if (($product['stock'] ?? 0) > 10): ?>
                            <span class="badge-active"><?= $product['stock'] ?> còn</span>
                        <?php elseif (($product['stock'] ?? 0) > 0): ?>
                            <span class="badge-pending"><?= $product['stock'] ?> còn</span>
                        <?php else: ?>
                            <span class="badge-banned">Hết hàng</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align:center;">
                        <div class="srt-actions" style="justify-content:center;">
                            <a href="<?= BASE_PATH ?>/admin/products/edit?id=<?= $product['id'] ?>"
                            class="btn-srt-warning btn-srt-sm text-decoration-none" title="Chỉnh sửa">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form method="POST"
                                action="<?= BASE_PATH ?>/admin/products/delete"
                                onsubmit="return confirm('Xoá sản phẩm «<?= addslashes(htmlspecialchars($product['name'])) ?>»?')">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                <button type="submit" class="btn-srt-danger btn-srt-sm" title="Xoá">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endwhile; else: ?>
                <tr>
                    <td colspan="5" class="text-center py-5" style="color:#aaa;">
                        <i class="fa-solid fa-box-open fa-2x mb-2 d-block" style="opacity:.3;"></i>
                        Chưa có sản phẩm nào. <a href="<?= BASE_PATH ?>/admin/products/create" class="fw-bold" style="color:var(--accent);">Thêm ngay</a>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($pages) && $pages > 1): ?>
    <div style="padding:16px 20px;">
        <div class="srt-pagination">
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <?php if ($i == ($page ?? 1)): ?>
                    <span class="active"><?= $i ?></span>
                <?php else: ?>
                    <a href="<?= BASE_PATH ?>/admin/products?page=<?= $i ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
