-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 18, 2024 lúc 04:13 AM
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
-- Cơ sở dữ liệu: `registration_system`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `class1`
--

CREATE TABLE `class1` (
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `class2`
--

CREATE TABLE `class2` (
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `class3`
--

CREATE TABLE `class3` (
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `course_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `course_id`) VALUES
(1, 'Nhập môn Lập trình - Lớp 1', 1),
(2, 'Cấu trúc Dữ liệu và Giải thuật - Lớp 1', 2),
(3, 'Hệ thống Cơ sở Dữ liệu - Lớp 1', 3),
(4, 'Mạng Máy tính - Lớp 1', 4),
(5, 'Hệ điều hành - Lớp 1', 5),
(6, 'Phát triển Web - Lớp 1', 6),
(7, 'Kỹ thuật Phần mềm - Lớp 1', 7),
(8, 'An ninh mạng - Lớp 1', 8),
(9, 'Trí tuệ Nhân tạo - Lớp 1', 9),
(10, 'sql', 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `completed_courses`
--

CREATE TABLE `completed_courses` (
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `completed_courses`
--

INSERT INTO `completed_courses` (`student_id`, `course_id`) VALUES
(1, 1),
(1, 2),
(2, 4),
(3, 2),
(3, 5),
(4, 7),
(5, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`) VALUES
(1, 'Nhập môn Lập trình'),
(2, 'Cấu trúc Dữ liệu và Giải thuật'),
(3, 'Hệ thống Cơ sở Dữ liệu'),
(4, 'Mạng Máy tính'),
(5, 'Hệ điều hành'),
(6, 'Phát triển Web'),
(7, 'Kỹ thuật Phần mềm'),
(8, 'An ninh mạng'),
(9, 'Trí tuệ Nhân tạo'),
(10, 'sql');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `prerequisites`
--

CREATE TABLE `prerequisites` (
  `course_id` int(11) NOT NULL,
  `prerequisite_course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `prerequisites`
--

INSERT INTO `prerequisites` (`course_id`, `prerequisite_course_id`) VALUES
(2, 1),
(3, 1),
(4, 1),
(5, 2),
(6, 1),
(7, 2),
(8, 4),
(9, 2),
(10, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `registrations`
--

CREATE TABLE `registrations` (
  `registration_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `student_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `students`
--

INSERT INTO `students` (`student_id`, `username`, `password`, `student_name`) VALUES
(1, 'student1', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'Nguyễn Văn A'),
(2, 'student2', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'Trần Thị B'),
(3, 'student3', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'Lê Văn C'),
(4, 'student4', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'Phạm Thị D'),
(5, 'student5', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'Hoàng Văn E'),
(6, 'student6', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'Đỗ Thị F'),
(7, 'student7', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'Vũ Văn G'),
(8, 'student8', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'Phan Thị H'),
(9, 'student9', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'Bùi Văn I'),
(10, 'student10', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'Đinh Thị J'),
(11, 'student11', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'Ngô Văn K'),
(12, 'student12', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'Hồ Thị L'),
(13, 'student13', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'Nguyễn Văn M'),
(14, 'student14', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'Trần Thị N'),
(15, 'student15', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'Lê Văn O'),
(16, 'student16', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'Phạm Thị P'),
(17, 'student17', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'Hoàng Văn Q'),
(18, 'student18', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'Đỗ Thị R'),
(19, 'student19', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'Vũ Văn S'),
(20, 'admin', '$2y$10$TwR6h6jEElPyZBP.EDHf7OzsGw.e8HmzrM8C8uazmZFR41Yzxe9Xa', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `system_status`
--

CREATE TABLE `system_status` (
  `id` int(11) NOT NULL,
  `is_open` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `system_status`
--

INSERT INTO `system_status` (`id`, `is_open`) VALUES
(1, 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `class1`
--
ALTER TABLE `class1`
  ADD PRIMARY KEY (`student_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Chỉ mục cho bảng `class2`
--
ALTER TABLE `class2`
  ADD PRIMARY KEY (`student_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Chỉ mục cho bảng `class3`
--
ALTER TABLE `class3`
  ADD PRIMARY KEY (`student_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Chỉ mục cho bảng `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Chỉ mục cho bảng `completed_courses`
--
ALTER TABLE `completed_courses`
  ADD PRIMARY KEY (`student_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Chỉ mục cho bảng `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Chỉ mục cho bảng `prerequisites`
--
ALTER TABLE `prerequisites`
  ADD PRIMARY KEY (`course_id`,`prerequisite_course_id`),
  ADD KEY `prerequisite_course_id` (`prerequisite_course_id`);

--
-- Chỉ mục cho bảng `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`registration_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Chỉ mục cho bảng `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Chỉ mục cho bảng `system_status`
--
ALTER TABLE `system_status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `registrations`
--
ALTER TABLE `registrations`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT cho bảng `system_status`
--
ALTER TABLE `system_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `class1`
--
ALTER TABLE `class1`
  ADD CONSTRAINT `class1_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `class1_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Các ràng buộc cho bảng `class2`
--
ALTER TABLE `class2`
  ADD CONSTRAINT `class2_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `class2_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Các ràng buộc cho bảng `class3`
--
ALTER TABLE `class3`
  ADD CONSTRAINT `class3_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `class3_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Các ràng buộc cho bảng `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Các ràng buộc cho bảng `completed_courses`
--
ALTER TABLE `completed_courses`
  ADD CONSTRAINT `completed_courses_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `completed_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Các ràng buộc cho bảng `prerequisites`
--
ALTER TABLE `prerequisites`
  ADD CONSTRAINT `prerequisites_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `prerequisites_ibfk_2` FOREIGN KEY (`prerequisite_course_id`) REFERENCES `courses` (`course_id`);

--
-- Các ràng buộc cho bảng `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
