<?php require_once 'views/client/components/header.php'; ?>

<section class="py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6" data-aos="fade-right">
                <img src="<?= $product['image'] ?? 'assets/client/img/dashboard.jpg' ?>" class="img-fluid rounded-4 shadow" alt="<?= $product['name'] ?>">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php?url=products" class="text-decoration-none text-muted">Sản phẩm</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $product['name'] ?></li>
                    </ol>
                </nav>
                <h1 class="fw-bold display-5 mb-3 mt-4"><?= $product['name'] ?></h1>
                <h3 class="text-primary fw-bold mb-4"><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</h3>
                <div class="description mb-5 text-muted lead">
                    <?= nl2br($product['description']) ?>
                </div>
                <form action="index.php?url=cart/add" method="POST" class="d-flex gap-3">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" name="add_to_cart" class="btn btn-gradient btn-lg px-5 rounded-pill">Thêm vào giỏ hàng</button>
                    <button type="submit" name="buy_now" class="btn btn-outline-dark btn-lg px-5 rounded-pill">Mua ngay</button>
                </form>
            </div>
        </div>

        <!-- COMMENT SECTION -->
        <div class="row mt-5 pt-5">
            <div class="col-lg-8 mx-auto">
                <h4 class="fw-bold mb-4">Đánh giá sản phẩm</h4>
                
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="card border-0 shadow-sm rounded-4 p-4 mb-5">
                        <form action="index.php?url=comment/product" method="POST">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Để lại bình luận của bạn</label>
                                <textarea name="content" class="form-control rounded-3" rows="3" placeholder="Sản phẩm rất tuyệt vời..." required></textarea>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="rating-input">
                                    <span class="small text-muted me-2">Đánh giá:</span>
                                    <select name="rating" class="form-select form-select-sm d-inline-block w-auto rounded-pill px-3">
                                        <option value="5">5 Sao</option>
                                        <option value="4">4 Sao</option>
                                        <option value="3">3 Sao</option>
                                        <option value="2">2 Sao</option>
                                        <option value="1">1 Sao</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary rounded-pill px-4">Gửi bình luận</button>
                            </div>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="alert alert-light border rounded-4 p-4 text-center mb-5">
                        Bạn cần <a href="index.php?url=login" class="fw-bold">đăng nhập</a> để bình luận.
                    </div>
                <?php endif; ?>

                <div class="comment-list">
                    <?php if (isset($comments) && is_object($comments) && $comments->num_rows > 0): ?>
                        <?php while($comment = $comments->fetch_assoc()): ?>
                            <div class="d-flex mb-4 pb-4 border-bottom">
                                <img src="<?= $comment['avatar'] ?? 'assets/client/img/dashboard.jpg' ?>" class="rounded-circle me-3" width="50" height="50" style="object-fit: cover;">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between mb-1">
                                        <h6 class="fw-bold mb-0"><?= htmlspecialchars($comment['username']) ?></h6>
                                        <span class="text-muted small"><?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?></span>
                                    </div>
                                    <div class="text-warning mb-2 small">
                                        <?php for($i=1; $i<=5; $i++): ?>
                                            <i class="bi bi-star<?= $i <= $comment['rating'] ? '-fill' : '' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <p class="text-muted mb-0"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-center text-muted">Chưa có đánh giá nào cho sản phẩm này.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'views/client/components/footer.php'; ?>