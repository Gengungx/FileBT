$(document).ready(function() {
    $('.delete-btn').on('click', function() {
        var id = $(this).data('id');
        var row = $('#row-' + id);

        if (confirm('Bạn có chắc chắn muốn xóa mục này không?')) {
            $.ajax({
                url: 'delete.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    if (response.trim() === 'success') {
                        row.remove();
                        alert('Xóa mục thành công!');
                    } else {
                        alert('Lỗi khi xóa mục!');
                    }
                },
                error: function() {
                    alert('Đã xảy ra lỗi. Vui lòng thử lại.');
                }
            });
        }
    });
});
