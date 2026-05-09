<?php require_once 'views/admin/partials/header.php'; ?>

<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-10 mt-5 mx-auto">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h4 class="header-title mb-4">Viết bài mới</h4>
                    <form action="index.php?url=admin/posts/store" method="POST" enctype="multipart/form-data">
                        <div class="form-group mb-4">
                            <label class="fw-bold">Tiêu đề bài viết</label>
                            <input type="text" class="form-control" name="title" placeholder="Nhập tiêu đề hấp dẫn..." required>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="fw-bold">Slug (Tự động nếu để trống)</label>
                                <input type="text" class="form-control" name="slug">
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold">Ảnh đại diện bài viết</label>
                                <input type="file" class="form-control-file" name="thumbnail">
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label class="fw-bold">Nội dung bài viết (Hỗ trợ HTML)</label>
                            <textarea class="form-control" name="content" rows="15" placeholder="Nội dung bài viết chi tiết tại đây..."></textarea>
                        </div>
                        <div class="text-right">
                            <a href="index.php?url=admin/posts" class="btn btn-light rounded-pill px-4 mr-2">Hủy bỏ</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 shadow">Xuất bản bài viết</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/admin/partials/footer.php'; ?>