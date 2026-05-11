<?php
// SEO is already set in the controller
// The header will render the SEO tags automatically
?>
<?php require_once 'views/client/components/header.php'; ?>

<section class="py-5 bg-light">
    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($categoryName) ?></li>
            </ol>
        </nav>

        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h5 class="fw-bold mb-4">Danh mục</h5>
                    <div class="list-group list-group-flush">
                        <a href="index.php?url=products" class="list-group-item list-group-item-action border-0 px-0 <?= !$categoryId ? 'text-primary fw-bold' : '' ?>">Tất cả sản phẩm</a>
                        <?php while(isset($categories) && is_object($categories) && $cat = $categories->fetch_assoc()): ?>
                            <a href="index.php?url=products&category=<?= $cat['id'] ?>" class="list-group-item list-group-item-action border-0 px-0 <?= $categoryId == $cat['id'] ? 'text-primary fw-bold' : '' ?>">
                                <?= htmlspecialchars($cat['name']) ?>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9">
                <h2 class="fw-bold mb-4"><?= htmlspecialchars($categoryName) ?></h2>
                <div class="row g-4">
                    <?php if (isset($products) && is_object($products) && $products->num_rows > 0): ?>
                        <?php 
                        while($product = $products->fetch_assoc()): ?>
                            <div class="col-md-4 col-sm-6" data-aos="fade-up">
                                <div class="card product-card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                                    <img src="<?= $product['image'] ?? 'assets/client/img/dashboard.jpg' ?>" class="card-img-top" alt="<?= $product['name'] ?>" style="height: 180px; object-fit: cover;">
                                    <div class="card-body p-4">
                                        <h6 class="card-title fw-bold mb-2"><?= $product['name'] ?></h6>
                                        <p class="text-primary fw-bold mb-3 small"><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</p>
                                        <div class="d-flex gap-2">
                                            <a href="index.php?url=product/<?= $product['slug'] ?>" class="btn btn-outline-dark btn-sm flex-grow-1 rounded-pill">Chi tiết</a>
                                            <form action="index.php?url=cart/add" method="POST" class="d-inline">
                                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                                <button type="submit" class="btn btn-primary btn-sm rounded-circle" title="Thêm vào giỏ"><i class="bi bi-cart-plus"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">Chưa có sản phẩm nào trong danh mục này.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <nav class="mt-5">
                        <ul class="pagination justify-content-center">
                            <?php for($i=1; $i<=$totalPages; $i++): ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link rounded-circle mx-1" href="index.php?url=products<?= $categoryId ? '&category='.$categoryId : '' ?>&page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require_once 'views/client/components/footer.php'; ?>