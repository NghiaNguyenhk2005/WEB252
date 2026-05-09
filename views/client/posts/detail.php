<?php require_once 'views/client/components/header.php'; ?>

<article class="py-5">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-4" data-aos="fade-up">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php?url=news" class="text-decoration-none text-muted">Tin tức</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $post['title'] ?></li>
                    </ol>
                </nav>
                
                <header class="mb-5" data-aos="fade-up">
                    <h1 class="fw-bold display-4 mb-4"><?= $post['title'] ?></h1>
                    <div class="d-flex align-items-center text-muted">
                        <i class="bi bi-calendar3 me-2"></i>
                        <span><?= date('d/m/Y', strtotime($post['created_at'])) ?></span>
                        <span class="mx-3">|</span>
                        <i class="bi bi-person me-2"></i>
                        <span>Tác giả: Admin</span>
                    </div>
                </header>

                <div class="post-content lead text-muted" data-aos="fade-up" data-aos-delay="100">
                    <img src="<?= $post['thumbnail'] ?? 'assets/client/img/bg1.jpg' ?>" class="img-fluid rounded-4 mb-5 shadow-sm w-100" alt="<?= $post['title'] ?>">
                    <div class="content mb-5">
                        <?= $post['content'] ?>
                    </div>
                </div>

                <!-- COMMENT SECTION -->
                <div class="mt-5 pt-5 border-top">
                    <h4 class="fw-bold mb-4">Bình luận bài viết</h4>
                    
                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="card border-0 shadow-sm rounded-4 p-4 mb-5">
                            <form action="index.php?url=comment/post" method="POST">
                                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                <div class="mb-3">
                                    <textarea name="content" class="form-control rounded-3" rows="3" placeholder="Chia sẻ cảm nghĩ của bạn..." required></textarea>
                                </div>
                                <div class="text-end">
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
                                <div class="d-flex mb-4">
                                    <img src="<?= $comment['avatar'] ?? 'assets/client/img/dashboard.jpg' ?>" class="rounded-circle me-3" width="50" height="50" style="object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <div class="bg-light p-3 rounded-4">
                                            <h6 class="fw-bold mb-1"><?= htmlspecialchars($comment['username']) ?></h6>
                                            <p class="text-muted mb-0 small"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                                        </div>
                                        <div class="mt-1 ps-2">
                                            <span class="text-muted extra-small"><?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-center text-muted">Chưa có bình luận nào.</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <hr class="my-5">
                
                <div class="d-flex justify-content-between align-items-center">
                    <a href="index.php?url=news" class="btn btn-outline-primary rounded-pill px-4"><i class="bi bi-arrow-left me-2"></i> Quay lại danh sách</a>
                    <div class="share-buttons">
                        <span class="text-muted me-3">Chia sẻ:</span>
                        <a href="#" class="text-muted fs-5 me-3"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-muted fs-5 me-3"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="text-muted fs-5"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>

<?php require_once 'views/client/components/footer.php'; ?>