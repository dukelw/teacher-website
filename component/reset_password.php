<?php
require_once("../entities/user.class.php");

$message = ""; // Khởi tạo biến message

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Khi form được gửi đi với mật khẩu mới
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        if ($newPassword === $confirmPassword) {
            // Gọi phương thức resetPassword từ lớp User
            $resetSuccess = User::resetPassword($token, $newPassword);

            if ($resetSuccess) {
                // Nếu mật khẩu được đặt lại thành công, set message
                $message = "Mật khẩu của bạn đã được đặt lại thành công.";
                // Chuyển hướng người dùng về trang chủ
                header('Location: main.php');
                exit; // Kết thúc luồng xử lý PHP
            } else {
                // Nếu có lỗi xảy ra trong quá trình đặt lại mật khẩu
                $message = "Có lỗi xảy ra. Vui lòng thử lại.";
            }
        } else {
            // Nếu mật khẩu không khớp
            $message = "Mật khẩu không khớp. Vui lòng nhập lại.";
        }
    }
} else {
    // Nếu token không hợp lệ
    $message = "Token không hợp lệ.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/forgot_password.css">
</head>
<body>
<div class="container">
    <div class="title">Forgot password</div>
    
    <!-- Alert box -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-<?php echo strpos($message, 'không') !== false ? 'danger' : 'success'; ?> mt-3 text-center" role="alert">
            <div><?php echo $message; ?></div>
        </div>
    <?php endif; ?>

    <form class="row" method="POST">
        <!-- New Password -->
        <div class="col-md-12 m-2">
            <label for="new_password" class="form-label">New Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" placeholder="New Password" id="new_password" name="new_password" required />
            <div class="invalid-feedback">Please enter a valid Password</div>
        </div>

        <!-- Confirm Password -->
        <div class="col-md-12 m-2">
            <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" placeholder="Confirm Password" id="confirm_password" name="confirm_password" required />
            <div class="invalid-feedback">Please enter a valid Password</div>
        </div>

        <div class="col-md-12 m-2">
            <button id="submitBtn" class="btn btn-primary" type="submit">
                Submit
            </button>
        </div>
        
        <a href="../main.php" class="back" style="text-align: center;">Về trang chủ</a>
    </form>
</div>
</body>
</html>
