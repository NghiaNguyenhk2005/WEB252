CREATE TABLE `users` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) UNIQUE NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255),
  `status` int DEFAULT 1,
  `created_at` timestamp,
  `deleted_at` timestamp
);

CREATE TABLE `roles` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) UNIQUE NOT NULL
);

CREATE TABLE `user_roles` (
  `user_id` int,
  `role_id` int,
  PRIMARY KEY (`user_id`, `role_id`)
);

CREATE TABLE `categories` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(150),
  `parent_id` int
);

CREATE TABLE `products` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150),
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `stock` int DEFAULT 0,
  `image` varchar(255),
  `category_id` int,
  `created_at` timestamp,
  `deleted_at` timestamp
);

CREATE TABLE `posts` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255),
  `content` text,
  `thumbnail` varchar(255),
  `author_id` int,
  `created_at` timestamp,
  `status` int DEFAULT 1,
  `deleted_at` timestamp
);

CREATE TABLE `product_comments` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `content` text NOT NULL,
  `rating` int,
  `created_at` timestamp
);

CREATE TABLE `post_comments` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp
);

CREATE TABLE `carts` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int,
  `created_at` timestamp
);

CREATE TABLE `cart_items` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `cart_id` int,
  `product_id` int,
  `quantity` int DEFAULT 1
);

CREATE TABLE `orders` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int,
  `total_price` decimal(10,2),
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `notes` text,
  `status` varchar(20) DEFAULT 'pending' COMMENT 'pending, paid, shipping, completed, cancelled, refunded',
  `created_at` timestamp,
  `deleted_at` timestamp
);

CREATE TABLE `order_items` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `order_id` int,
  `product_id` int,
  `quantity` int,
  `price` decimal(10,2)
);

CREATE TABLE `contacts` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int COMMENT 'nullable nếu là khách',
  `name` varchar(100),
  `email` varchar(100),
  `message` text NOT NULL,
  `status` varchar(20) COMMENT 'new, read, replied',
  `created_at` timestamp
);

CREATE TABLE `faqs` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer` text,
  `created_by` int COMMENT 'admin',
  `user_id` int COMMENT 'nullable nếu do user hỏi',
  `status` varchar(20) COMMENT 'pending, answered',
  `created_at` timestamp
);

CREATE TABLE `pages` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) UNIQUE,
  `content` text,
  `author_id` int,
  `updated_by` int,
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `tags` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(100)
);

CREATE TABLE `post_tags` (
  `post_id` int,
  `tag_id` int,
  PRIMARY KEY (`post_id`, `tag_id`)
);

CREATE TABLE `product_images` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `url` varchar(255)
);

CREATE TABLE `post_images` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `post_id` int NOT NULL,
  `url` varchar(255)
);

CREATE TABLE `settings` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `setting_key` varchar(100) UNIQUE NOT NULL,
  `setting_value` text,
  `description` varchar(255),
  `updated_by` int,
  `updated_at` timestamp DEFAULT (now())
);

CREATE TABLE `sliders` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `image_url` varchar(255) NOT NULL,
  `title` varchar(255),
  `subtitle` text,
  `button_text` varchar(50),
  `button_link` varchar(255),
  `display_order` int DEFAULT 0,
  `status` int DEFAULT 1,
  `author_id` int,
  `product_id` int,
  `post_id` int,
  `created_at` timestamp DEFAULT (now())
);

CREATE TABLE `services` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) UNIQUE,
  `icon` varchar(100) COMMENT 'Bootstrap icon class like bi-shield-lock',
  `short_description` varchar(255),
  `detailed_content` text,
  `status` int DEFAULT 1,
  `author_id` int,
  `created_at` timestamp DEFAULT (now()),
  `updated_at` timestamp DEFAULT (now())
);

ALTER TABLE `user_roles` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `user_roles` ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

ALTER TABLE `categories` ADD FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`);

ALTER TABLE `products` ADD FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

ALTER TABLE `posts` ADD FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

ALTER TABLE `product_comments` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `product_comments` ADD FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `post_comments` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `post_comments` ADD FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

ALTER TABLE `carts` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `cart_items` ADD FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`);

ALTER TABLE `cart_items` ADD FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `orders` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `order_items` ADD FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

ALTER TABLE `order_items` ADD FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `contacts` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `faqs` ADD FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

ALTER TABLE `faqs` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `pages` ADD FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

ALTER TABLE `pages` ADD FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

ALTER TABLE `post_tags` ADD FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

ALTER TABLE `post_tags` ADD FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);

ALTER TABLE `product_images` ADD FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `post_images` ADD FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

ALTER TABLE `sliders` ADD FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

ALTER TABLE `sliders` ADD FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `sliders` ADD FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

ALTER TABLE `settings` ADD FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

ALTER TABLE `services` ADD FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);
