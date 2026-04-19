# 🌐 WEBSITE DOANH NGHIỆP - PROJECT ASSIGNMENT (HK2 2025-2026)

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![PHP](https://img.shields.io/badge/PHP-%3E%3D%207.0-777bb4.svg?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479a1.svg?logo=mysql)
![Architecture](https://img.shields.io/badge/Architecture-Custom%20MVC-orange.svg)
![License](https://img.shields.io/badge/License-Academic-green.svg)

---

## 📖 1. GIỚI THIỆU DỰ ÁN
Dự án tập trung vào việc xây dựng hệ thống website hoàn chỉnh cho doanh nghiệp, đảm bảo tính thẩm mỹ (Responsive Design) và hiệu năng xử lý phía Server bằng PHP thuần theo mô hình MVC.

---

## 🛠️ 2. STACK CÔNG NGHỆ & YÊU CẦU KỸ THUẬT

| Thành phần | Công nghệ / Quy chuẩn |
| :--- | :--- |
| **Backend** | 🐘 **PHP >= 7.0** (Thuần, không Framework) |
| **Database** | 🐬 **MySQL** (Relational Database) |
| **Giao diện User** | 🎨 HTML5, CSS3, Javascript, Bootstrap 5 |
| **Giao diện Admin** | 📊 **Srtdash** Admin Dashboard Template |
| **Tiêu chuẩn** | ✅ **W3C Validator**, **SEO** cơ bản, **Responsive** |

---

## 📂 3. CẤU TRÚC THƯ MỤC HỆ THỐNG
Dự án áp dụng mô hình **MVC (Model-View-Controller)** tự định nghĩa để tối ưu việc quản lý mã nguồn:

```bash
/
├── 📂 app/                  # Logic nghiệp vụ (M & C)
│   ├── 📂 controllers/      # Điều phối yêu cầu (Admin & Client)
│   ├── 📂 models/           # Xử lý truy vấn SQL (Data layer)
│   └── 📂 core/             # Nhân hệ thống (DB Connect, Helpers)
├── 📂 assets/               # Tài nguyên tĩnh (Public)
│   ├── 📂 admin/            # Tài nguyên của Srtdash Template
│   └── 📂 client/           # Tài nguyên giao diện người dùng tự chọn
├── 📂 config/               # Cấu hình Database & App
├── 📂 uploads/              # Lưu trữ hình ảnh trực tiếp trên server
├── 📂 views/                # Giao diện (V)
│   ├── 📂 admin/            # Các trang Dashboard quản trị
│   └── 📂 client/           # Các trang dành cho khách hàng
├── 📄 .htaccess             # Xử lý Friendly URL (Rewrite Engine)
└── 📄 index.php             # Front Controller (Entry point)
```
## 👥 4. PHÂN CHIA CÔNG VIỆC (NHÓM 2 NGƯỜI)

### 🥇 Thành viên A: Nguyễn Đức Nghĩa (Leader)
**Phần việc phụ trách: Task #1 & #2**
* **Giao diện Public:** 🏠 Trang chủ, 📞 Trang Liên hệ, 🏢 Trang Giới thiệu, ❓ Trang Hỏi/đáp.
* **Hệ thống Quản trị (Admin):**
    * ⚙️ Quản lý nội dung động (Logo, hotline, thông tin doanh nghiệp).
    * 📑 Quản lý hệ thống Hỏi/đáp (CRUD - Thêm, sửa, xóa).
    * 📩 Quản lý phản hồi khách hàng từ form liên hệ.

### 🥈 Thành viên Nguyễn Hoàng Minh Hiếu: (Cộng sự)
**Phần việc phụ trách: Task #3 & #4**
* **Giao diện Public:** 🛒 Danh sách sản phẩm, 🔍 Chi tiết sản phẩm, 🛍️ Giỏ hàng, 📰 Danh sách bài viết & Tin tức.
* **Hệ thống Quản trị (Admin):**
    * 📦 Quản lý Sản phẩm & Đơn hàng (CRUD sản phẩm, trạng thái đơn hàng).
    * 📝 Quản lý Tin tức (CRUD bài viết, SEO Metadata).
    * 💬 Quản lý Bình luận và Đánh giá từ người dùng.

## 🚀 5. TÍNH NĂNG CỐT LÕI

1.  **🔐 Auth System:** Hệ thống Đăng ký, Đăng nhập, Quản lý hồ sơ cá nhân (Avatar, Mật khẩu).
2.  **🛡️ Permission:** Phân quyền người dùng chặt chẽ: Khách vãng lai, Thành viên và Quản trị viên.
3.  **📸 Media Manager:** Chức năng Upload và lưu trữ ảnh trực tiếp trên server (theo đúng yêu cầu đề bài).
4.  **💬 Interactions:** Tương tác người dùng qua bình luận, đánh giá và tìm kiếm tài nguyên.
5.  **⚡ Performance:** Áp dụng phân trang (Pagination), Validation dữ liệu nghiêm ngặt tại Client & Server.

## ⚠️ 6. QUY ĐỊNH BẮT BUỘC (COMPLIANCE)

* 🚫 **KHÔNG** sử dụng bất kỳ PHP Framework nào (Laravel, CodeIgniter, CakePHP...).
* 🚫 **KHÔNG** sử dụng CMS/CMF (Wordpress, Joomla, Drupal...).
* 🚫 **KHÔNG** sao chép mã nguồn (Gian lận sẽ nhận 0 điểm theo quy định).
* ✅ **BẮT BUỘC** ảnh phải lưu trên server nội bộ (không dùng link ảnh bên ngoài).
---

