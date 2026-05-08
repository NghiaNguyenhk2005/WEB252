-- Run this once to seed default settings and roles
USE TaSS;

-- Roles
INSERT IGNORE INTO roles (id, name) VALUES (1, 'admin'), (2, 'member');

-- Default site settings
INSERT IGNORE INTO settings (setting_key, setting_value, description) VALUES
('site_name',        'TechSaaS',                       'Tên website'),
('site_logo',        '',                                'Đường dẫn logo'),
('company_phone',    '0123 456 789',                   'Số điện thoại'),
('company_email',    'contact@techsaas.vn',            'Email liên hệ'),
('company_address',  'Quận 1, TP. Hồ Chí Minh',       'Địa chỉ công ty');

-- Default admin account
-- Password is: admin123
-- Generated with PHP: password_hash('admin123', PASSWORD_DEFAULT)
INSERT IGNORE INTO users (id, username, email, password, status, created_at) VALUES
(1, 'Admin', 'admin@techsaas.vn',
 '$2y$10$YourHashHere_ReplaceThis',
 1, NOW());

-- Assign admin role to user id=1
INSERT IGNORE INTO user_roles (user_id, role_id) VALUES (1, 1);
