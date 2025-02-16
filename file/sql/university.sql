-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 25, 2024 lúc 11:11 PM
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
-- Cơ sở dữ liệu: `university`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `grades`
--

CREATE TABLE `grades` (
  `grade_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `grade` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `grades`
--

INSERT INTO `grades` (`grade_id`, `student_id`, `subject_id`, `grade`) VALUES
(1, 1, 1, 6.5),
(2, 1, 2, 4),
(3, 1, 3, 8),
(4, 1, 4, 7.5),
(5, 1, 5, 3.5),
(6, 2, 1, 5),
(7, 2, 2, 6),
(8, 2, 3, 7),
(9, 2, 4, 9),
(10, 2, 5, 4.5),
(11, 3, 1, 4.5),
(12, 3, 2, 3),
(13, 3, 3, 5.5),
(14, 3, 4, 6),
(15, 3, 5, 7.5),
(16, 4, 1, 9),
(17, 4, 2, 8.5),
(18, 4, 3, 5),
(19, 4, 4, 7),
(20, 4, 5, 4),
(21, 5, 1, 7),
(22, 5, 2, 6.5),
(23, 5, 3, 7.5),
(24, 5, 4, 8),
(25, 5, 5, 4.5),
(26, 6, 1, 4),
(27, 6, 2, 5.5),
(28, 6, 3, 6),
(29, 6, 4, 3.5),
(30, 6, 5, 4.5),
(31, 7, 1, 6),
(32, 7, 2, 7),
(33, 7, 3, 8.5),
(34, 7, 4, 9),
(35, 7, 5, 5),
(36, 8, 1, 5.5),
(37, 8, 2, 7.5),
(38, 8, 3, 6),
(39, 8, 4, 8),
(40, 8, 5, 9),
(41, 9, 1, 3.5),
(42, 9, 2, 4.5),
(43, 9, 3, 5),
(44, 9, 4, 6.5),
(45, 9, 5, 7),
(46, 10, 1, 6),
(47, 10, 2, 5),
(48, 10, 3, 7.5),
(49, 10, 4, 8),
(50, 10, 5, 6.5),
(51, 11, 1, 8),
(52, 11, 2, 7.5),
(53, 11, 3, 6.5),
(54, 11, 4, 5),
(55, 11, 5, 9),
(56, 12, 1, 7.5),
(57, 12, 2, 8.5),
(58, 12, 3, 6),
(59, 12, 4, 5),
(60, 12, 5, 7),
(61, 13, 1, 6.5),
(62, 13, 2, 5.5),
(63, 13, 3, 4),
(64, 13, 4, 8),
(65, 13, 5, 7.5),
(66, 14, 1, 5),
(67, 14, 2, 4.5),
(68, 14, 3, 7),
(69, 14, 4, 6.5),
(70, 14, 5, 8),
(71, 15, 1, 9),
(72, 15, 2, 8.5),
(73, 15, 3, 7.5),
(74, 15, 4, 5),
(75, 15, 5, 6),
(76, 16, 1, 4),
(77, 16, 2, 3.5),
(78, 16, 3, 5.5),
(79, 16, 4, 6),
(80, 16, 5, 7),
(81, 17, 1, 7),
(82, 17, 2, 5),
(83, 17, 3, 6),
(84, 17, 4, 7.5),
(85, 17, 5, 9),
(86, 18, 1, 6.5),
(87, 18, 2, 8),
(88, 18, 3, 7.5),
(89, 18, 4, 9),
(90, 18, 5, 5),
(91, 19, 1, 5.5),
(92, 19, 2, 6.5),
(93, 19, 3, 4.5),
(94, 19, 4, 7),
(95, 19, 5, 6),
(96, 20, 1, 10),
(97, 20, 2, 10),
(98, 20, 3, 10),
(99, 20, 4, 10),
(100, 20, 5, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `registrations`
--

CREATE TABLE `registrations` (
  `registration_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Đang xử lí',
  `rejection_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `registrations`
--

INSERT INTO `registrations` (`registration_id`, `student_id`, `subject_id`, `status`, `rejection_reason`) VALUES
(9, 2, 5, 'Approved', NULL),
(14, 3, 2, 'Approved', NULL),
(19, 4, 5, 'Approved', NULL),
(23, 9, 2, 'Deleted', 'âsas'),
(24, 9, 1, 'Approved', NULL),
(25, 19, 3, 'Deleted', 's'),
(26, 16, 1, 'Deleted', 'a'),
(27, 1, 2, 'Approved', NULL),
(28, 1, 5, 'Deleted', 'âsa');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `students`
--

INSERT INTO `students` (`student_id`, `name`, `email`, `phone`) VALUES
(1, 'Nguyễn Văn A', 'nguyenvana@example.com', '0901000001'),
(2, 'Trần Thị B', 'tranthib@example.com', '0901000002'),
(3, 'Lê Văn C', 'levanc@example.com', '0901000003'),
(4, 'Phạm Thị D', 'phamthid@example.com', '0901000004'),
(5, 'Vũ Thị E', 'vuthie@example.com', '0901000005'),
(6, 'Hoàng Văn F', 'hoangvanf@example.com', '0901000006'),
(7, 'Đặng Thị G', 'dangthig@example.com', '0901000007'),
(8, 'Nguyễn Văn H', 'nguyenvanh@example.com', '0901000008'),
(9, 'Trần Thị I', 'tranthii@example.com', '0901000009'),
(10, 'Lê Văn J', 'levanj@example.com', '0901000010'),
(11, 'Phạm Thị K', 'phamthik@example.com', '0901000011'),
(12, 'Vũ Thị L', 'vuthil@example.com', '0901000012'),
(13, 'Hoàng Văn M', 'hoangvanm@example.com', '0901000013'),
(14, 'Đặng Thị N', 'dangthin@example.com', '0901000014'),
(15, 'Nguyễn Văn O', 'nguyenvano@example.com', '0901000015'),
(16, 'Trần Thị P', 'tranthip@example.com', '0901000016'),
(17, 'Lê Văn Q', 'levanq@example.com', '0901000017'),
(18, 'Phạm Thị R', 'phamthir@example.com', '0901000018'),
(19, 'Vũ Thị S', 'vuthis@example.com', '0901000019'),
(20, 'admin', 'admin@gmail.com', '0901000020');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `subjects`
--

INSERT INTO `subjects` (`subject_id`, `name`) VALUES
(1, 'C++'),
(2, 'C#'),
(3, 'Cơ sở dữ liệu'),
(4, 'PHP'),
(5, 'Java');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `student_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `student_id`) VALUES
(1, 'student1', '7c6a180b36896a0a8c02787eeafb0e4c', 1),
(2, 'student2', '6cb75f652a9b52798eb6cf2201057c73', 2),
(3, 'student3', '819b0643d6b89dc9b579fdfc9094f28e', 3),
(4, 'student4', '34cc93ece0ba9e3f6f235d4af979b16c', 4),
(5, 'student5', 'db0edd04aaac4506f7edab03ac855d56', 5),
(6, 'student6', '218dd27aebeccecae69ad8408d9a36bf', 6),
(7, 'student7', '00cdb7bb942cf6b290ceb97d6aca64a3', 7),
(8, 'student8', 'b25ef06be3b6948c0bc431da46c2c738', 8),
(9, 'student9', '5d69dd95ac183c9643780ed7027d128a', 9),
(10, 'student10', '87e897e3b54a405da144968b2ca19b45', 10),
(11, 'student11', '1e5c2776cf544e213c3d279c40719643', 11),
(12, 'student12', 'c24a542f884e144451f9063b79e7994e', 12),
(13, 'student13', 'ee684912c7e588d03ccb40f17ed080c9', 13),
(14, 'student14', '8ee736784ce419bd16554ed5677ff35b', 14),
(15, 'student15', '9141fea0574f83e190ab7479d516630d', 15),
(16, 'student16', '2b40aaa979727c43411c305540bbed50', 16),
(17, 'student17', 'a63f9709abc75bf8bd8f6e1ba9992573', 17),
(18, 'student18', '80b8bdceb474b5127b6aca386bb8ce14', 18),
(19, 'student19', 'e532ae6f28f4c2be70b500d3d34724eb', 19),
(20, 'admin', 'aee67d9bb569ad1562f7b67cfccbd2ef', 20);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Chỉ mục cho bảng `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`registration_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Chỉ mục cho bảng `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Chỉ mục cho bảng `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `grades`
--
ALTER TABLE `grades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT cho bảng `registrations`
--
ALTER TABLE `registrations`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`);

--
-- Các ràng buộc cho bảng `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`);

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
