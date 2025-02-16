<?php
// Đường dẫn tới thư mục bạn muốn tạo
$directory = 'reports';

// Kiểm tra xem thư mục đã tồn tại chưa
if (!is_dir($directory)) {
    // Thử tạo thư mục
    if (mkdir($directory, 0755, true)) {
        echo "Thư mục '$directory' đã được tạo thành công.";
    } else {
        echo "Không thể tạo thư mục '$directory'.";
    }
} else {
    echo "Thư mục '$directory' đã tồn tại.";
}
?>
