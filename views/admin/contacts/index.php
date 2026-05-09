<?php require_once 'views/admin/partials/header.php'; ?>

<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h4 class="header-title mb-4">Quản lý Liên hệ</h4>
                    <div class="table-responsive">
                        <table class="table table-hover text-center align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Lời nhắn</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($contacts) && is_object($contacts) && $contacts->num_rows > 0): ?>
                                    <?php while($c = $contacts->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $c['id'] ?></td>
                                            <td class="fw-bold"><?= htmlspecialchars($c['name']) ?></td>
                                            <td><?= htmlspecialchars($c['email']) ?></td>
                                            <td class="text-left small" style="max-width: 250px;"><?= htmlspecialchars($c['message']) ?></td>
                                            <td>
                                                <form action="index.php?url=admin/contacts/update" method="POST">
                                                    <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                                    <select name="status" class="form-control form-control-sm rounded-pill" onchange="this.form.submit()">
                                                        <option value="new" <?= $c['status'] == 'new' ? 'selected' : '' ?>>Mới</option>
                                                        <option value="read" <?= $c['status'] == 'read' ? 'selected' : '' ?>>Đã đọc</option>
                                                        <option value="replied" <?= $c['status'] == 'replied' ? 'selected' : '' ?>>Đã phản hồi</option>
                                                    </select>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="index.php?url=admin/contacts/delete&id=<?= $c['id'] ?>" class="text-danger" onclick="return confirm('Xóa liên hệ này?')"><i class="ti-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="6" class="py-5 text-muted">Không có tin nhắn liên hệ nào</td></tr>
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