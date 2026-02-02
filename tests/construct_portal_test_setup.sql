-- Ensure the test database is used.
USE `test_construct_portal`;

-- Drop tables in reverse order of dependency to avoid foreign key issues
DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `news`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `job_category`;
DROP TABLE IF EXISTS `category`;
DROP TABLE IF EXISTS `users`;

-- Create `users` table
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `picture` blob DEFAULT NULL,
  `job` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefon` varchar(20) NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `registration_date` date NOT NULL,
  `pass` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create `category` table
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create `news` table
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `picture` mediumblob DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `news_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `news_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert test data
INSERT INTO `users` (`id`, `username`, `picture`, `job`, `email`, `telefon`, `login`, `password`, `status`, `registration_date`, `pass`) VALUES
(1, 'Test Admin', NULL, '', 'admin@test.com', '', '', '$2y$10$EXsOdlMwRZoafaOxi8gr1OildjbxVdYDHuzpiF0pKFmv1Q3HCcttm', 'admin', '2026-01-01', '123456');

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Test Category 1'),
(2, 'Test Category 2');

-- Insert 10 news items for testing pagination and limits
INSERT INTO `news` (`id`, `title`, `text`, `category_id`, `user_id`) VALUES
(1, 'News 1', 'Text 1', 1, 1),
(2, 'News 2', 'Text 2', 2, 1),
(3, 'News 3', 'Text 3', 1, 1),
(4, 'News 4', 'Text 4', 2, 1),
(5, 'News 5', 'Text 5', 1, 1),
(6, 'News 6', 'Text 6', 2, 1),
(7, 'News 7', 'Text 7', 1, 1),
(8, 'News 8', 'Text 8', 2, 1),
(9, 'News 9', 'Text 9', 1, 1),
(10, 'News 10', 'Text 10', 2, 1);

-- Create `job_category` table
CREATE TABLE `job_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `job_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create `jobs` table
CREATE TABLE `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `city` varchar(50) NOT NULL,
  `employment` enum('Полная занятость','Частичная занятость','Временная занятость','Сезонная работа','Удаленная работа','Подряд','Стажировка') NOT NULL,
  `schedule` enum('Стандартный график','Сменный','Скользящий','Сдельная') NOT NULL,
  `salary` varchar(50) NOT NULL,
  `contact_name` varchar(50) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `posted_date` datetime NOT NULL,
  `expires_date` datetime DEFAULT NULL,
  `job_category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`job_category_id`) REFERENCES `job_category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert test data for jobs
INSERT INTO `job_category` (`id`, `title`, `category_id`) VALUES
(1, 'Test Job Category 1', 1),
(2, 'Test Job Category 2', 2);

INSERT INTO `jobs` (`id`, `title`, `description`, `city`, `employment`, `schedule`, `salary`, `contact_name`, `phone`, `posted_date`, `expires_date`, `job_category_id`) VALUES
(1, 'Job 1', 'Desc 1', 'City 1', 'Полная занятость', 'Стандартный график', '1000', 'John', '111', '2026-01-01 00:00:00', NULL, 1),
(2, 'Job 2', 'Desc 2', 'City 2', 'Частичная занятость', 'Сменный', '2000', 'Jane', '222', '2026-01-02 00:00:00', NULL, 2),
(3, 'Job 3', 'Desc 3', 'City 3', 'Полная занятость', 'Стандартный график', '3000', 'Jake', '333', '2026-01-03 00:00:00', NULL, 1);

-- Create `comments` table
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `text` varchar(500) NOT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert test data for comments
INSERT INTO `comments` (`id`, `news_id`, `text`, `date`) VALUES
(1, 1, 'Comment 1 for news 1', '2026-01-01 10:00:00'),
(2, 1, 'Comment 2 for news 1', '2026-01-01 11:00:00'),
(3, 2, 'Comment 1 for news 2', '2026-01-02 10:00:00');
