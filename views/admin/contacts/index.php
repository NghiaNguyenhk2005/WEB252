<?php 
require_once "views/admin/partials/header.php"; 
require_once "views/admin/partials/sidebar.php"; 
?>

<div class="main-content">
    <div class="main-content-inner">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Quản lý liên hệ</h4>
                        
                        <!-- Success Alert for better UX[cite: 10] -->
                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Thành công!</strong> Trạng thái đã được cập nhật.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span class="fa fa-times"></span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <div class="single-table">
                            <div class="table-responsive">
                                <table class="table table-hover text-center">
                                    <thead class="text-uppercase bg-light">
                                        <tr>
                                            <th>Ngày gửi</th>
                                            <th>Họ tên</th>
                                            <th>Email</th>
                                            <th>Nội dung</th>
                                            <th>Trạng thái</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Changed variable to $contacts to match Controller[cite: 10] -->
                                        <?php while($row = $contacts->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                                            <td><?= htmlspecialchars($row['full_name']) ?></td>
                                            <td><?= htmlspecialchars($row['email']) ?></td>
                                            <td class="text-left"><?= mb_strimwidth($row['message'], 0, 50, "...") ?></td>
                                            <td>
                                                <!-- Updated logic for string-based status[cite: 10] -->
                                                <span class="badge <?= $row['status'] === 'read' ? 'badge-success' : 'badge-warning' ?>">
                                                    <?= $row['status'] === 'read' ? 'Đã đọc' : 'Mới' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <?php if($row['status'] !== 'read'): ?>
                                                        <!-- POST Form for Security[cite: 10] -->
                                                        <form action="/admin/contacts/update/<?= $row['id'] ?>" method="POST" class="mr-2">
                                                            <input type="hidden" name="status" value="read">
                                                            <button type="submit" class="btn btn-xs btn-success" title="Đánh dấu đã đọc">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>

                                                    <!-- Delete button using the route in your index.php[cite: 10] -->
                                                    <a href="/admin/contacts/delete/<?= $row['id'] ?>" 
                                                       class="btn btn-xs btn-danger" 
                                                       onclick="return confirm('Bạn có chắc chắn muốn xóa liên hệ này?')"
                                                       title="Xóa">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "views/admin/partials/footer.php"; ?>