<?php
session_start();

// Kiểm tra quyền admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đăng ký học lại</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        html, body {
            height: 100%; /* Đặt chiều cao cho body và html */
            margin: 0; /* Bỏ margin */
        }

        .table-container {
            min-height: calc(100vh - 100px); /* Chiều cao tối thiểu cho vùng nội dung */
        }

        footer {
            background-color: #f8f9fa;
            padding: 10px 0;
            text-align: center;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand text-white" href="#">Quản lý đăng ký học lại</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="view_grades.php">Xem bảng điểm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="logout.php">Đăng xuất</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container table-container">
        <h2 class="text-center">Quản lý đăng ký học lại</h2>

        <!-- Thông báo xuất báo cáo -->
        <?php
        if (isset($_SESSION['report_message'])) {
            echo "<div class='alert alert-success'>" . $_SESSION['report_message'] . "</div>";
            unset($_SESSION['report_message']);
        }
        ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Sinh viên</th>
                    <th>Sinh viên</th>
                    <th>Môn học</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once 'database.php';
                $db = new Database();
                $conn = $db->getConnection();

                // Mảng chuyển đổi trạng thái
                $status_translate = [
                    'Pending' => 'Chờ duyệt',
                    'Approved' => 'Đã duyệt',
                    'Deleted' => 'Đã từ chối'
                ];

                // Lấy dữ liệu và sắp xếp theo trạng thái
                $result = $db->select("SELECT r.registration_id, s.student_id, s.name AS student_name, subj.name AS subject_name, r.status
                                       FROM registrations r
                                       JOIN students s ON r.student_id = s.student_id
                                       JOIN subjects subj ON r.subject_id = subj.subject_id
                                       ORDER BY CASE
                                            WHEN r.status = 'Pending' THEN 1
                                            WHEN r.status = 'Approved' THEN 2
                                            WHEN r.status = 'Deleted' THEN 3
                                       END");

                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['subject_name']) . "</td>";
                    // Sử dụng mảng để chuyển đổi trạng thái
                    $status = isset($status_translate[$row['status']]) ? $status_translate[$row['status']] : $row['status'];
                    echo "<td>" . htmlspecialchars($status) . "</td>";
                    if ($row['status'] == 'Pending') {
                        echo "<td>
                                <a href='action.php?id={$row['registration_id']}&action=approve' class='btn btn-sm btn-success'>Duyệt</a>
                                <a href='#' class='btn btn-sm btn-danger' data-toggle='modal' data-target='#rejectModal' data-id='{$row['registration_id']}'>Xóa</a>
                              </td>";
                    } else {
                        echo "<td>Đã xử lý</td>";
                    }
                    echo "</tr>";
                }

                $db->closeConnection();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Nhập Lý Do Từ Chối -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="delete.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">Nhập lý do từ chối</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="registration_id" id="modalRegistrationId">
                        <div class="form-group">
                            <label for="rejection_reason">Lý do từ chối:</label>
                            <textarea class="form-control" name="rejection_reason" id="rejection_reason" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#rejectModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            var modal = $(this);
            modal.find('#modalRegistrationId').val(id);
        });
    </script>

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
</body>
</html>
