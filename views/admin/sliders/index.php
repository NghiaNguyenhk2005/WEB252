<?php require_once 'views/admin/partials/header.php'; ?>

<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-4 mt-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h4 class="header-title mb-4">Thêm Slide mới</h4>
                    <form action="index.php?url=admin/sliders/store" method="POST" enctype="multipart/form-data">
                        <div class="form-group mb-3">
                            <label class="small fw-bold">Tiêu đề chính</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="small fw-bold">Tiêu đề phụ (Badge)</label>
                            <input type="text" class="form-control" name="subtitle">
                        </div>
                        <div class="form-group mb-3">
                            <label class="small fw-bold">Ảnh Slide</label>
                            <input type="file" class="form-control-file" name="image" required>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label class="small fw-bold">Chữ trên nút</label>
                                    <input type="text" class="form-control" name="button_text" value="Khám phá">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label class="small fw-bold">Link nút</label>
                                    <input type="text" class="form-control" name="button_link" value="#">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-4 rounded-pill">Lưu Slide</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8 mt-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h4 class="header-title mb-4">Danh sách Slide</h4>
                    <div class="table-responsive">
                        <table class="table table-hover text-center align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>Thứ tự</th>
                                    <th>Hình ảnh</th>
                                    <th>Tiêu đề</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($sliders) && is_object($sliders) && $sliders->num_rows > 0): ?>
                                    <?php while($s = $sliders->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $s['display_order'] ?></td>
                                            <td><img src="<?= $s['image_url'] ?>" width="120" class="rounded shadow-sm"></td>
                                            <td class="text-left small fw-bold"><?= htmlspecialchars($s['title']) ?></td>
                                            <td>
                                                <a href="index.php?url=admin/sliders/delete&id=<?= $s['id'] ?>" class="text-danger" onclick="return confirm('Xóa slide này?')"><i class="ti-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="py-5 text-muted">Chưa có slide nào</td></tr>
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