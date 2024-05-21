<?php
require_once("../entities/user.class.php");
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    if (User::forgotPassword($email)) {
        $message = "Email đã được gửi để đặt lại mật khẩu.";
    } else {
        $message = "Có lỗi xảy ra khi gửi email hoặc địa chỉ mail không đúng.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/forgot_password.css">
</head>

<body>
    <div class="container">
        <div class="title">Quên mật khẩu</div>
        <form class="row" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Alert Box -->
            <?php if ($message) : ?>
                <div class="alert alert-<?php echo strpos($message, 'lỗi') !== false ? 'danger' : 'success'; ?> mt-3 text-center" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <!-- Email -->
            <div class="col-md-12 m-2">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" placeholder="Email" id="email" name="email" required />
                <div class="invalid-feedback">Please enter a valid Email</div>
            </div>

            <div class="col-md-12 m-2">
                <button id="submitBtn" class="btn btn-primary" type="submit">
                    Gửi đường dẫn khôi phục
                </button>

            </div>
            <a href="main.php" class="back" style="text-align: center;">Về trang chủ</a>

        </form>
    </div>

</body>

</html>