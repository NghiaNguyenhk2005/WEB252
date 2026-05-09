<?php require_once 'views/admin/partials/header.php'; ?>

<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-4 mt-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h4 class="header-title mb-4">Thêm Danh mục mới</h4>
                    <form action="index.php?url=admin/categories/store" method="POST">
                        <div class="form-group mb-3">
                            <label class="small fw-bold">Tên danh mục</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="small fw-bold">Slug (Để trống tự tạo)</label>
                            <input type="text" class="form-control" id="slug" name="slug">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-4 rounded-pill">Lưu danh mục</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8 mt-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h4 class="header-title mb-4">Danh sách Danh mục</h4>
                    <div class="table-responsive">
                        <table class="table table-hover text-center align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên danh mục</th>
                                    <th>Slug</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($categories) && is_object($categories) && $categories->num_rows > 0): ?>
                                    <?php while($cat = $categories->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $cat['id'] ?></td>
                                            <td class="fw-bold"><?= htmlspecialchars($cat['name']) ?></td>
                                            <td><?= $cat['slug'] ?></td>
                                            <td>
                                                <a href="index.php?url=admin/categories/delete&id=<?= $cat['id'] ?>" class="text-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"><i class="ti-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="py-5 text-muted">Không có dữ liệu</td>
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