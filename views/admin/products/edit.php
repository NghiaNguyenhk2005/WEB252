<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="srt-page-header">
    <div>
        <h4>
            <i class="fa-solid fa-pen me-2" style="color:var(--accent);"></i>
            Chỉnh sửa sản phẩm
        </h4>
    </div>
</div>

<div class="srt-card">
    <div class="srt-card-header">
        <span>
            <i class="fa-solid fa-box-open me-2"></i>
            Thông tin sản phẩm
        </span>
    </div>

    <div style="padding:24px;">

    <form
        action="<?= BASE_PATH ?>/admin/products/update"
        method="POST"
        enctype="multipart/form-data"
    >
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= $product['id'] ?>">

            <div class="mb-3">
                <label class="form-label">Tên sản phẩm</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="<?= htmlspecialchars($product['name']) ?>"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input
                    type="text"
                    name="slug"
                    class="form-control"
                    value="<?= htmlspecialchars($product['slug']) ?>"
                >
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Giá</label>
                    <input
                        type="number"
                        name="price"
                        class="form-control"
                        value="<?= $product['price'] ?>"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tồn kho</label>
                    <input
                        type="number"
                        name="stock"
                        class="form-control"
                        value="<?= $product['stock'] ?>"
                    >
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Danh mục</label>
                <select name="category_id" class="form-control">
                    <?php foreach($categories as $cat): ?>
                        <option 
                            value="<?= $cat['id'] ?>"
                            <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>
                        >
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Ảnh hiện tại</label>
                <div class="mb-2">
                    <?php if(!empty($product['image']) && file_exists($product['image'])): ?>
                        <img
                            src="<?= BASE_PATH ?>/<?= htmlspecialchars($product['image']) ?>"
                            width="120"
                            class="rounded-3 border"
                            style="object-fit:cover;"
                        >
                    <?php else: ?>
                        <img
                            src="<?= BASE_PATH ?>/assets/client/img/dashboard.jpg"
                            width="120"
                            class="rounded-3 border"
                            style="object-fit:cover;"
                        >
                    <?php endif; ?>
                </div>
                <input
                    type="file"
                    name="image"
                    class="form-control"
                >
                <small class="text-muted">Để trống nếu không muốn thay đổi ảnh</small>
            </div>

            <div class="mb-4">
                <label class="form-label">Mô tả</label>
                <textarea
                    name="description"
                    class="form-control"
                    rows="5"
                ><?= htmlspecialchars($product['description']) ?></textarea>
            </div>

            <button type="submit" class="btn-srt-primary">
                <i class="fa-solid fa-floppy-disk me-2"></i>
                Cập nhật sản phẩm
            </button>
            
            <a href="<?= BASE_PATH ?>/admin/products" class="btn-srt-secondary ms-2">
                <i class="fa-solid fa-arrow-left me-2"></i>
                Quay lại
            </a>
        </form>

    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>