<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="icon" href="Favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>PHP/MYSQL</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="login.php" style="font-weight: bold">Login</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto"> 
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-head mb-3">Đăng Nhập</div>
            <?php
            if (isset($_GET['errors'])) {
                $errors = json_decode($_GET['errors'], true);
                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        echo '<p>' . htmlspecialchars($error) . '</p>';
                    }
                }
            }
            ?>
            <form method="post" action="login.php">
                <div class="form-group row">
                    <label for="username" class="col-md-5 col-form-label text-md-3">Tên tài khoản</label>
                    <div class="col-md-6">
                    <input type="text" class="form-control" name="username" id="username" placeholder="">
                </div>
        </div>
                <div class="form-group row">
                    <label for="password" class="col-md-5 col-form-label text-md-3">Mật khẩu</label>
                    <div class="col-md-6">
                    <input type="password" class="form-control" name="password" id="password" placeholder="">
                </div>
        </div>
                <div class="col text-center">
                <button type="submit" name="login" class="btn btn-primary mb-2">Đăng nhập</button>
                </div>
            </form>
                    </div>
                </div>
</main>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="script.js"></script>
</body>
</html>
