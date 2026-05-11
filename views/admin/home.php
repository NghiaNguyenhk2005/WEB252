<?php include __DIR__ . '/partials/header.php'; ?>

<?php
// ── Safe DB queries for stats ─────────────────────────────
$db_conn = $GLOBALS['conn'] ?? null;

function safeCount($conn, $sql) {
    if (!$conn) return 0;
    $r = $conn->query($sql);
    if (!$r) return 0;
    $row = $r->fetch_row();
    return (int)($row[0] ?? 0);
}
function safeSum($conn, $sql) {
    if (!$conn) return 0;
    $r = $conn->query($sql);
    if (!$r) return 0;
    $row = $r->fetch_row();
    return (float)($row[0] ?? 0);
}

$totalUsers     = safeCount($db_conn, "SELECT COUNT(*) FROM users WHERE deleted_at IS NULL");
$totalProducts  = safeCount($db_conn, "SELECT COUNT(*) FROM products WHERE deleted_at IS NULL");
$totalOrders    = safeCount($db_conn, "SELECT COUNT(*) FROM orders WHERE deleted_at IS NULL");
$pendingOrders  = safeCount($db_conn, "SELECT COUNT(*) FROM orders WHERE status='pending'");
$totalRevenue   = safeSum($db_conn,   "SELECT SUM(total_price) FROM orders WHERE status='completed'");
$newContacts    = safeCount($db_conn, "SELECT COUNT(*) FROM contacts WHERE status='new'");
$pendingFaqs    = safeCount($db_conn, "SELECT COUNT(*) FROM faqs WHERE status='pending'");
$totalPosts     = safeCount($db_conn, "SELECT COUNT(*) FROM posts WHERE deleted_at IS NULL");

// Recent orders
$recentOrders = null;
if ($db_conn) {
    $recentOrders = $db_conn->query(
        "SELECT o.id, o.total_price, o.status, o.created_at, u.username
         FROM orders o
         LEFT JOIN users u ON o.user_id = u.id
         WHERE o.deleted_at IS NULL
         ORDER BY o.created_at DESC
         LIMIT 8"
    );
}

// Recent contacts
$recentContacts = null;
if ($db_conn) {
    $recentContacts = $db_conn->query(
        "SELECT id, name, email, status, created_at
         FROM contacts
         ORDER BY created_at DESC
         LIMIT 6"
    );
}
?>

<!-- ── Welcome Banner ────────────────────────────────────── -->
<div class="srt-welcome mb-4">
    <h4>Chào mừng trở lại, <?= htmlspecialchars($_SESSION['user']['username'] ?? 'Admin') ?>! 👋</h4>
    <p>
        Hôm nay có
        <strong><?= $pendingOrders ?></strong> đơn hàng chờ xử lý,
        <strong><?= $newContacts ?></strong> liên hệ mới
        <?php if ($pendingFaqs > 0): ?>
            và <strong><?= $pendingFaqs ?></strong> câu hỏi FAQ đang chờ trả lời.
        <?php else: ?>
            và không có câu hỏi FAQ nào chờ.
        <?php endif; ?>
    </p>
</div>

<!-- ── Stat Cards ────────────────────────────────────────── -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="dash-stat-card primary">
            <div class="dash-stat-icon primary"><i class="fa-solid fa-money-bill-wave"></i></div>
            <div>
                <div class="dash-stat-label">Doanh thu tích lũy</div>
                <div class="dash-stat-value"><?= number_format($totalRevenue, 0, ',', '.') ?>đ</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="dash-stat-card success">
            <div class="dash-stat-icon success"><i class="fa-solid fa-box-open"></i></div>
            <div>
                <div class="dash-stat-label">Sản phẩm</div>
                <div class="dash-stat-value"><?= $totalProducts ?></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="dash-stat-card info">
            <div class="dash-stat-icon info"><i class="fa-solid fa-receipt"></i></div>
            <div>
                <div class="dash-stat-label">Tổng đơn hàng</div>
                <div class="dash-stat-value"><?= $totalOrders ?></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="dash-stat-card warning">
            <div class="dash-stat-icon warning"><i class="fa-solid fa-users"></i></div>
            <div>
                <div class="dash-stat-label">Thành viên</div>
                <div class="dash-stat-value"><?= $totalUsers ?></div>
            </div>
        </div>
    </div>
</div>

<!-- ── Second row stats ───────────────────────────────────── -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <a href="<?= BASE_PATH ?>/admin/orders" class="text-decoration-none">
            <div class="dash-stat-card danger" style="padding:14px 18px;cursor:pointer;">
                <div class="dash-stat-icon danger" style="width:40px;height:40px;font-size:1rem;">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div>
                    <div class="dash-stat-label">Đơn chờ xử lý</div>
                    <div class="dash-stat-value" style="font-size:1.3rem;"><?= $pendingOrders ?></div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-6">
        <a href="<?= BASE_PATH ?>/admin/contacts" class="text-decoration-none">
            <div class="dash-stat-card info" style="padding:14px 18px;cursor:pointer;">
                <div class="dash-stat-icon info" style="width:40px;height:40px;font-size:1rem;">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div>
                    <div class="dash-stat-label">Liên hệ mới</div>
                    <div class="dash-stat-value" style="font-size:1.3rem;"><?= $newContacts ?></div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-6">
        <a href="<?= BASE_PATH ?>/admin/posts" class="text-decoration-none">
            <div class="dash-stat-card success" style="padding:14px 18px;cursor:pointer;">
                <div class="dash-stat-icon success" style="width:40px;height:40px;font-size:1rem;">
                    <i class="fa-solid fa-newspaper"></i>
                </div>
                <div>
                    <div class="dash-stat-label">Bài viết</div>
                    <div class="dash-stat-value" style="font-size:1.3rem;"><?= $totalPosts ?></div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-6">
        <a href="<?= BASE_PATH ?>/admin/faqs" class="text-decoration-none">
            <div class="dash-stat-card warning" style="padding:14px 18px;cursor:pointer;">
                <div class="dash-stat-icon warning" style="width:40px;height:40px;font-size:1rem;">
                    <i class="fa-solid fa-circle-question"></i>
                </div>
                <div>
                    <div class="dash-stat-label">FAQ chờ duyệt</div>
                    <div class="dash-stat-value" style="font-size:1.3rem;"><?= $pendingFaqs ?></div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- ── Main content row ──────────────────────────────────── -->
<div class="row g-4">

    <!-- Recent Orders -->
    <div class="col-lg-7">
        <div class="srt-card h-100">
            <div class="srt-card-header">
                <span><i class="fa-solid fa-receipt me-2" style="color:var(--accent);"></i>Đơn hàng gần đây</span>
                <a href="<?= BASE_PATH ?>/admin/orders" class="btn-srt-primary btn-srt-sm text-decoration-none">
                    Xem tất cả <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div style="overflow-x:auto;">
                <table class="srt-table">
                    <thead>
                        <tr>
                            <th style="width:60px;">Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Số tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($recentOrders && $recentOrders->num_rows > 0): ?>
                        <?php while ($order = $recentOrders->fetch_assoc()):
                            $statusMap = [
                                'pending'   => ['Chờ xử lý',  'badge-pending'],
                                'paid'      => ['Đã thanh toán','badge-active'],
                                'shipping'  => ['Đang giao',  'badge-shipping'],
                                'completed' => ['Hoàn thành', 'badge-completed'],
                                'cancelled' => ['Đã huỷ',    'badge-banned'],
                            ];
                            $st = $statusMap[$order['status']] ?? ['Không rõ', 'badge-member'];
                        ?>
                        <tr>
                            <td><span class="fw-bold" style="color:var(--accent);">#<?= $order['id'] ?></span></td>
                            <td style="font-size:.87rem;"><?= htmlspecialchars($order['username'] ?? 'Khách') ?></td>
                            <td style="font-size:.87rem;font-weight:700;color:#1a9c5b;"><?= number_format($order['total_price'], 0, ',', '.') ?>đ</td>
                            <td><span class="<?= $st[1] ?>"><?= $st[0] ?></span></td>
                            <td style="font-size:.8rem;color:#888;white-space:nowrap;"><?= $order['created_at'] ? date('d/m/Y', strtotime($order['created_at'])) : '—' ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5" style="color:#aaa;">
                                <i class="fa-solid fa-receipt fa-2x mb-2 d-block" style="opacity:.3;"></i>
                                Chưa có đơn hàng nào.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Alerts + Recent Contacts -->
    <div class="col-lg-5">

        <!-- System alerts - Clean Version -->
        <?php if ($pendingOrders > 0 || $newContacts > 0 || $pendingFaqs > 0): ?>
        <div class="alerts-wrapper mb-4">
            <?php if ($pendingOrders > 0): ?>
                <div class="alert-card alert-order" onclick="window.location.href='<?= BASE_PATH ?>/admin/orders'">
                    <div class="alert-icon">📦</div>
                    <div class="alert-content">
                        <span class="alert-count"><?= $pendingOrders ?></span>
                        <span class="alert-text">đơn hàng chờ xử lý</span>
                    </div>
                    <div class="alert-arrow">→</div>
                </div>
            <?php endif; ?>
            
            <?php if ($newContacts > 0): ?>
                <div class="alert-card alert-contact" onclick="window.location.href='<?= BASE_PATH ?>/admin/contacts'">
                    <div class="alert-icon">✉️</div>
                    <div class="alert-content">
                        <span class="alert-count"><?= $newContacts ?></span>
                        <span class="alert-text">liên hệ mới</span>
                    </div>
                    <div class="alert-arrow">→</div>
                </div>
            <?php endif; ?>
            
            <?php if ($pendingFaqs > 0): ?>
                <div class="alert-card alert-faq" onclick="window.location.href='<?= BASE_PATH ?>/admin/faqs'">
                    <div class="alert-icon">❓</div>
                    <div class="alert-content">
                        <span class="alert-count"><?= $pendingFaqs ?></span>
                        <span class="alert-text">câu hỏi chờ trả lời</span>
                    </div>
                    <div class="alert-arrow">→</div>
                </div>
            <?php endif; ?>
        </div>

        <style>
        .alerts-wrapper {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .alert-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
            border-radius: 12px;
            padding: 16px 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }

        .alert-card:hover {
            transform: translateX(5px);
            border-left: 4px solid;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .alert-order:hover { border-left-color: #f59e0b; }
        .alert-contact:hover { border-left-color: #4e73df; }
        .alert-faq:hover { border-left-color: #1cc88a; }

        .alert-icon {
            font-size: 1.5rem;
        }

        .alert-content {
            flex: 1;
            margin-left: 15px;
        }

        .alert-count {
            font-size: 1.1rem;
            font-weight: 800;
            margin-right: 8px;
        }

        .alert-order .alert-count { color: #f59e0b; }
        .alert-contact .alert-count { color: #4e73df; }
        .alert-faq .alert-count { color: #1cc88a; }

        .alert-text {
            color: #666;
            font-size: 0.9rem;
        }

        .alert-arrow {
            color: #ccc;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .alert-card:hover .alert-arrow {
            transform: translateX(5px);
            color: var(--accent);
        }

        @media (max-width: 768px) {
            .alert-card {
                padding: 12px 16px;
            }
            
            .alert-icon {
                font-size: 1.2rem;
            }
            
            .alert-count {
                font-size: 1rem;
            }
            
            .alert-text {
                font-size: 0.8rem;
            }
        }
        </style>
        <?php endif; ?>

        <!-- Recent contacts -->
        <div class="srt-card">
            <div class="srt-card-header">
                <span><i class="fa-solid fa-envelope me-2" style="color:var(--accent);"></i>Liên hệ mới nhất</span>
                <a href="<?= BASE_PATH ?>/admin/contacts" class="btn-srt-primary btn-srt-sm text-decoration-none">
                    Xem tất cả
                </a>
            </div>
            <div class="srt-card-body" style="padding:0;">
                <?php if ($recentContacts && $recentContacts->num_rows > 0): ?>
                    <?php while ($c = $recentContacts->fetch_assoc()): ?>
                    <div class="d-flex align-items-start gap-3 p-3" style="border-bottom:1px solid #f5f5f5;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                             style="width:36px;height:36px;background:#e3f0ff;color:var(--accent);font-size:.85rem;">
                            <?= strtoupper(substr($c['name'] ?: '?', 0, 1)) ?>
                        </div>
                        <div style="min-width:0;flex:1;">
                            <div class="fw-semibold" style="font-size:.85rem;"><?= htmlspecialchars($c['name']) ?></div>
                            <div style="font-size:.78rem;color:#888;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                <?= htmlspecialchars($c['email']) ?>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <?php
                            $sm2 = ['new'=>['Mới','badge-new'],'read'=>['Đọc','badge-read'],'replied'=>['Phản hồi','badge-replied']];
                            $s2  = $sm2[$c['status']] ?? $sm2['new'];
                            echo '<span class="'.$s2[1].'">'.$s2[0].'</span>';
                            ?>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="text-center py-4" style="color:#aaa;">
                        <i class="fa-solid fa-inbox fa-2x mb-2 d-block" style="opacity:.3;"></i>
                        Chưa có liên hệ nào.
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<!-- ── Quick Links ────────────────────────────────────────── -->
<div class="srt-card mt-2">
    <div class="srt-card-header">
        <span><i class="fa-solid fa-bolt me-2" style="color:#f59e0b;"></i>Truy cập nhanh</span>
    </div>
    <div class="srt-card-body">
        <div class="d-flex flex-wrap gap-2">
            <?php
            $quickLinks = [
                ['/admin/products/create', 'fa-plus',           'Thêm sản phẩm',  'primary'],
                ['/admin/posts/create',    'fa-file-pen',        'Đăng bài viết',  'primary'],
                ['/admin/settings',        'fa-gear',            'Cài đặt và quản lí slider',        'secondary'],
                ['/admin/users',           'fa-users',           'Người dùng',     'secondary'],
                //['/admin/sliders',         'fa-images',          'Quản lý slider', 'secondary'],
                ['/admin/faqs',            'fa-circle-question', 'FAQ',            'secondary'],
            ];
            foreach ($quickLinks as [$href, $icon, $label, $type]):
            ?>
                <a href="<?= BASE_PATH . $href ?>" class="btn-srt-<?= $type ?> text-decoration-none" style="padding:8px 16px;border-radius:8px;">
                    <i class="fa-solid <?= $icon ?>"></i> <?= $label ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
