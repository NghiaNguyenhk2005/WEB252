<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="srt-page-header">
    <div>
        <h4><i class="fa-solid fa-users me-2" style="color:var(--accent);"></i>Quản lý Người dùng</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider:'›';">
                <li class="breadcrumb-item">
                    <a href="<?= BASE_PATH ?>/admin/contacts" class="text-decoration-none" style="color:var(--accent);">Admin</a>
                </li>
                <li class="breadcrumb-item active" style="color:#888;">Người dùng</li>
            </ol>
        </nav>
    </div>
    <div style="padding:6px 16px;background:#f0f4ff;border-radius:8px;border:1px solid #d0daf5;font-weight:700;font-size:.85rem;color:#333;">
        Tổng: <strong style="color:var(--accent);"><?= (int)$total ?></strong> tài khoản
    </div>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="srt-alert srt-alert-success"><i class="fa-solid fa-check-circle me-2"></i>Cập nhật thành công.</div>
<?php endif; ?>
<?php if (isset($_GET['deleted'])): ?>
    <div class="srt-alert srt-alert-success"><i class="fa-solid fa-trash me-2"></i>Đã xoá người dùng.</div>
<?php endif; ?>
<?php if (isset($_GET['reset'])): ?>
    <div class="srt-alert srt-alert-success"><i class="fa-solid fa-key me-2"></i>Đã đặt lại mật khẩu thành công.</div>
<?php endif; ?>
<?php if (isset($_GET['error']) && $_GET['error'] === 'password_short'): ?>
    <div class="srt-alert srt-alert-danger"><i class="fa-solid fa-exclamation-circle me-2"></i>Mật khẩu phải có ít nhất 6 ký tự.</div>
<?php endif; ?>

<div class="srt-card">
    <div class="srt-card-header">
        <span><i class="fa-solid fa-list me-2"></i>Danh sách tài khoản</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="srt-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Tên / Avatar</th>
                    <th>Email</th>
                    <th style="width:110px;">Vai trò</th>
                    <th style="width:120px;">Trạng thái</th>
                    <th style="width:100px;">Ngày tạo</th>
                    <th style="width:130px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $stt = ($page - 1) * 15 + 1;
            if ($users->num_rows === 0): ?>
                <tr>
                    <td colspan="7" class="text-center py-5" style="color:#aaa;">
                        <i class="fa-solid fa-users-slash fa-2x mb-2 d-block"></i>Chưa có người dùng nào.
                    </td>
                </tr>
            <?php else: while ($u = $users->fetch_assoc()):
                $isSelf = ($u['id'] == $_SESSION['user']['id']);
            ?>
                <tr>
                    <td style="color:#aaa;"><?= $stt++ ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <?php if (!empty($u['avatar'])): ?>
                                <img src="<?= BASE_PATH ?>/<?= htmlspecialchars($u['avatar']) ?>"
                                     class="rounded-circle flex-shrink-0"
                                     style="width:34px;height:34px;object-fit:cover;border:2px solid #e9ecef;">
                            <?php else: ?>
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                     style="width:34px;height:34px;background:var(--accent);color:#fff;font-size:.85rem;">
                                    <?= strtoupper(substr($u['username'], 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                            <div>
                                <span class="fw-semibold d-block" style="font-size:.88rem;line-height:1.2;">
                                    <?= htmlspecialchars($u['username']) ?>
                                </span>
                                <?php if ($isSelf): ?>
                                    <span style="font-size:.7rem;background:#e3f0ff;color:var(--accent);border-radius:10px;padding:1px 7px;font-weight:700;">Bạn</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:.85rem;color:#555;"><?= htmlspecialchars($u['email']) ?></td>
                    <td>
                        <?= ($u['role_name'] ?? '') === 'admin'
                            ? '<span class="badge-admin">Admin</span>'
                            : '<span class="badge-member">Thành viên</span>' ?>
                    </td>
                    <td>
                        <?= $u['status'] == 1
                            ? '<span class="badge-active">Hoạt động</span>'
                            : '<span class="badge-banned">Bị khoá</span>' ?>
                    </td>
                    <td style="font-size:.82rem;color:#888;white-space:nowrap;">
                        <?= $u['created_at'] ? date('d/m/Y', strtotime($u['created_at'])) : '—' ?>
                    </td>
                    <td>
                        <?php if (!$isSelf): ?>
                        <div class="d-flex gap-1 align-items-center">
                            <!-- Ban / Unban -->
                            <form method="POST"
                                  action="<?= BASE_PATH ?>/admin/users/toggle/<?= $u['id'] ?>"
                                  onsubmit="return confirm('<?= $u['status'] == 1 ? 'Khoá' : 'Mở khoá' ?> tài khoản này?')">
                                <?= csrf_field() ?>
                                <input type="hidden" name="status" value="<?= $u['status'] == 1 ? 0 : 1 ?>">
                                <button type="submit"
                                        class="<?= $u['status'] == 1 ? 'btn-srt-danger' : 'btn-srt-primary' ?> btn-srt-sm"
                                        title="<?= $u['status'] == 1 ? 'Khoá tài khoản' : 'Mở khoá' ?>">
                                    <i class="fa-solid <?= $u['status'] == 1 ? 'fa-ban' : 'fa-unlock' ?>"></i>
                                </button>
                            </form>
                            <!-- Reset password -->
                            <button type="button"
                                    class="btn-srt-primary btn-srt-sm"
                                    style="background:#f59e0b;"
                                    title="Đặt lại mật khẩu"
                                    onclick="showResetModal(<?= $u['id'] ?>, '<?= addslashes(htmlspecialchars($u['username'])) ?>')">
                                <i class="fa-solid fa-key"></i>
                            </button>
                            <!-- Delete -->
                            <form method="POST"
                                  action="<?= BASE_PATH ?>/admin/users/delete/<?= $u['id'] ?>"
                                  onsubmit="return confirm('Xoá vĩnh viễn tài khoản <?= addslashes(htmlspecialchars($u['username'])) ?>?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-srt-danger btn-srt-sm" title="Xoá tài khoản">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        <?php else: ?>
                            <span style="color:#ccc;font-size:.8rem;">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if ($pages > 1): ?>
    <div style="padding:16px 20px;">
        <div class="srt-pagination">
            <?php if ($page > 1): ?>
                <a href="<?= BASE_PATH ?>/admin/users?page=<?= $page - 1 ?>"><i class="fa-solid fa-chevron-left"></i></a>
            <?php else: ?>
                <span class="disabled"><i class="fa-solid fa-chevron-left"></i></span>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <?php if ($i == $page): ?>
                    <span class="active"><?= $i ?></span>
                <?php elseif (abs($i - $page) <= 2 || $i == 1 || $i == $pages): ?>
                    <a href="<?= BASE_PATH ?>/admin/users?page=<?= $i ?>"><?= $i ?></a>
                <?php elseif (abs($i - $page) == 3): ?>
                    <span class="disabled">…</span>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($page < $pages): ?>
                <a href="<?= BASE_PATH ?>/admin/users?page=<?= $page + 1 ?>"><i class="fa-solid fa-chevron-right"></i></a>
            <?php else: ?>
                <span class="disabled"><i class="fa-solid fa-chevron-right"></i></span>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Reset Password Modal -->
<div class="modal fade" id="resetModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form method="POST" id="resetForm" action="">
                <?= csrf_field() ?>
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold">
                        <i class="fa-solid fa-key me-2" style="color:#f59e0b;"></i>Đặt lại mật khẩu
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-3">
                    <p class="text-muted small mb-3">
                        Đặt mật khẩu mới cho tài khoản: <strong id="resetUsername"></strong>
                    </p>
                    <label class="form-label fw-semibold small">
                        Mật khẩu mới <span class="text-danger">*</span>
                    </label>
                    <input type="password" name="new_password" id="resetPwdInput"
                           class="form-control rounded-3"
                           placeholder="Tối thiểu 6 ký tự" required minlength="6">
                    <div id="resetPwdError" class="text-danger small mt-1" style="display:none;">
                        Mật khẩu phải có ít nhất 6 ký tự.
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4"
                            data-bs-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn-srt-primary"
                            style="padding:8px 20px;border-radius:20px;">
                        <i class="fa-solid fa-check me-1"></i>Xác nhận
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showResetModal(userId, username) {
    document.getElementById('resetForm').action = '<?= BASE_PATH ?>/admin/users/reset-password/' + userId;
    document.getElementById('resetUsername').textContent = username;
    document.getElementById('resetPwdInput').value = '';
    document.getElementById('resetPwdError').style.display = 'none';
    new bootstrap.Modal(document.getElementById('resetModal')).show();
}

document.getElementById('resetForm').addEventListener('submit', function(e) {
    const pwd = document.getElementById('resetPwdInput').value;
    if (pwd.length < 6) {
        e.preventDefault();
        document.getElementById('resetPwdError').style.display = 'block';
    }
});
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
