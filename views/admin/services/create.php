<?php require_once 'views/admin/partials/header.php'; ?>

<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-8 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Thêm Dịch vụ mới</h4>
                    <form action="index.php?url=admin/services/store" method="POST">
                        <div class="form-group">
                            <label>Tên dịch vụ</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" class="form-control" name="slug">
                        </div>
                        <div class="form-group">
                            <label>Bootstrap Icon Class (Ví dụ: bi-shield-lock)</label>
                            <input type="text" class="form-control" name="icon" value="bi-cpu">
                        </div>
                        <div class="form-group">
                            <label>Mô tả ngắn</label>
                            <input type="text" class="form-control" name="short_description" required>
                        </div>
                        <div class="form-group">
                            <label>Nội dung chi tiết (HTML)</label>
                            <textarea class="form-control" name="detailed_content" rows="10"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Lưu dịch vụ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/admin/partials/footer.php'; ?>