# 🌐 WEBSITE DOANH NGHIỆP TECHSAAS - PROJECT ASSIGNMENT (HK2 2025-2026)

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![PHP](https://img.shields.io/badge/PHP-%3E%3D%207.4-777bb4.svg?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479a1.svg?logo=mysql)
![Architecture](https://img.shields.io/badge/Architecture-Custom%20MVC-orange.svg)
![License](https://img.shields.io/badge/License-Academic-green.svg)
![GitHub last commit](https://img.shields.io/github/last-commit/NghiaNguyenhk2005/WEB252)
![GitHub repo size](https://img.shields.io/github/repo-size/NghiaNguyenhk2005/WEB252)
![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-777bb4.svg)
![MySQL Version](https://img.shields.io/badge/MySQL-5.7%2B-4479a1.svg)
![Status](https://img.shields.io/badge/status-completed-brightgreen.svg)

---

## 1. GIỚI THIỆU DỰ ÁN

**TechSaaS** là nền tảng web doanh nghiệp hoàn chỉnh được xây dựng bằng PHP thuần theo mô hình MVC tự định nghĩa. Hệ thống được phân chia thành 4 nhiệm vụ chính:

| Nhiệm vụ | Mô tả | Trạng thái |
|----------|-------|-------------|
| Task 1 | Quản lý thông tin chung, cấu hình hệ thống, tiếp nhận liên hệ khách hàng | Hoàn thành |
| Task 2 | Quản lý nội dung giới thiệu và hệ thống hỏi đáp (FAQ) | Hoàn thành |
| Task 3 | Quản lý sản phẩm, giỏ hàng và đơn hàng (Mở rộng) | Hoàn thành |
| Task 4 | Quản lý tin tức và bình luận (Mở rộng) | Hoàn thành |

Dự án sử dụng ngôn ngữ lập trình PHP thuần (phiên bản 7.4 trở lên) kết hợp với cơ sở dữ liệu MySQL, tuân thủ mô hình kiến trúc MVC tự xây dựng.

---

## 2. STACK CÔNG NGHỆ

| Thành phần | Công nghệ |
|------------|-----------|
| Backend | PHP 7.4+ (Thuần, không Framework) |
| Database | MySQL 5.7+ / MariaDB 10.2+ |
| Giao diện User | HTML5, CSS3, JavaScript, Bootstrap 5, AOS Library |
| Giao diện Admin | Sidebar tự thiết kế (thu gọn, responsive) |
| AJAX | Fetch API / jQuery (Cart, Search) |
| Bảo mật | CSRF Token, Prepared Statements, password_hash() |

---

## 3. CẤU TRÚC THƯ MỤC

```text
WEB252/
├── app/                         # Logic nghiệp vụ
│   ├── controllers/             # Controllers
│   │   ├── admin/               # Admin controllers
│   │   └── client/              # Client controllers
│   ├── models/                  # Models
│   ├── core/                    # Core system
│   │   ├── Database.php         # PDO connection
│   │   ├── BaseController.php   # Base controller
│   │   ├── BaseModel.php        # CRUD core
│   │   ├── Router.php           # URL routing
│   │   ├── AuthMiddleware.php   # Authentication
│   │   ├── SEO.php              # SEO handler
│   │   └── helpers.php          # Helper functions
│   └── uploads/                 # Uploaded images
│
├── assets/                      # Static assets
├── config/                      # Database config
├── views/                       # Views & templates
├── image/                       # Demo images
├── .htaccess                    # Apache rewrite rules
├── index.php                    # Front controller
├── seed.sql                     # Sample data
└── WEB252.sql                   # Database structure
```

---

## 4. PHÂN CÔNG CÔNG VIỆC

| Thành viên | MSSV | Nhiệm vụ | Mức độ |
|------------|------|----------|---------|
| Nguyễn Đức Nghĩa | 2312266 | Task 1 + Mở rộng Task 3 & 4 + Hoàn thiện toàn bộ dự án | 100% |
| Nguyễn Hoàng Minh Hiếu | 2252211 | Task 2 + Hỗ trợ vẽ diagram | 100% |

Chi tiết:
- Nguyễn Đức Nghĩa: Xây dựng kiến trúc MVC, Router, BaseModel, BaseController, AuthMiddleware. Thiết kế Database (dbdiagram.io). Hoàn thiện báo cáo. Tích hợp SEO, AOS, AJAX Cart, Google Maps. Task 1 (cấu hình hệ thống, slider, liên hệ). Task 3 & 4 (CRUD sản phẩm, đơn hàng, giỏ hàng, tin tức, bình luận, đánh giá sao).
- Nguyễn Hoàng Minh Hiếu: Task 2 (trang giới thiệu, hệ thống FAQ). Hỗ trợ vẽ usecase diagram, sequence diagram, class diagram.

---

## 5. TÍNH NĂNG CỐT LÕI

### Hệ thống Xác thực & Phân quyền
- Đăng ký / Đăng nhập / Đăng xuất (CSRF protection)
- Mã hóa mật khẩu bằng password_hash() (Bcrypt)
- Phân quyền: Guest / Member / Admin (AuthMiddleware)
- Quản lý hồ sơ cá nhân, upload avatar

### Giao diện Client
- Trang chủ: Slider banner động, sản phẩm nổi bật, tin tức mới nhất, đối tác, thống kê
- Sản phẩm: Danh sách phân trang, lọc theo danh mục, chi tiết sản phẩm, đánh giá sao (1-5), bình luận
- Giỏ hàng: AJAX (thêm/xóa/cập nhật số lượng), thanh toán, lịch sử đơn hàng
- Tin tức: Danh sách phân trang, chi tiết bài viết, bình luận
- Dịch vụ: Danh sách và chi tiết dịch vụ doanh nghiệp
- FAQ: Xem câu hỏi đã trả lời (accordion), gửi câu hỏi mới
- Liên hệ: Form validation + Google Maps tích hợp
- Tìm kiếm: AJAX realtime (sản phẩm + tin tức)

### Giao diện Quản trị (Admin)
- Dashboard: Thống kê (doanh thu, đơn hàng, sản phẩm, người dùng, liên hệ, FAQ chờ duyệt)
- Sản phẩm: CRUD, upload ảnh, danh mục, tồn kho
- Đơn hàng: Danh sách, chi tiết, cập nhật trạng thái (pending, paid, shipping, completed, cancelled, refunded)
- Tin tức: CRUD, thumbnail, trạng thái hiển thị
- Dịch vụ: CRUD với icon Bootstrap
- FAQ: Xem câu hỏi, trả lời, thay đổi trạng thái (pending -> answered)
- Liên hệ: Xem danh sách, cập nhật trạng thái (new, read, replied), xóa
- Slider: Thêm/xóa banner trang chủ
- Người dùng: Xem, khóa/mở khóa tài khoản
- Cấu hình hệ thống: Tên website, phone, email, địa chỉ, nội dung trang giới thiệu, giá trị cốt lõi

### Bảo mật
- Prepared Statements chống SQL Injection
- htmlspecialchars() chống XSS
- CSRF Token cho mọi form
- session_regenerate_id() sau đăng nhập
- Kiểm tra loại file khi upload
- AuthMiddleware bảo vệ route admin

### SEO & Hiệu năng
- Meta tags động (title, description, keywords, Open Graph, Twitter Card, canonical URL)
- JSON-LD structured data
- Sitemap tự động, robots.txt
- AJAX debounce cho tìm kiếm
- Phân trang (6 items/page)
- AOS animations (Animate on Scroll)

---

## 6. CẤU TRÚC CƠ SỞ DỮ LIỆU

Database được thiết kế trên dbdiagram.io với các bảng chính:

| Bảng | Mô tả |
|------|-------|
| users | Người dùng hệ thống |
| roles, user_roles | Phân quyền |
| products, categories | Sản phẩm và danh mục |
| orders, order_items | Đơn hàng và chi tiết |
| posts | Bài viết tin tức |
| services | Dịch vụ doanh nghiệp |
| faqs | Câu hỏi thường gặp |
| contacts | Liên hệ khách hàng |
| sliders | Banner trang chủ |
| settings | Cấu hình hệ thống (key-value) |
| product_comments, post_comments | Bình luận & đánh giá |
| carts, cart_items | Giỏ hàng |

---

## 7. HÌNH ẢNH DEMO

### 🖥️ Giao diện Khách hàng (Frontend)

| STT | Màn hình | Hình ảnh |
|-----|----------|----------|
| 1 | Trang chủ - Hero Slider | ![Home1](image/UI-Frontend/Home1.png) |
| 2 | Trang chủ - Đối tác & Giới thiệu | ![Home2](image/UI-Frontend/Home2.png) |
| 3 | Trang chủ - Thống kê & Tính năng | ![Home3](image/UI-Frontend/Home3.png) |
| 4 | Trang chủ - Hạ tầng & Bảng giá | ![Home4](image/UI-Frontend/Home4.png) |
| 5 | Giới thiệu - Hero section | ![About1](image/UI-Frontend/About1.png) |
| 6 | Giới thiệu - Giá trị cốt lõi | ![About2](image/UI-Frontend/About2.png) |
| 7 | Giới thiệu - Thống kê & Định hướng | ![About3](image/UI-Frontend/About3.png) |
| 8 | Giới thiệu - Sứ mệnh & Tầm nhìn | ![About4](image/UI-Frontend/About4.png) |
| 9 | Liên hệ - Thông tin & Form | ![Contact1](image/UI-Frontend/Contact1.png) |
| 10 | Liên hệ - Google Maps | ![Contact2](image/UI-Frontend/Contact2.png) |
| 11 | FAQ - Danh sách câu hỏi | ![Faq1](image/UI-Frontend/Faq1.png) |
| 12 | FAQ - Form gửi câu hỏi | ![Faq2](image/UI-Frontend/Faq2.png) |
| 13 | Đăng nhập | ![Login](image/UI-Frontend/Login.png) |

### 🛠️ Giao diện Quản trị (Backend)

| STT | Màn hình | Hình ảnh |
|-----|----------|----------|
| 1 | Đăng nhập Admin | ![Login](image/UI-Backend/Login.png) |
| 2 | Dashboard thống kê | ![Dashboard](image/UI-Backend/Dashboard.png) |
| 3 | Cấu hình thông tin công ty | ![Settings](image/UI-Backend/Settings.png) |
| 4 | Quản lý liên hệ | ![Contact-List](image/UI-Backend/Contact-List.png) |
| 5 | Quản lý Slider Banner | ![Banner-Config](image/UI-Backend/Banner-Config.png) |
| 6 | Quản lý sản phẩm | ![Products](image/UI-Backend/Products.png) |
| 7 | Biên tập Giới thiệu - Thông tin chung | ![About-Editor1](image/UI-Backend/About-Editor1.png) |
| 8 | Biên tập Giới thiệu - Giá trị cốt lõi | ![About-Editor2](image/UI-Backend/About-Editor2.png) |
| 9 | Biên tập Giới thiệu - Sứ mệnh & Tầm nhìn | ![About-Editor3](image/UI-Backend/About-Editor3.png) |
| 10 | Quản lý câu hỏi FAQ | ![QA-Manager](image/UI-Backend/QA-Manager.png) |

---

## 8. QUY ĐỊNH BẮT BUỘC

| Quy định | Trạng thái |
|----------|-------------|
| Không sử dụng PHP Framework (Laravel, CodeIgniter...) | Tuân thủ |
| Không sử dụng CMS (Wordpress, Joomla...) | Tuân thủ |
| Không sao chép mã nguồn | Tự xây dựng |
| Ảnh lưu trữ trên server nội bộ | Tuân thủ |
| Mô hình MVC tự xây dựng | Tuân thủ |
| Validation Client & Server | Tuân thủ |

---

## 9. HƯỚNG DẪN CÀI ĐẶT

### Yêu cầu hệ thống
- Web Server: Apache 2.4+ (mod_rewrite)
- PHP: 7.4 trở lên
- Database: MySQL 5.7+ / MariaDB 10.2+
- Extensions PHP: PDO, mysqli, gd, openssl, mbstring

### Các bước cài đặt

1. Clone dự án:
   git clone https://github.com/NghiaNguyenhk2005/WEB252.git

2. Copy vào thư mục htdocs (XAMPP):
   cp -r WEB252 C:\xampp\htdocs\

3. Tạo database và import:
   - Truy cập phpMyAdmin, tạo database 'tass'
   - Import file Database.sql

4. Cấu hình kết nối database:
   Chỉnh sửa config/database.php với thông tin của bạn

5. Truy cập website:
   - Client: http://localhost/WEB252/
   - Admin: http://localhost/WEB252/admin/dashboard
   - Setup admin: http://localhost/WEB252/setup.php

### Tài khoản mặc định
- Email: admin@techsaas.vn
- Mật khẩu: admin123

### Khắc phục sự cố thường gặp

| Lỗi | Nguyên nhân | Cách khắc phục |
|-----|-------------|----------------|
| **404 Not Found** | mod_rewrite chưa bật hoặc .htaccess sai | Bật mod_rewrite trong Apache, kiểm tra file .htaccess |
| **Connection failed** | Sai thông tin database | Kiểm tra lại host, username, password trong config/database.php |
| **Lỗi upload file** | Quyền ghi thư mục | Cấp quyền 755 hoặc 777 cho thư mục `uploads/` |
| **Session không hoạt động** | session.save_path sai | Kiểm tra cấu hình session trong php.ini |
| **Lỗi CSRF token** | Cookie trình duyệt | Xóa cookie trình duyệt hoặc thử tab ẩn danh |
| **Trắng trang không báo lỗi** | Lỗi PHP nhưng tắt hiển thị | Bật `display_errors = On` trong php.ini hoặc kiểm tra log |
| **Lỗi 500 Internal Server** | Lỗi cú pháp hoặc quyền file | Kiểm tra error log của Apache/PHP |

---

## 10. HƯỚNG PHÁT TRIỂN (FUTURE IMPROVEMENTS)

Các tính năng dự kiến phát triển trong tương lai:

- [ ] **Tích hợp thanh toán trực tuyến:** VNPay, MoMo, Zalopay
- [ ] **Gửi email xác nhận đơn hàng:** Dùng PHPMailer hoặc SMTP
- [ ] **Hệ thống Coupon / Mã giảm giá:** Giảm giá theo % hoặc số tiền
- [ ] **Đa ngôn ngữ (i18n):** Hỗ trợ tiếng Việt và tiếng Anh
- [ ] **Progressive Web App (PWA):** Tải trang nhanh hơn, dùng offline
- [ ] **API RESTful chuẩn:** Xây dựng API riêng cho mobile app
- [ ] **Dashboard với biểu đồ thống kê:** Dùng Chart.js hoặc Google Charts
- [ ] **Hệ thống Wishlist (Yêu thích):** Lưu sản phẩm yêu thích của khách hàng
- [ ] **Đánh giá sản phẩm có hình ảnh:** Upload ảnh kèm đánh giá
- [ ] **Thông báo realtime:** Dùng WebSocket hoặc SSE
      
## 11. TÀI LIỆU THAM KHẢO

- PHP Documentation: https://www.php.net/docs.php
- MySQL Documentation: https://dev.mysql.com/doc/
- Bootstrap 5 Documentation: https://getbootstrap.com/docs/5.0/
- AOS (Animate on Scroll): https://michalsnik.github.io/aos/
- OWASP Top 10: https://owasp.org/www-project-top-ten/
- Google SEO Starter Guide: https://developers.google.com/search/docs/fundamentals/seo-starter-guide
- dbdiagram.io: https://dbdiagram.io/

---

## 12. GIẤY PHÉP

Dự án được thực hiện với mục đích học tập và nghiên cứu tại Trường Đại học Bách Khoa - ĐHQG TP.HCM.

---

## 13. TÁC GIẢ

Nguyễn Đức Nghĩa
- GitHub: https://github.com/NghiaNguyenhk2005

Nguyễn Hoàng Minh Hiếu
- GitHub: https://github.com/creeper881

---

(c) 2026 - Đồ án Lập trình Web (CO3050) - Trường Đại học Bách Khoa TP.HCM
