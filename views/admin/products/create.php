<?php require_once 'views/admin/partials/header.php'; ?>

<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-8 col-ml-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Thêm sản phẩm mới</h4>
                    <form action="index.php?url=admin/products/store" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug (Để trống sẽ tự tạo)</label>
                            <input type="text" class="form-control" id="slug" name="slug">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Giá (VNĐ)</label>
                                    <input type="number" class="form-control" id="price" name="price" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock">Số lượng kho</label>
                                    <input type="number" class="form-control" id="stock" name="stock" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Danh mục</label>
                            <select class="form-control" id="category_id" name="category_id">
                                <?php if (isset($categories) && is_object($categories)): ?>
                                    <?php while($cat = $categories->fetch_assoc()): ?>
                                        <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Hình ảnh sản phẩm</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả sản phẩm</label>
                            <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Lưu sản phẩm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/admin/partials/footer.php'; ?>