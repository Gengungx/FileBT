<?php
require_once 'database.php';

// Bắt đầu phiên làm việc
session_start();

// Kiểm tra quyền của người dùng
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Tạo kết nối cơ sở dữ liệu
$db = new Database();
$conn = $db->getConnection();

// Câu lệnh SQL để lấy tất cả dữ liệu cần thiết
$query = "SELECT s.student_id, s.name AS student_name, subj.name AS subject_name, r.status
          FROM registrations r
          JOIN students s ON r.student_id = s.student_id
          JOIN subjects subj ON r.subject_id = subj.subject_id
          ORDER BY CASE
               WHEN r.status = 'Pending' THEN 1
               WHEN r.status = 'Approved' THEN 2
               WHEN r.status = 'Deleted' THEN 3
          END";

$result = $db->select($query);
$db->closeConnection();

// Tạo thư mục nếu chưa tồn tại
$directory = 'reports';
if (!is_dir($directory)) {
    mkdir($directory, 0755, true);
}

// Tạo tên tệp dựa trên thời gian hiện tại để tránh trùng lặp
$filename = 'report_' . date('Ymd_His') . '.csv';
$filepath = $directory . '/' . $filename;

// Mở tệp CSV để ghi dữ liệu
$output = fopen($filepath, 'w');

// Ghi tiêu đề cột
fputcsv($output, ['ID Sinh viên', 'Sinh viên', 'Môn học', 'Trạng thái']);

// Mảng chuyển đổi trạng thái
$status_translate = [
    'Pending' => 'Chờ duyệt',
    'Approved' => 'Đã duyệt',
    'Deleted' => 'Đã từ chối'
];

// Ghi dữ liệu vào tệp CSV
foreach ($result as $row) {
    $status = isset($status_translate[$row['status']]) ? $status_translate[$row['status']] : $row['status'];
    fputcsv($output, [$row['student_id'], $row['student_name'], $row['subject_name'], $status]);
}

// Đóng tệp CSV
fclose($output);

// Lưu thông báo vào session và chuyển hướng trở lại trang admin
$_SESSION['report_message'] = "Báo cáo đã được xuất thành công! Bạn có thể <a href='$filepath' >tải xuống báo cáo</a> hoặc <a href='admin.php'>huỷ</a>.";
header('Location: admin.php');
exit();
?>
