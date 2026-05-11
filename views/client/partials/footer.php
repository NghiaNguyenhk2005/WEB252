    </div>
</main>

<!-- Footer -->
<footer class="footer-custom">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5><i class="fa-solid fa-store me-2"></i>Tass Shop</h5>
                <p>Cửa hàng chuyên cung cấp sản phẩm chất lượng cao với giá tốt nhất thị trường.</p>
                <div class="mt-3">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Thông tin</h5>
                <ul class="list-unstyled">
                    <li><a href="<?= BASE_PATH ?>/about" class="text-white-50 text-decoration-none">Giới thiệu</a></li>
                    <li><a href="<?= BASE_PATH ?>/contact" class="text-white-50 text-decoration-none">Liên hệ</a></li>
                    <li><a href="<?= BASE_PATH ?>/faqs" class="text-white-50 text-decoration-none">FAQ</a></li>
                    <li><a href="<?= BASE_PATH ?>/privacy" class="text-white-50 text-decoration-none">Chính sách bảo mật</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Liên hệ</h5>
                <ul class="list-unstyled text-white-50">
                    <li><i class="fa-solid fa-location-dot me-2"></i> 123 Đường ABC, Quận 1, TP.HCM</li>
                    <li><i class="fa-solid fa-phone me-2"></i> 0123 456 789</li>
                    <li><i class="fa-solid fa-envelope me-2"></i> info@tassshop.com</li>
                </ul>
            </div>
        </div>
        <hr class="bg-white-50">
        <div class="text-center text-white-50">
            <p class="mb-0">&copy; 2024 Tass Shop. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Update cart count
function updateCartCount() {
    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
    let count = cart.reduce((sum, item) => sum + item.quantity, 0);
    $('#cart-count').text(count);
}

$(document).ready(function() {
    updateCartCount();
});
</script>

</body>
</html>