-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 23, 2024 lúc 09:33 AM
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
-- Cơ sở dữ liệu: `exam_management`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `classes`
--

INSERT INTO `classes` (`id`, `class_name`) VALUES
(10, '1'),
(11, '2'),
(12, '3'),
(13, '4'),
(14, '5');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `exam_name` varchar(255) NOT NULL,
  `class_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `exams`
--

INSERT INTO `exams` (`id`, `exam_name`, `class_id`) VALUES
(28, 'Lập trình hướng đối tượng', 10),
(29, 'Cơ sở dữ liệu', 11),
(30, 'An ninh mạng', 12),
(31, 'Phân tích thiết kế hệ thống', 13),
(32, 'Trí tuệ nhân tạo', 14);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam_files`
--

CREATE TABLE `exam_files` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `exam_schedule_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam_proctors`
--

CREATE TABLE `exam_proctors` (
  `id` int(11) NOT NULL,
  `exam_schedule_id` int(11) DEFAULT NULL,
  `proctor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam_schedule`
--

CREATE TABLE `exam_schedule` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `exam_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `status` enum('chua_thi','dang_thi','thi_xong') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `proctors`
--

CREATE TABLE `proctors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `proctors`
--

INSERT INTO `proctors` (`id`, `name`) VALUES
(1, 'Giám thị 1'),
(2, 'Giám thị 2'),
(3, 'Giám thị 3');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `proctor_assignment`
--

CREATE TABLE `proctor_assignment` (
  `id` int(11) NOT NULL,
  `proctor_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `assigned` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `class_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `students`
--

INSERT INTO `students` (`id`, `name`, `class_id`) VALUES
(1, 'Sinh viên 1', 10),
(2, 'Sinh viên 2', 10),
(3, 'Sinh viên 3', 10),
(4, 'Sinh viên 4', 10),
(5, 'Sinh viên 5', 10),
(6, 'Sinh viên 6', 11),
(7, 'Sinh viên 7', 11),
(8, 'Sinh viên 8', 11),
(9, 'Sinh viên 9', 11),
(10, 'Sinh viên 10', 11),
(11, 'Sinh viên 11', 12),
(12, 'Sinh viên 12', 12),
(13, 'Sinh viên 13', 12),
(14, 'Sinh viên 14', 12),
(15, 'Sinh viên 15', 12),
(16, 'Sinh viên 16', 13),
(17, 'Sinh viên 17', 13),
(18, 'Sinh viên 18', 13),
(19, 'Sinh viên 19', 13),
(20, 'Sinh viên 20', 13);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Chỉ mục cho bảng `exam_files`
--
ALTER TABLE `exam_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Chỉ mục cho bảng `exam_proctors`
--
ALTER TABLE `exam_proctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_schedule_id` (`exam_schedule_id`),
  ADD KEY `proctor_id` (`proctor_id`);

--
-- Chỉ mục cho bảng `exam_schedule`
--
ALTER TABLE `exam_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Chỉ mục cho bảng `proctors`
--
ALTER TABLE `proctors`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `proctor_assignment`
--
ALTER TABLE `proctor_assignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proctor_id` (`proctor_id`),
  ADD KEY `fk_exam_id` (`exam_id`);

--
-- Chỉ mục cho bảng `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `exam_files`
--
ALTER TABLE `exam_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `exam_proctors`
--
ALTER TABLE `exam_proctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `exam_schedule`
--
ALTER TABLE `exam_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT cho bảng `proctors`
--
ALTER TABLE `proctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `proctor_assignment`
--
ALTER TABLE `proctor_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`);

--
-- Các ràng buộc cho bảng `exam_files`
--
ALTER TABLE `exam_files`
  ADD CONSTRAINT `exam_files_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`);

--
-- Các ràng buộc cho bảng `exam_proctors`
--
ALTER TABLE `exam_proctors`
  ADD CONSTRAINT `exam_proctors_ibfk_1` FOREIGN KEY (`exam_schedule_id`) REFERENCES `exam_schedule` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_proctors_ibfk_2` FOREIGN KEY (`proctor_id`) REFERENCES `proctors` (`id`),
  ADD CONSTRAINT `fk_exam_schedule_id` FOREIGN KEY (`exam_schedule_id`) REFERENCES `exam_schedule` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `exam_schedule`
--
ALTER TABLE `exam_schedule`
  ADD CONSTRAINT `exam_schedule_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`);

--
-- Các ràng buộc cho bảng `proctor_assignment`
--
ALTER TABLE `proctor_assignment`
  ADD CONSTRAINT `fk_exam_id` FOREIGN KEY (`exam_id`) REFERENCES `exam_schedule` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `proctor_assignment_ibfk_1` FOREIGN KEY (`proctor_id`) REFERENCES `proctors` (`id`),
  ADD CONSTRAINT `proctor_assignment_ibfk_2` FOREIGN KEY (`exam_id`) REFERENCES `exam_schedule` (`id`);

--
-- Các ràng buộc cho bảng `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
