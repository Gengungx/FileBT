-- Tạo 20 tài khoản người dùng và liên kết với bảng sinh viên
INSERT INTO users (username, password, role) 
VALUES 
    ('student01', PASSWORD('password1'), 'student'),
    ('student02', PASSWORD('password2'), 'student'),
    ('student03', PASSWORD('password3'), 'student'),
    ('student04', PASSWORD('password4'), 'student'),
    ('student05', PASSWORD('password5'), 'student'),
    ('student06', PASSWORD('password6'), 'student'),
    ('student07', PASSWORD('password7'), 'student'),
    ('student08', PASSWORD('password8'), 'student'),
    ('student09', PASSWORD('password9'), 'student'),
    ('student10', PASSWORD('password10'), 'student'),
    ('student11', PASSWORD('password11'), 'student'),
    ('student12', PASSWORD('password12'), 'student'),
    ('student13', PASSWORD('password13'), 'student'),
    ('student14', PASSWORD('password14'), 'student'),
    ('student15', PASSWORD('password15'), 'student'),
    ('student16', PASSWORD('password16'), 'student'),
    ('student17', PASSWORD('password17'), 'student'),
    ('student18', PASSWORD('password18'), 'student'),
    ('student19', PASSWORD('password19'), 'student'),
    ('student20', PASSWORD('password20'), 'student');

-- Lấy `id` của 20 tài khoản đã tạo và liên kết với bảng students
INSERT INTO students (user_id, name, class_id)
VALUES 
    ((SELECT id FROM users WHERE username = 'student01'), 'Nguyen Van A', 1),
    ((SELECT id FROM users WHERE username = 'student02'), 'Le Thi B', 1),
    ((SELECT id FROM users WHERE username = 'student03'), 'Tran Van C', 2),
    ((SELECT id FROM users WHERE username = 'student04'), 'Nguyen Van D', 2),
    ((SELECT id FROM users WHERE username = 'student05'), 'Le Thi E', 3),
    ((SELECT id FROM users WHERE username = 'student06'), 'Tran Van F', 3),
    ((SELECT id FROM users WHERE username = 'student07'), 'Nguyen Van G', 4),
    ((SELECT id FROM users WHERE username = 'student08'), 'Le Thi H', 4),
    ((SELECT id FROM users WHERE username = 'student09'), 'Tran Van I', 5),
    ((SELECT id FROM users WHERE username = 'student10'), 'Nguyen Van J', 5),
    ((SELECT id FROM users WHERE username = 'student11'), 'Le Thi K', 6),
    ((SELECT id FROM users WHERE username = 'student12'), 'Tran Van L', 6),
    ((SELECT id FROM users WHERE username = 'student13'), 'Nguyen Van M', 7),
    ((SELECT id FROM users WHERE username = 'student14'), 'Le Thi N', 7),
    ((SELECT id FROM users WHERE username = 'student15'), 'Tran Van O', 8),
    ((SELECT id FROM users WHERE username = 'student16'), 'Nguyen Van P', 8),
    ((SELECT id FROM users WHERE username = 'student17'), 'Le Thi Q', 9),
    ((SELECT id FROM users WHERE username = 'student18'), 'Tran Van R', 9),
    ((SELECT id FROM users WHERE username = 'student19'), 'Nguyen Van S', 10),
    ((SELECT id FROM users WHERE username = 'student20'), 'Le Thi T', 10);
