<?php
session_start();
require_once 'database.php';

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit();
}

$db = new Database();
$conn = $db->getConnection();

$message = ''; // Biến để lưu thông báo
$student_id = $_SESSION['student_id'];

// Xử lý đăng ký học lại
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject_id = $_POST['subject_id'];

    // Kiểm tra xem sinh viên đã có điểm không đạt ở môn học này chưa
    $grade_result = $db->select("SELECT grade FROM grades WHERE student_id = ? AND subject_id = ?", [$student_id, $subject_id]);

    if ($grade_result && $grade_result[0]['grade'] < 5.0) {
        // Kiểm tra xem đã đăng ký môn này chưa
        $registration_result = $db->select("SELECT * FROM registrations WHERE student_id = ? AND subject_id = ?", [$student_id, $subject_id]);
        if (empty($registration_result)) {
            // Thêm đăng ký học lại vào cơ sở dữ liệu
            $db->insert("INSERT INTO registrations (student_id, subject_id, status) VALUES (?, ?, 'Pending')", [$student_id, $subject_id]);
            $message = "Đăng ký học lại thành công.";
        } else {
            $message = "Bạn đã đăng ký môn học này rồi.";
        }
    } else {
        $message = "Sinh viên không cần đăng ký học lại môn này.";
    }
}

// Lấy danh sách đăng ký học lại của sinh viên
$registration_list = $db->select("
    SELECT r.subject_id, subj.name AS subject_name, r.status, r.rejection_reason
    FROM registrations r
    JOIN subjects subj ON r.subject_id = subj.subject_id
    WHERE r.student_id = ?
", [$student_id]);

$db->closeConnection();

// Mảng chuyển đổi trạng thái sang tiếng Việt
$status_translate = [
    'Pending' => 'Chờ duyệt',
    'Approved' => 'Đã duyệt',
    'Deleted' => 'Đã bị từ chối'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký học lại</title>
    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#">Hệ thống đăng ký học lại</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Đăng xuất</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container container-custom">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <h4 class="text-center">Menu</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="main.php">Trang chính</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_grades_student.php">Xem điểm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Thông tin cá nhân</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Đăng ký học lại</a>
                    </li>
                </ul>
            </div>

            <!-- Nội dung chính -->
            <div class="col-md-9">
                <div class="form-container">
                    <h2 class="text-center">Đăng ký học lại</h2>
                    <?php if (!empty($message)): ?>
                        <div class="alert alert-info alert-custom" role="alert">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>
                    <form id="registrationForm" action="register.php" method="POST">
                        <div class="form-group">
                            <label for="subject_id">Chọn môn học:</label>
                            <select class="form-control" name="subject_id" id="subject_id" required>
                                <!-- Dữ liệu môn học được tải từ cơ sở dữ liệu -->
                                <?php
                                $db = new Database();
                                $conn = $db->getConnection();
                                $subjects = $db->select("SELECT * FROM subjects");
                                foreach ($subjects as $subject) {
                                    echo "<option value='{$subject['subject_id']}'>{$subject['name']}</option>";
                                }
                                $db->closeConnection();
                                ?>
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#confirmationModal">Đăng ký học lại</button>
                    </form>

                    <!-- Modal Xác Nhận -->
                    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmationModalLabel">Xác nhận đăng ký</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc chắn muốn đăng ký học lại môn học này?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                    <button type="button" class="btn btn-primary" id="confirmButton">Xác nhận</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bảng hiển thị các yêu cầu đăng ký học lại -->
                    <h3 class="text-center mt-5">Các yêu cầu đăng ký học lại</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Môn học</th>
                                <th>Trạng thái</th>
                                <th>Lý do bị từ chối(nếu có)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($registration_list)): ?>
                                <?php foreach ($registration_list as $registration): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($registration['subject_name']); ?></td>
                                        <td class="<?php echo 'status-' . strtolower($registration['status']); ?>">
                                            <?php echo htmlspecialchars(isset($status_translate[$registration['status']]) ? $status_translate[$registration['status']] : $registration['status']); ?>
                                        </td>
                                        <td>
                                            <?php 
                                            // Hiển thị lý do bị từ chối chỉ khi trạng thái là "Deleted"
                                            if ($registration['status'] === 'Deleted') {
                                                echo htmlspecialchars($registration['rejection_reason']);
                                            } else {
                                                echo ''; // Hoặc để trống nếu không bị từ chối
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center">Không có yêu cầu đăng ký học lại.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
<footer class="footer mt-auto py-3 bg-dark text-white">
    <div class="container text-center">
        <span>&copy; 2024 Hệ thống đăng ký học lại. All Rights Reserved.</span>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="privacy.php" class="text-white">Chính sách bảo mật</a></li>
            <li class="list-inline-item"><a href="terms.php" class="text-white">Điều khoản sử dụng</a></li>
            <li class="list-inline-item"><a href="contact.php" class="text-white">Liên hệ</a></li>
        </ul>
    </div>
</footer>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('confirmButton').addEventListener('click', function() {
            document.getElementById('registrationForm').submit();
        });
    </script>
</body>
</html>
