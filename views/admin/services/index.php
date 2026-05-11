<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="srt-page-header">
    <div>
        <h4><i class="fa-solid fa-handshake me-2" style="color:var(--accent);"></i>Quản lý Dịch vụ</h4>
    </div>
    <a href="<?= BASE_PATH ?>/admin/services/create" class="btn-srt-primary text-decoration-none">
        <i class="fa-solid fa-plus"></i> Thêm dịch vụ
    </a>
</div>

<div class="srt-card">
    <div class="srt-card-header">
        <span><i class="fa-solid fa-list me-2"></i>Danh sách dịch vụ</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="srt-table">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th style="width:60px;text-align:center;">Icon</th>
                    <th>Tên dịch vụ</th>
                    <th>Mô tả ngắn</th>
                    <th style="width:90px;">Trạng thái</th>
                    <th style="width:120px;text-align:center;">Hành động</th>
                </tr>
            </thead>
            <tbody>
            <?php if (isset($services) && is_object($services) && $services->num_rows > 0):
                while ($s = $services->fetch_assoc()): ?>
                <tr>
                    <td style="color:#aaa;"><?= $s['id'] ?></td>
                    <td style="text-align:center;">
                        <i class="bi <?= htmlspecialchars($s['icon'] ?? 'bi-gear') ?> fs-5 text-primary"></i>
                    </td>
                    <td class="fw-semibold"><?= htmlspecialchars($s['name']) ?></td>
                    <td style="font-size:.83rem;color:#666;max-width:260px;">
                        <?= htmlspecialchars(mb_substr($s['short_description'] ?? '', 0, 80)) ?><?= mb_strlen($s['short_description'] ?? '') > 80 ? '…' : '' ?>
                    </td>
                    <td>
                        <?= ($s['status'] ?? 1) == 1
                            ? '<span class="badge-active">Hiện</span>'
                            : '<span class="badge-banned">Ẩn</span>' ?>
                    </td>
                    <td style="text-align:center;">
                        <div class="srt-actions" style="justify-content:center;">
                            <a href="<?= BASE_PATH ?>/admin/services/edit/<?= $s['id'] ?>"
                               class="btn-srt-warning btn-srt-sm text-decoration-none" title="Chỉnh sửa">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form method="POST"
                                  action="<?= BASE_PATH ?>/admin/services/delete/<?= $s['id'] ?>"
                                  onsubmit="return confirm('Xoá dịch vụ «<?= addslashes(htmlspecialchars($s['name'])) ?>»?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-srt-danger btn-srt-sm" title="Xoá">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endwhile; else: ?>
                <tr>
                    <td colspan="6" class="text-center py-5" style="color:#aaa;">
                        <i class="fa-solid fa-handshake fa-2x mb-2 d-block" style="opacity:.3;"></i>
                        Chưa có dịch vụ nào.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
