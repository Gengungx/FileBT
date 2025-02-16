-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 30, 2024 lúc 11:32 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `register`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `class`
--

INSERT INTO `class` (`id`, `name`) VALUES
(1, 'Class A'),
(2, 'Class B'),
(3, 'Class C');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `class_subject`
--

CREATE TABLE `class_subject` (
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `class_subject`
--

INSERT INTO `class_subject` (`class_id`, `subject_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `subject`
--

INSERT INTO `subject` (`id`, `name`, `description`) VALUES
(1, 'Lập trình', 'Giới thiệu về lập trình'),
(2, 'Cấu trúc dữ liệu', 'Nghiên cứu về các cấu trúc dữ liệu'),
(3, 'Cơ sở dữ liệu', 'Giới thiệu về hệ thống cơ sở dữ liệu'),
(4, 'Hệ điều hành', 'Các khái niệm về hệ điều hành'),
(5, 'Mạng máy tính', 'Mạng máy tính và các khái niệm liên quan');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `datebirth` varchar(100) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `image` varchar(60) NOT NULL,
  `password` varchar(100) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `username`, `fullname`, `email`, `datebirth`, `phone`, `address`, `image`, `password`, `class_id`, `subject_id`) VALUES
(112, 'username6', 'Đỗ Thị F', 'user6@gmail.com', '2000-06-01', '0123456784', 'AAA', '66a95a6ca0eea.jpeg', 'e10adc3949ba59abbe56e057f20f883e', 2, NULL),
(113, 'username7', 'Vũ Văn G', 'user7@gmail.com', '2000-07-01', '0123456783', 'AAA', '66999b068b5e0.jpg', 'e10adc3949ba59abbe56e057f20f883e', 2, NULL),
(114, 'username8', 'Phan Thị H', 'user8@gmail.com', '2000-08-01', '0123456782', 'AAA', '66999b266bf3e.jpg', 'e10adc3949ba59abbe56e057f20f883e', 2, NULL),
(115, 'username9', 'Bùi Văn I', 'user9@gmail.com', '2000-09-01', '0123456781', 'AAA', '66999b4505617.jpg', 'e10adc3949ba59abbe56e057f20f883e', 2, NULL),
(116, 'username10', 'Đinh Thị J', 'user10@gmail.com', '2000-10-01', '0123456780', 'AAA', '66999b63bffb7.jpg', 'e10adc3949ba59abbe56e057f20f883e', 2, NULL),
(117, 'username11', 'Ngô Văn K', 'user11@gmail.com', '2000-11-01', '0123456779', 'AAA', '66999b814e4a1.jpg', 'e10adc3949ba59abbe56e057f20f883e', 3, NULL),
(118, 'username12', 'Hồ Thị L', 'user12@gmail.com', '2000-12-01', '0123456778', 'AAA', '66999b9d25c16.jpg', 'e10adc3949ba59abbe56e057f20f883e', 3, NULL),
(119, 'username13', 'Nguyễn Văn M', 'user13@gmail.com', '2001-01-01', '0123456777', 'AAA', '66999bbaf1f45.jpg', 'e10adc3949ba59abbe56e057f20f883e', 3, NULL),
(120, 'username14', 'Trần Thị N', 'user14@gmail.com', '2001-02-01', '0123456776', 'AAA', '66999bd5df714.jpg', 'e10adc3949ba59abbe56e057f20f883e', 3, NULL),
(121, 'username15', 'Lê Văn O', 'user15@gmail.com', '2001-03-01', '0123456775', 'AAA', '66999bf6a349e.jpg', 'e10adc3949ba59abbe56e057f20f883e', 3, NULL),
(122, 'username16', 'Phạm Thị P', 'user16@gmail.com', '2001-04-01', '0123456774', 'AAA', '66999c0fe14fc.jpg', 'e10adc3949ba59abbe56e057f20f883e', 1, NULL),
(123, 'username17', 'Hoàng Văn Q', 'user17@gmail.com', '2001-05-01', '0123456773', 'AAA', '66999c2a5d9a7.jpg', 'e10adc3949ba59abbe56e057f20f883e', 2, NULL),
(124, 'username18', 'Đỗ Thị R', 'user18@gmail.com', '2001-06-01', '0123456772', 'AAA', '66999c472d8fb.jpg', 'e10adc3949ba59abbe56e057f20f883e', 3, NULL),
(125, 'username19', 'Vũ Văn S', 'user19@gmail.com', '2001-07-01', '0123456771', 'AAA', '66999c61970aa.jpg', 'e10adc3949ba59abbe56e057f20f883e', 3, NULL),
(126, 'admin', 'admin', 'admin@gmail.com', '2001-08-01', '0123456770', 'AAA', '66999cc7681c3.jpg', 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL),
(132, 'username1', 'áafasf', 'ygihnie0@gmail.com', '2002-02-22', '3213123123', 'đá', '66a95b9a4834a.jpeg', 'e10adc3949ba59abbe56e057f20f883e', 1, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_class`
--

CREATE TABLE `user_class` (
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_class`
--

INSERT INTO `user_class` (`user_id`, `class_id`) VALUES
(112, 3),
(113, 1),
(114, 2),
(115, 3),
(116, 1),
(117, 2),
(118, 3),
(119, 1),
(120, 2),
(121, 3),
(122, 1),
(123, 2),
(124, 3),
(125, 1),
(126, 2);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `class_subject`
--
ALTER TABLE `class_subject`
  ADD PRIMARY KEY (`class_id`,`subject_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Chỉ mục cho bảng `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Chỉ mục cho bảng `user_class`
--
ALTER TABLE `user_class`
  ADD PRIMARY KEY (`user_id`,`class_id`),
  ADD KEY `class_id` (`class_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `class_subject`
--
ALTER TABLE `class_subject`
  ADD CONSTRAINT `class_subject_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`),
  ADD CONSTRAINT `class_subject_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`);

--
-- Các ràng buộc cho bảng `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`);

--
-- Các ràng buộc cho bảng `user_class`
--
ALTER TABLE `user_class`
  ADD CONSTRAINT `user_class_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_class_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
