<?php
include 'config.php'; // Kết nối đến cơ sở dữ liệu

// Xử lý khi người dùng gửi yêu cầu xóa lịch thi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_exam_schedule'])) {
    $delete_id = $_POST['delete_exam_schedule'];

    // Bắt đầu một giao dịch
    $conn->begin_transaction();

    try {
        // Xóa các bản ghi trong proctor_assignment trước
        $sql_delete_proctor_assignment = "DELETE FROM proctor_assignment WHERE exam_id = $delete_id";
        $conn->query($sql_delete_proctor_assignment);

        // Xóa các bản ghi trong exam_proctors
        $sql_delete_proctors = "DELETE FROM exam_proctors WHERE exam_schedule_id = $delete_id";
        $conn->query($sql_delete_proctors);

        // Cuối cùng xóa từ exam_schedule
        $sql_delete_schedule = "DELETE FROM exam_schedule WHERE id = $delete_id";
        $conn->query($sql_delete_schedule);

        // Commit giao dịch
        $conn->commit();
        echo "<div class='alert alert-success mt-3'>Đã xoá lịch thi thành công</div>";
    } catch (Exception $e) {
        // Rollback giao dịch nếu có lỗi xảy ra
        $conn->rollback();
        echo "<div class='alert alert-danger mt-3'>Lỗi khi xoá lịch thi: " . $e->getMessage() . "</div>";
    }
}
?>
