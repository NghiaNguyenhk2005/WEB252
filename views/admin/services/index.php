<?php require_once 'views/admin/partials/header.php'; ?>

<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="header-title mb-0">Quản lý Dịch vụ</h4>
                        <a href="index.php?url=admin/services/create" class="btn btn-primary rounded-pill px-4">Thêm dịch vụ mới</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover text-center align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Icon</th>
                                    <th>Tên dịch vụ</th>
                                    <th>Mô tả ngắn</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($services) && is_object($services) && $services->num_rows > 0): ?>
                                    <?php while($s = $services->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $s['id'] ?></td>
                                            <td><i class="bi <?= $s['icon'] ?> fs-4 text-primary"></i></td>
                                            <td class="fw-bold"><?= htmlspecialchars($s['name']) ?></td>
                                            <td class="text-left small" style="max-width: 300px;"><?= htmlspecialchars($s['short_description']) ?></td>
                                            <td>
                                                <a href="index.php?url=admin/services/delete&id=<?= $s['id'] ?>" class="text-danger" onclick="return confirm('Xóa dịch vụ này?')"><i class="ti-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="5" class="py-5 text-muted">Chưa có dịch vụ nào</td></tr>
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