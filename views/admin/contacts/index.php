<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="srt-page-header">
    <div>
        <h4><i class="fa-solid fa-envelope me-2" style="color:var(--accent);"></i>Quản lý Liên hệ</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider:'›';">
                <li class="breadcrumb-item">
                    <a href="<?= BASE_PATH ?>/admin/contacts" class="text-decoration-none" style="color:var(--accent);">Admin</a>
                </li>
                <li class="breadcrumb-item active" style="color:#888;">Liên hệ</li>
            </ol>
        </nav>
    </div>
    <div style="padding:6px 16px;background:#f0f4ff;border-radius:8px;border:1px solid #d0daf5;font-weight:700;font-size:.85rem;color:#333;">
        Tổng: <strong style="color:var(--accent);"><?= (int)$total ?></strong> liên hệ
    </div>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="srt-alert srt-alert-success"><i class="fa-solid fa-check-circle me-2"></i>Cập nhật thành công.</div>
<?php endif; ?>
<?php if (isset($_GET['deleted'])): ?>
    <div class="srt-alert srt-alert-success"><i class="fa-solid fa-trash me-2"></i>Đã xoá liên hệ.</div>
<?php endif; ?>

<div class="srt-card">
    <div class="srt-card-header">
        <span><i class="fa-solid fa-list me-2"></i>Danh sách liên hệ</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="srt-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Người gửi</th>
                    <th>Email</th>
                    <th>Nội dung</th>
                    <th style="width:130px;">Trạng thái</th>
                    <th style="width:130px;">Ngày gửi</th>
                    <th style="width:120px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $stt = ($page - 1) * 15 + 1;
            if ($contacts->num_rows === 0): ?>
                <tr>
                    <td colspan="7" class="text-center py-5" style="color:#aaa;">
                        <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i>Chưa có liên hệ nào.
                    </td>
                </tr>
            <?php else: while ($c = $contacts->fetch_assoc()): ?>
                <tr>
                    <td style="color:#aaa;"><?= $stt++ ?></td>
                    <td>
                        <span class="fw-semibold" style="font-size:.88rem;"><?= htmlspecialchars($c['name']) ?></span>
                    </td>
                    <td>
                        <a href="mailto:<?= htmlspecialchars($c['email']) ?>"
                           class="text-decoration-none" style="font-size:.85rem;color:var(--accent);">
                            <?= htmlspecialchars($c['email']) ?>
                        </a>
                    </td>
                    <td style="max-width:220px;">
                        <span style="font-size:.83rem;color:#555;display:block;margin-bottom:3px;">
                            <?= htmlspecialchars(mb_substr($c['message'], 0, 65)) ?><?= mb_strlen($c['message']) > 65 ? '…' : '' ?>
                        </span>
                        <button type="button"
                                style="background:none;border:none;color:var(--accent);padding:0;font-size:.78rem;font-weight:700;cursor:pointer;text-decoration:underline;"
                                onclick="showMessage(`<?= addslashes(htmlspecialchars($c['name'])) ?>`,`<?= addslashes(htmlspecialchars($c['message'])) ?>`)">
                            Xem đầy đủ
                        </button>
                    </td>
                    <td>
                        <?php
                        $sm = [
                            'new'     => ['Mới',         'badge-new'],
                            'read'    => ['Đã đọc',      'badge-read'],
                            'replied' => ['Đã phản hồi', 'badge-replied'],
                        ];
                        $s = $sm[$c['status']] ?? $sm['new'];
                        echo '<span class="' . $s[1] . '">' . $s[0] . '</span>';
                        ?>
                    </td>
                    <td style="font-size:.82rem;color:#888;white-space:nowrap;">
                        <?= $c['created_at'] ? date('d/m/Y H:i', strtotime($c['created_at'])) : '—' ?>
                    </td>
                    <td>
                        <div class="d-flex gap-1 align-items-center">
                            <!-- Status dropdown — using BS dropdown -->
                            <div class="dropdown">
                                <button type="button"
                                        class="btn-srt-primary btn-srt-sm"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        style="cursor:pointer;">
                                    <i class="fa-solid fa-tag"></i>
                                    <i class="fa-solid fa-chevron-down" style="font-size:.6rem;"></i>
                                </button>
                                <ul class="dropdown-menu shadow border-0" style="font-size:.82rem;min-width:155px;">
                                    <?php foreach (['new' => 'Mới', 'read' => 'Đã đọc', 'replied' => 'Đã phản hồi'] as $val => $label): ?>
                                    <li>
                                        <form method="POST" action="<?= BASE_PATH ?>/admin/contacts/update/<?= $c['id'] ?>">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="status" value="<?= $val ?>">
                                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 <?= $c['status'] === $val ? 'fw-bold' : '' ?>">
                                                <?php if ($c['status'] === $val): ?>
                                                    <i class="fa-solid fa-check text-success" style="width:14px;"></i>
                                                <?php else: ?>
                                                    <span style="width:14px;display:inline-block;"></span>
                                                <?php endif; ?>
                                                <?= $label ?>
                                            </button>
                                        </form>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <!-- Delete -->
                            <form method="POST" action="<?= BASE_PATH ?>/admin/contacts/delete/<?= $c['id'] ?>"
                                  onsubmit="return confirm('Xác nhận xoá liên hệ này?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-srt-danger btn-srt-sm" title="Xoá liên hệ">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
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
                <a href="<?= BASE_PATH ?>/admin/contacts?page=<?= $page - 1 ?>"><i class="fa-solid fa-chevron-left"></i></a>
            <?php else: ?>
                <span class="disabled"><i class="fa-solid fa-chevron-left"></i></span>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <?php if ($i == $page): ?>
                    <span class="active"><?= $i ?></span>
                <?php elseif (abs($i - $page) <= 2 || $i == 1 || $i == $pages): ?>
                    <a href="<?= BASE_PATH ?>/admin/contacts?page=<?= $i ?>"><?= $i ?></a>
                <?php elseif (abs($i - $page) == 3): ?>
                    <span class="disabled">…</span>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($page < $pages): ?>
                <a href="<?= BASE_PATH ?>/admin/contacts?page=<?= $page + 1 ?>"><i class="fa-solid fa-chevron-right"></i></a>
            <?php else: ?>
                <span class="disabled"><i class="fa-solid fa-chevron-right"></i></span>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Full message modal -->
<div class="modal fade" id="msgModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header pb-1" style="border-bottom:1px solid #f0f0f0;">
                <div>
                    <h6 class="modal-title fw-bold mb-0" id="msgModalTitle"></h6>
                    <small class="text-muted" id="msgModalDate"></small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="msgModalBody"
                 style="white-space:pre-wrap;font-size:.9rem;color:#444;line-height:1.7;max-height:400px;overflow-y:auto;">
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
function showMessage(name, message) {
    document.getElementById('msgModalTitle').textContent = 'Tin nhắn từ: ' + name;
    document.getElementById('msgModalBody').textContent  = message;
    new bootstrap.Modal(document.getElementById('msgModal')).show();
}
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
