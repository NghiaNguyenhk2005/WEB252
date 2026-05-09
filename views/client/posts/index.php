<?php require_once 'views/client/components/header.php'; ?>

<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h1 class="fw-bold display-5">Tin tức & Sự kiện</h1>
            <p class="text-muted lead">Cập nhật những xu hướng công nghệ và thông báo mới nhất từ TechSaaS.</p>
        </div>

        <div class="row g-4">
            <?php if (isset($posts) && is_object($posts) && $posts->num_rows > 0): ?>
                <?php while($post = $posts->fetch_assoc()): ?>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                            <img src="<?= $post['thumbnail'] ?? 'assets/client/img/bg1.jpg' ?>" class="card-img-top" alt="<?= $post['title'] ?>" style="height: 220px; object-fit: cover;">
                            <div class="card-body p-4">
                                <p class="text-primary small fw-bold mb-2"><?= date('d/m/Y', strtotime($post['created_at'])) ?></p>
                                <h4 class="card-title fw-bold mb-3"><?= $post['title'] ?></h4>
                                <a href="index.php?url=news/<?= $post['slug'] ?>" class="text-decoration-none fw-bold">Đọc thêm <i class="bi bi-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Chưa có bài viết nào.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <?php for($i=1; $i<=$totalPages; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link rounded-circle mx-1 px-3" href="index.php?url=news&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'views/client/components/footer.php'; ?>