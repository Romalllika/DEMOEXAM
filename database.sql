CREATE DATABASE IF NOT EXISTS `drive_rf` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `drive_rf`;

DROP TABLE IF EXISTS `feedback`;
DROP TABLE IF EXISTS `applications`;
DROP TABLE IF EXISTS `pay_variants`;
DROP TABLE IF EXISTS `machines`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` INT AUTO_INCREMENT PRIMARY KEY,
  `login` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `FIO` VARCHAR(150) NOT NULL,
  `date_burn` DATE NOT NULL,
  `phone` VARCHAR(30) NOT NULL,
  `email` VARCHAR(120) NOT NULL,
  `role` ENUM('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `machines` (
  `id_machine` INT AUTO_INCREMENT PRIMARY KEY,
  `machine_name` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `pay_variants` (
  `id_pay` INT AUTO_INCREMENT PRIMARY KEY,
  `variant` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `applications` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `machine_id` INT NOT NULL,
  `date_start` DATE NOT NULL,
  `pay_var` INT NOT NULL,
  `user_id` INT NOT NULL,
  `status` ENUM('new','processing','done') NOT NULL DEFAULT 'new',
  CONSTRAINT `fk_app_machine` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`id_machine`) ON UPDATE CASCADE,
  CONSTRAINT `fk_app_pay` FOREIGN KEY (`pay_var`) REFERENCES `pay_variants` (`id_pay`) ON UPDATE CASCADE,
  CONSTRAINT `fk_app_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `feedback` (
  `id_feedback` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `text` TEXT NOT NULL,
  `application_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_feedback_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_feedback_application` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `machines` (`machine_name`) VALUES
('Катер'),
('Круизный лайнер'),
('Яхта');

INSERT INTO `pay_variants` (`variant`) VALUES
('Наличными'),
('Банковской картой'),
('Онлайн-переводом');

INSERT INTO `users` (`login`, `password`, `FIO`, `date_burn`, `phone`, `email`, `role`) VALUES
('Admin26', '$2y$12$HHu92U6YLDkhVAuSZdGLGeyc6P/oqUY5wt.1SO7NV.LBVI/ZhAVW6', 'Администратор', '2000-01-01', '+70000000000', 'admin@vodit.rf', 'admin');
