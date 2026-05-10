<footer class="bg-dark text-white py-5 mt-5">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold mb-3"><?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?>.</h5>
                <p class="text-secondary">Nền tảng cung cấp giải pháp công nghệ tối ưu cho doanh nghiệp vừa và nhỏ tại Việt Nam.</p>
                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle p-2"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle p-2"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle p-2"><i class="bi bi-twitter-x"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold mb-3 text-uppercase small text-secondary">Sản phẩm</h6>
                <ul class="list-unstyled text-secondary">
                    <li class="mb-2"><a href="<?= BASE_PATH ?>/products" class="text-secondary text-decoration-none">Sản phẩm</a></li>
                    <li class="mb-2"><a href="<?= BASE_PATH ?>/services" class="text-secondary text-decoration-none">Dịch vụ</a></li>
                    <li class="mb-2"><a href="<?= BASE_PATH ?>/faqs" class="text-secondary text-decoration-none">FAQ</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3 text-uppercase small text-secondary">Công ty</h6>
                <ul class="list-unstyled text-secondary">
                    <li class="mb-2"><a href="#" class="text-secondary text-decoration-none">Về chúng tôi</a></li>
                    <li class="mb-2"><a href="<?= BASE_PATH ?>/news" class="text-secondary text-decoration-none">Tin tức</a></li>
                    <li class="mb-2"><a href="<?= BASE_PATH ?>/contact" class="text-secondary text-decoration-none">Liên hệ</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3 text-uppercase small text-secondary">Liên hệ</h6>
                <ul class="list-unstyled text-secondary">
                    <li class="mb-2"><i class="bi bi-telephone-fill me-2"></i><?= htmlspecialchars($globalSettings['company_phone'] ?? '0123 456 789') ?></li>
                    <li class="mb-2"><i class="bi bi-envelope-fill me-2"></i><?= htmlspecialchars($globalSettings['company_email'] ?? 'contact@techsaas.vn') ?></li>
                    <li class="mb-2"><i class="bi bi-geo-alt-fill me-2"></i><?= htmlspecialchars($globalSettings['company_address'] ?? 'Quận 1, TP. Hồ Chí Minh') ?></li>
                </ul>
            </div>
        </div>
        <div class="border-top border-secondary mt-4 pt-4 text-center text-secondary">
            <small>&copy; <?= date('Y') ?> <?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?>. All rights reserved.</small>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 800, once: true, offset: 100 });

// AJAX Search
const searchInput    = document.getElementById('ajax-search-input');
const searchDropdown = document.getElementById('search-results-dropdown');
if (searchInput) {
    searchInput.addEventListener('input', function() {
        const keyword = this.value.trim();
        if (keyword.length < 2) { searchDropdown.classList.remove('show'); return; }
        fetch(`<?= BASE_PATH ?>/api/search?keyword=${encodeURIComponent(keyword)}`)
            .then(r => r.json())
            .then(data => {
                if (!data.length) {
                    searchDropdown.innerHTML = '<div class="p-3 text-center text-muted small">Không tìm thấy kết quả</div>';
                } else {
                    searchDropdown.innerHTML = data.map(item => {
                        const url = item.type === 'product'
                            ? `<?= BASE_PATH ?>/product/${item.slug}`
                            : `<?= BASE_PATH ?>/news/${item.slug}`;
                        return `<a href="${url}" class="dropdown-item d-flex align-items-center p-3 border-bottom">
                            <img src="${item.image || '<?= BASE_PATH ?>/assets/client/img/dashboard.jpg'}"
                                 width="40" height="40" class="rounded me-3" style="object-fit:cover;">
                            <div>
                                <p class="mb-0 fw-bold small">${item.name}</p>
                                <span class="badge bg-light text-primary" style="font-size:.7rem;">${item.type === 'product' ? 'Sản phẩm' : 'Tin tức'}</span>
                            </div>
                        </a>`;
                    }).join('');
                }
                searchDropdown.classList.add('show');
            }).catch(() => searchDropdown.classList.remove('show'));
    });
    document.addEventListener('click', e => {
        if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
            searchDropdown.classList.remove('show');
        }
    });
}

// AJAX Add to Cart
document.querySelectorAll('.ajax-add-to-cart').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('<?= BASE_PATH ?>/cart/add', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.error === 'login_required') {
                window.location.href = '<?= BASE_PATH ?>/login'; return;
            }
            if (data.success) {
                const badge = document.getElementById('cart-badge');
                if (badge) { badge.textContent = data.cart_count; badge.style.display = 'inline'; }
                const btn = this.querySelector('button[type=submit]');
                if (btn) {
                    const orig = btn.innerHTML;
                    btn.innerHTML = '<i class="bi bi-check2"></i>';
                    btn.classList.replace('btn-primary', 'btn-success');
                    setTimeout(() => { btn.innerHTML = orig; btn.classList.replace('btn-success', 'btn-primary'); }, 2000);
                }
            }
        });
    });
});
</script>
</body>
</html>
