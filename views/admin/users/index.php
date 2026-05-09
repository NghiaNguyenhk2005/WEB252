<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="srt-page-header">
    <div>
        <h4><i class="fa-solid fa-users me-2" style="color:var(--accent);"></i>Quản lý Người dùng</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/contacts" class="text-decoration-none">Admin</a></li>
                <li class="breadcrumb-item active">Người dùng</li>
            </ol>
        </nav>
    </div>
    <span class="srt-card-header" style="padding:6px 14px;background:#f8f9fc;border-radius:8px;border:1px solid #e9ecef;">
        Tổng: <strong><?= (int)$total ?></strong> tài khoản
    </span>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="srt-alert srt-alert-success"><i class="fa-solid fa-check-circle me-2"></i>Cập nhật thành công.</div>
<?php endif; ?>
<?php if (isset($_GET['deleted'])): ?>
    <div class="srt-alert srt-alert-success"><i class="fa-solid fa-trash me-2"></i>Đã xoá người dùng.</div>
<?php endif; ?>
<?php if (isset($_GET['reset'])): ?>
    <div class="srt-alert srt-alert-success"><i class="fa-solid fa-key me-2"></i>Đã đặt lại mật khẩu.</div>
<?php endif; ?>
<?php if (isset($_GET['error']) && $_GET['error'] === 'password_short'): ?>
    <div class="srt-alert srt-alert-danger"><i class="fa-solid fa-exclamation-circle me-2"></i>Mật khẩu phải có ít nhất 6 ký tự.</div>
<?php endif; ?>

<div class="srt-card">
    <div class="srt-card-header">
        <span><i class="fa-solid fa-list me-2"></i>Danh sách tài khoản</span>
    </div>
    <div class="srt-card-body" style="padding:0;">
        <div style="overflow-x:auto;">
        <table class="srt-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Tên / Avatar</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th style="width:150px;">Thao tác</th>
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
            <?php else:
                while ($u = $users->fetch_assoc()):
                    $isSelf = ($u['id'] == $_SESSION['user']['id']);
            ?>
                <tr>
                    <td style="color:#aaa;"><?= $stt++ ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <?php if (!empty($u['avatar'])): ?>
                                <img src="/<?= htmlspecialchars($u['avatar']) ?>"
                                     class="rounded-circle"
                                     style="width:34px;height:34px;object-fit:cover;border:2px solid #e9ecef;flex-shrink:0;">
                            <?php else: ?>
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                     style="width:34px;height:34px;background:var(--accent);color:#fff;font-size:.85rem;flex-shrink:0;">
                                    <?= strtoupper(substr($u['username'], 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                            <span class="fw-semibold" style="font-size:.88rem;">
                                <?= htmlspecialchars($u['username']) ?>
                                <?php if ($isSelf): ?>
                                    <span style="font-size:.72rem;background:#e3f0ff;color:var(--accent);border-radius:10px;padding:1px 7px;font-weight:700;margin-left:4px;">Bạn</span>
                                <?php endif; ?>
                            </span>
                        </div>
                    </td>
                    <td style="font-size:.85rem;color:#555;"><?= htmlspecialchars($u['email']) ?></td>
                    <td>
                        <?php if (($u['role_name'] ?? '') === 'admin'): ?>
                            <span class="badge-admin">Admin</span>
                        <?php else: ?>
                            <span class="badge-member">Thành viên</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($u['status'] == 1): ?>
                            <span class="badge-active">Hoạt động</span>
                        <?php else: ?>
                            <span class="badge-banned">Bị khoá</span>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:.82rem;color:#888;white-space:nowrap;">
                        <?= $u['created_at'] ? date('d/m/Y', strtotime($u['created_at'])) : '—' ?>
                    </td>
                    <td>
                        <?php if (!$isSelf): ?>
                        <div class="d-flex gap-1 flex-wrap">
                            <!-- Ban / Unban -->
                            <form method="POST" action="/admin/users/toggle/<?= $u['id'] ?>"
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
                            <button type="button" class="btn-srt-primary btn-srt-sm"
                                    style="background:#f59e0b;" title="Đặt lại mật khẩu"
                                    onclick="showResetModal(<?= $u['id'] ?>, '<?= addslashes(htmlspecialchars($u['username'])) ?>')">
                                <i class="fa-solid fa-key"></i>
                            </button>
                            <!-- Delete -->
                            <form method="POST" action="/admin/users/delete/<?= $u['id'] ?>"
                                  onsubmit="return confirm('Xoá vĩnh viễn tài khoản <?= addslashes(htmlspecialchars($u['username'])) ?>?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-srt-danger btn-srt-sm">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        <?php else: ?>
                            <span style="color:#aaa;font-size:.8rem;font-style:italic;">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; endif; ?>
            </tbody>
        </table>
        </div>

        <?php if ($pages > 1): ?>
        <div style="padding:16px 20px;">
            <div class="srt-pagination">
                <?php if ($page > 1): ?>
                    <a href="/admin/users?page=<?= $page - 1 ?>"><i class="fa-solid fa-chevron-left"></i></a>
                <?php else: ?>
                    <span class="disabled"><i class="fa-solid fa-chevron-left"></i></span>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <?php if ($i == $page): ?>
                        <span class="active"><?= $i ?></span>
                    <?php elseif (abs($i - $page) <= 2 || $i == 1 || $i == $pages): ?>
                        <a href="/admin/users?page=<?= $i ?>"><?= $i ?></a>
                    <?php elseif (abs($i - $page) == 3): ?>
                        <span class="disabled">…</span>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if ($page < $pages): ?>
                    <a href="/admin/users?page=<?= $page + 1 ?>"><i class="fa-solid fa-chevron-right"></i></a>
                <?php else: ?>
                    <span class="disabled"><i class="fa-solid fa-chevron-right"></i></span>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Reset Password Modal -->
<div class="modal fade" id="resetModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
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
                    <p class="text-muted small mb-3">Đặt mật khẩu mới cho: <strong id="resetUsername"></strong></p>
                    <label class="form-label fw-semibold small">Mật khẩu mới <span class="text-danger">*</span></label>
                    <input type="password" name="new_password" class="form-control rounded-3"
                           placeholder="Tối thiểu 6 ký tự" required minlength="6">
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn-srt-primary" style="padding:8px 20px;border-radius:20px;">
                        <i class="fa-solid fa-check me-1"></i>Xác nhận
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showResetModal(userId, username) {
    document.getElementById('resetForm').action = '/admin/users/reset-password/' + userId;
    document.getElementById('resetUsername').textContent = username;
    new bootstrap.Modal(document.getElementById('resetModal')).show();
}
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
