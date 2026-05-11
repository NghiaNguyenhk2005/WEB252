<footer class="bg-dark text-white py-5 mt-5">
    <div class="container">
        <div class="row gy-4 align-items-start">
            <!-- Company Info & Social Icons -->
            <div class="col-lg-4 col-md-12">
                <h5 class="fw-bold mb-3 text-white"><?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?>.</h5>
                <p class="text-white-50 small mb-3">Nền tảng cung cấp giải pháp công nghệ tối ưu cho doanh nghiệp vừa và nhỏ tại Việt Nam.</p>
                <div class="d-flex gap-2 mt-2">
                    <a href="https://facebook.com/techsaas.vn" class="social-icon" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://linkedin.com/company/techsaas" class="social-icon" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://twitter.com/techsaas" class="social-icon" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>
            
            <!-- Products Column -->
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold mb-3 text-uppercase small text-primary">SẢN PHẨM</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="<?= BASE_PATH ?>/products" class="footer-link text-white-50 text-decoration-none small">Sản phẩm</a></li>
                    <li class="mb-2"><a href="<?= BASE_PATH ?>/services" class="footer-link text-white-50 text-decoration-none small">Dịch vụ</a></li>
                    <li class="mb-2"><a href="<?= BASE_PATH ?>/faqs" class="footer-link text-white-50 text-decoration-none small">FAQ</a></li>
                </ul>
            </div>
            
            <!-- Company Column -->
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3 text-uppercase small text-primary">CÔNG TY</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="<?= BASE_PATH ?>/about" class="footer-link text-white-50 text-decoration-none small">Về chúng tôi</a></li>
                    <li class="mb-2"><a href="<?= BASE_PATH ?>/news" class="footer-link text-white-50 text-decoration-none small">Tin tức</a></li>
                    <li class="mb-2"><a href="<?= BASE_PATH ?>/contact" class="footer-link text-white-50 text-decoration-none small">Liên hệ</a></li>
                </ul>
            </div>
            
            <!-- Contact Column -->
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3 text-uppercase small text-primary">LIÊN HỆ</h6>
                <ul class="list-unstyled text-white-50 small">
                    <li class="mb-2 contact-item"><i class="fas fa-phone-alt me-2"></i> <?= htmlspecialchars($globalSettings['company_phone'] ?? '0123 456 789') ?></li>
                    <li class="mb-2 contact-item"><i class="fas fa-envelope me-2"></i> <?= htmlspecialchars($globalSettings['company_email'] ?? 'contact@techsaas.vn') ?></li>
                    <li class="mb-2 contact-item"><i class="fas fa-map-marker-alt me-2"></i> <?= htmlspecialchars($globalSettings['company_address'] ?? 'Quận 1, TP. Hồ Chí Minh') ?></li>
                </ul>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="border-top border-secondary mt-4 pt-4 text-center">
            <small class="text-white-50">&copy; <?= date('Y') ?> <?= htmlspecialchars($globalSettings['site_name'] ?? 'TechSaaS') ?>. All rights reserved.</small>
        </div>
    </div>
</footer>

<style>
/* Social Icons - Fixed Hover Animation */
.social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    color: white;
    font-size: 1rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
}

.social-icon:hover {
    background: #4361ee;
    color: white;
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
}

/* Footer Links - Fixed Hover Animation */
.footer-link {
    display: inline-block;
    transition: all 0.3s ease;
    position: relative;
}

.footer-link:hover {
    color: #4361ee !important;
    transform: translateX(5px);
}

/* Contact Items Hover */
.contact-item {
    transition: all 0.3s ease;
    cursor: pointer;
}

.contact-item:hover {
    color: #4361ee !important;
    transform: translateX(5px);
}

.contact-item:hover i {
    color: #4361ee;
}

/* Responsive Alignment */
@media (max-width: 768px) {
    footer {
        text-align: center;
    }
    
    .social-icon {
        margin: 0 5px;
    }
    
    .d-flex.gap-2 {
        justify-content: center;
    }
    
    .footer-link:hover {
        transform: translateX(0);
    }
    
    .contact-item:hover {
        transform: translateX(0);
    }
}

/* Tablet */
@media (min-width: 769px) and (max-width: 992px) {
    .col-lg-4, .col-lg-2, .col-lg-3 {
        margin-bottom: 30px;
    }
}
</style>

<!-- Scripts - PRESERVED (not removed) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 800, once: true, offset: 100 });

// AJAX Search
const searchInput = document.getElementById('ajax-search-input');
const searchDropdown = document.getElementById('search-results-dropdown');
if (searchInput) {
    searchInput.addEventListener('input', function() {
        const keyword = this.value.trim();
        if (keyword.length < 2) { 
            searchDropdown.classList.remove('show'); 
            return; 
        }
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
                window.location.href = '<?= BASE_PATH ?>/login'; 
                return;
            }
            if (data.success) {
                const badge = document.getElementById('cart-badge');
                if (badge) { 
                    badge.textContent = data.cart_count; 
                    badge.style.display = 'inline'; 
                }
                const btn = this.querySelector('button[type=submit]');
                if (btn) {
                    const orig = btn.innerHTML;
                    btn.innerHTML = '<i class="bi bi-check2"></i>';
                    btn.classList.replace('btn-primary', 'btn-success');
                    setTimeout(() => { 
                        btn.innerHTML = orig; 
                        btn.classList.replace('btn-success', 'btn-primary'); 
                    }, 2000);
                }
            }
        });
    });
});
</script>
</body>
</html>