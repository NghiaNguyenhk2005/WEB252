<footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold mb-3">TechSaaS.</h5>
                    <p class="text-secondary">Nền tảng cung cấp giải pháp công nghệ tối ưu cho doanh nghiệp vừa và nhỏ tại Việt Nam. Giúp tự động hoá quy trình và bảo mật dữ liệu.</p>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="mb-3">Sản phẩm</h5>
                    <ul class="list-unstyled text-secondary">
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none hover-white">Tính năng</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none hover-white">Bảng giá</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none hover-white">Tài liệu API</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-3">Công ty</h5>
                    <ul class="list-unstyled text-secondary">
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none hover-white">Về chúng tôi</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none hover-white">Tuyển dụng</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none hover-white">Hỏi đáp (FAQ)</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-3">Liên hệ</h5>
                    <ul class="list-unstyled text-secondary">
                    <!-- Dynamic Contact Info -->
                        <li class="mb-2">
                            <i class="bi bi-telephone-fill me-2"></i>
                            <?= htmlspecialchars($globalSettings['company_phone'] ?? '0123 456 789') ?>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-envelope-fill me-2"></i>
                            <?= htmlspecialchars($globalSettings['company_email'] ?? 'contact@techsaas.vn') ?>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-geo-alt-fill me-2"></i>
                            <?= htmlspecialchars($globalSettings['company_address'] ?? 'Quận 1, TP. Hồ Chí Minh') ?>
                        </li>
                </ul>
                </div>
            </div>
            <div class="border-top border-secondary mt-4 pt-4 text-center text-secondary">
                <small>&copy; 2026 TechSaaS. All rights reserved.</small>
            </div>
        </div>
    </footer>

    <!-- Nhúng Javascript Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Nhúng Javascript AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // AJAX Search Script
        const searchInput = document.getElementById('ajax-search-input');
        const searchDropdown = document.getElementById('search-results-dropdown');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const keyword = this.value;
                if (keyword.length >= 2) {
                    fetch(`index.php?url=api/search&keyword=${keyword}`)
                        .then(response => response.json())
                        .then(data => {
                            let html = '';
                            if (data.length > 0) {
                                data.forEach(item => {
                                    const url = item.type === 'product' ? `index.php?url=product/${item.slug}` : `index.php?url=news/${item.slug}`;
                                    html += `
                                        <a href="${url}" class="dropdown-item d-flex align-items-center p-3 border-bottom">
                                            <img src="${item.image || 'assets/client/img/dashboard.jpg'}" width="40" height="40" class="rounded me-3" style="object-fit: cover;">
                                            <div>
                                                <p class="mb-0 fw-bold small">${item.name}</p>
                                                <span class="badge bg-light text-primary extra-small">${item.type === 'product' ? 'Sản phẩm' : 'Tin tức'}</span>
                                            </div>
                                        </a>
                                    `;
                                });
                                searchDropdown.innerHTML = html;
                                searchDropdown.classList.add('show');
                            } else {
                                searchDropdown.innerHTML = '<div class="p-3 text-center text-muted small">Không tìm thấy kết quả</div>';
                                searchDropdown.classList.add('show');
                            }
                        });
                } else {
                    searchDropdown.classList.remove('show');
                }
            });

            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
                    searchDropdown.classList.remove('show');
                }
            });
        }
        // AJAX Add to Cart
        document.querySelectorAll('form[action="index.php?url=cart/add"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                
                fetch('index.php?url=cart/add', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-WITH': 'XMLHttpRequest' }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error === 'login_required') {
                        window.location.href = 'index.php?url=login';
                        return;
                    }
                    if (data.success) {
                        // Create or update badge
                        let badge = document.querySelector('.nav-link .badge.bg-danger');
                        if (!badge) {
                            const cartIcon = document.querySelector('.bi-cart3').parentElement;
                            cartIcon.innerHTML += `<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">${data.cart_count}</span>`;
                        } else {
                            badge.innerText = data.cart_count;
                        }
                        
                        // Small toast or visual feedback
                        const btn = form.querySelector('button');
                        const originalContent = btn.innerHTML;
                        btn.innerHTML = '<i class="bi bi-check2"></i>';
                        btn.classList.replace('btn-primary', 'btn-success');
                        setTimeout(() => {
                            btn.innerHTML = originalContent;
                            btn.classList.replace('btn-success', 'btn-primary');
                        }, 2000);
                    }
                });
            });
        });
    </script>
</body>
</html>