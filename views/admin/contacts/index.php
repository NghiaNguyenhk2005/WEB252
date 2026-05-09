<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="srt-page-header">
    <div>
        <h4><i class="fa-solid fa-envelope me-2" style="color:var(--accent);"></i>Quản lý Liên hệ</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/contacts" class="text-decoration-none">Admin</a></li>
                <li class="breadcrumb-item active">Liên hệ</li>
            </ol>
        </nav>
    </div>
    <span class="srt-card-header" style="padding:6px 14px;background:#f8f9fc;border-radius:8px;border:1px solid #e9ecef;">
        Tổng: <strong><?= (int)$total ?></strong>liên hệ
    </span>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="srt-alert srt-alert-success"><i class="fa-solid fa-check-circle me-2"></i>Cập nhật trạng thái thành công.</div>
<?php endif; ?>
<?php if (isset($_GET['deleted'])): ?>
    <div class="srt-alert srt-alert-success"><i class="fa-solid fa-trash me-2"></i>Đã xoá liên hệ.</div>
<?php endif; ?>

<div class="srt-card">
    <div class="srt-card-header">
        <span><i class="fa-solid fa-list me-2"></i>Danh sách liên hệ</span>
    </div>
    <div class="srt-card-body" style="padding:0;">
        <div style="overflow-x:auto;">
        <table class="srt-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Người gửi</th>
                    <th>Email</th>
                    <th>Nội dung</th>
                    <th>Trạng thái</th>
                    <th>Ngày gửi</th>
                    <th style="width:160px;">Thao tác</th>
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
            <?php else:
                while ($c = $contacts->fetch_assoc()): ?>
                <tr>
                    <td style="color:#aaa;"><?= $stt++ ?></td>
                    <td><span class="fw-semibold" style="font-size:.88rem;"><?= htmlspecialchars($c['name']) ?></span></td>
                    <td>
                        <a href="mailto:<?= htmlspecialchars($c['email']) ?>" class="text-decoration-none" style="font-size:.85rem;color:var(--accent);">
                            <?= htmlspecialchars($c['email']) ?>
                        </a>
                    </td>
                    <td style="max-width:260px;">
                        <span style="font-size:.83rem;color:#555;">
                            <?= htmlspecialchars(mb_substr($c['message'], 0, 80)) ?><?= mb_strlen($c['message']) > 80 ? '…' : '' ?>
                        </span>
                        <br>
                        <button type="button" style="background:none;border:none;color:var(--accent);padding:0;font-size:.78rem;font-weight:600;cursor:pointer;"
                                onclick="showMessage(`<?= addslashes(htmlspecialchars($c['name'])) ?>`, `<?= addslashes(htmlspecialchars($c['message'])) ?>`)">
                            Xem đầy đủ
                        </button>
                    </td>
                    <td>
                        <?php
                        $statusMap = [
                            'new'     => ['label' => 'Mới',         'class' => 'badge-new'],
                            'read'    => ['label' => 'Đã đọc',      'class' => 'badge-read'],
                            'replied' => ['label' => 'Đã phản hồi', 'class' => 'badge-replied'],
                        ];
                        $s = $statusMap[$c['status']] ?? $statusMap['new'];
                        ?>
                        <span class="<?= $s['class'] ?>"><?= $s['label'] ?></span>
                    </td>
                    <td style="font-size:.82rem;color:#888;white-space:nowrap;">
                        <?= $c['created_at'] ? date('d/m/Y H:i', strtotime($c['created_at'])) : '—' ?>
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <!-- Status dropdown -->
                            <div class="dropdown">
                                <button class="btn-srt-primary btn-srt-sm dropdown-toggle" data-bs-toggle="dropdown" style="cursor:pointer;">
                                    <i class="fa-solid fa-tag"></i>
                                </button>
                                <ul class="dropdown-menu shadow border-0" style="font-size:.82rem;min-width:150px;">
                                    <?php foreach (['new' => 'Mới', 'read' => 'Đã đọc', 'replied' => 'Đã phản hồi'] as $val => $label): ?>
                                    <li>
                                        <form method="POST" action="/admin/contacts/update/<?= $c['id'] ?>">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="status" value="<?= $val ?>">
                                            <button type="submit" class="dropdown-item <?= $c['status'] === $val ? 'fw-bold' : '' ?>">
                                                <?= $c['status'] === $val ? '✓ ' : '' ?><?= $label ?>
                                            </button>
                                        </form>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <!-- Delete -->
                            <form method="POST" action="/admin/contacts/delete/<?= $c['id'] ?>"
                                  onsubmit="return confirm('Xác nhận xoá liên hệ này?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-srt-danger btn-srt-sm">
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

        <?php if ($pages > 1): ?>
        <div style="padding:16px 20px;">
            <div class="srt-pagination">
                <?php if ($page > 1): ?>
                    <a href="/admin/contacts?page=<?= $page - 1 ?>"><i class="fa-solid fa-chevron-left"></i></a>
                <?php else: ?>
                    <span class="disabled"><i class="fa-solid fa-chevron-left"></i></span>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <?php if ($i == $page): ?>
                        <span class="active"><?= $i ?></span>
                    <?php elseif (abs($i - $page) <= 2 || $i == 1 || $i == $pages): ?>
                        <a href="/admin/contacts?page=<?= $i ?>"><?= $i ?></a>
                    <?php elseif (abs($i - $page) == 3): ?>
                        <span class="disabled">…</span>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if ($page < $pages): ?>
                    <a href="/admin/contacts?page=<?= $page + 1 ?>"><i class="fa-solid fa-chevron-right"></i></a>
                <?php else: ?>
                    <span class="disabled"><i class="fa-solid fa-chevron-right"></i></span>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Full message modal -->
<div class="modal fade" id="msgModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" id="msgModalTitle"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-2" id="msgModalBody"
                 style="white-space:pre-wrap;font-size:.9rem;color:#444;line-height:1.7;max-height:400px;overflow-y:auto;"></div>
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
