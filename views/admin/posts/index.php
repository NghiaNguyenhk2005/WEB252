<?php require_once 'views/admin/partials/header.php'; ?>

<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="header-title mb-0">Quản lý Tin tức</h4>
                        <a href="index.php?url=admin/posts/create" class="btn btn-primary rounded-pill px-4">Thêm bài viết mới</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover text-center align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Ảnh</th>
                                    <th>Tiêu đề</th>
                                    <th>Ngày đăng</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($posts) && is_object($posts) && $posts->num_rows > 0): ?>
                                    <?php while($post = $posts->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $post['id'] ?></td>
                                            <td><img src="<?= $post['thumbnail'] ?? 'assets/client/img/bg1.jpg' ?>" width="60" height="40" class="rounded shadow-sm" style="object-fit: cover;"></td>
                                            <td class="text-left small fw-bold" style="max-width: 300px;"><?= htmlspecialchars($post['title']) ?></td>
                                            <td><?= date('d/m/Y', strtotime($post['created_at'])) ?></td>
                                            <td>
                                                <a href="index.php?url=news/<?= $post['slug'] ?>" target="_blank" class="text-info mr-3"><i class="fa fa-eye"></i></a>
                                                <a href="index.php?url=admin/posts/delete&id=<?= $post['id'] ?>" class="text-danger" onclick="return confirm('Xóa bài viết này?')"><i class="ti-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="5" class="py-5 text-muted">Chưa có bài viết nào</td></tr>
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