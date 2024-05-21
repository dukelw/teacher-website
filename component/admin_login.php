<?php
include_once("../entities/article.class.php");
require_once("../entities/user.class.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $password = trim($_POST["password"]);

    if ($email && $password) {
      $success = User::checkAdmin($email, $password);
      if ($success) {
        session_start();
        $username = User::get_user($email);
        $_SESSION['adminid'] = $username[0]['ID'];
        $_SESSION['adminname'] = $username[0]["NAME"];
        $_SESSION['adminemail'] = $email;
        $_SESSION['adminthumb'] = $username[0]['AVATAR'];
        $_SESSION['userid'] = $username[0]['ID'];
        $_SESSION['username'] = $username[0]["NAME"];
        $_SESSION['useremail'] = $email;
        $_SESSION['userthumb'] = $username[0]['AVATAR'];

        if (isset($_POST["remember"])) {
          $remember = $_POST["remember"];
          setcookie("remember_email", $email, time() + 3600 * 24 * 365);
          setcookie("remember_password", $username[0]['PASSWORD'], time() + 3600 * 24 * 365);
        } else {
          setcookie("remember_email", "", time() - 36000);
          setcookie("remember_password", "", time() - 3600);
        }
        header('Location: dashboard.php');
        exit();
      } else {
        $error_message = "Sai thông tin quản trị viên!";
      }
    } else {
      $error_message = "Vui lòng nhập email và mật khẩu hợp lệ!";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/admin_login.css">
  <title>Dashboard Login</title>
</head>

<body>

  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row border rounded-5 p-3 bg-white shadow box-area">
      <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe;">
        <div class="featured-image mb-3">
          <img src="../assets/images/login.png" class="img-fluid" style="width: 250px;">
        </div>
        <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Ngày mới tốt lành</p>
        <small class="text-white text-wrap text-center" style="width: 17rem; font-family: 'Courier New', Courier, monospace;">Đăng nhập để quản lý trang web của bạn.</small>
      </div>

      <form method="POST" action="" class="col-md-6 right-box needs-validation" novalidate>
        <div class="row align-items-center">
          <div class="header-text mb-4">
            <h2>Xin chào</h2>
            <p>Chào mừng trở lại, quản trị viên.</p>
          </div>
          <?php if (!empty($error_message)) : ?>
            <div class="alert alert-danger" role="alert">
              <?= $error_message ?>
            </div>
          <?php endif; ?>
          <div class="input-group mb-3">
            <input value="<?php
                          if (isset($_COOKIE["remember_email"])) {
                            echo $_COOKIE["remember_email"];
                          }
                          ?>" type="email" name="email" class="form-control form-control-lg bg-light fs-6" placeholder="Email" required>
            <div class="invalid-feedback">
              Vui lòng nhập email hợp lệ.
            </div>
          </div>
          <div class="input-group mb-3">
            <input value="<?php
                          if (isset($_COOKIE["remember_password"])) {
                            echo $_COOKIE["remember_password"];
                          }
                          ?>" type="password" name="password" class="form-control form-control-lg bg-light fs-6" placeholder="Mật khẩu" required>
            <div class="invalid-feedback">
              Vui lòng nhập mật khẩu.
            </div>
          </div>
          <div class="input-group mb-5 d-flex justify-content-between">
            <div class="form-check">
              <input type="checkbox" name="remember" class="form-check-input" id="formCheck">
              <label for="formCheck" class="form-check-label text-secondary"><small>Ghi nhớ đăng nhập</small></label>
            </div>
            <div class="forgot">
              <small><a href="forgot_password.php">Quên mật khẩu?</a></small>
            </div>
          </div>
          <div class="input-group mb-3">
            <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Đăng nhập</button>
          </div>
          <div class="row">
            <small>Không phải quản trị viên? <a href="main.php">Quay về trang chủ</a></small>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2cQm3DqH/c5b14n6IMzFDzN8L+6cT+PbyX5envvbCf9p83Mjdshz95NIy9J" crossorigin="anonymous"></script>
  <script>
    (function() {
      'use strict'
      var forms = document.querySelectorAll('.needs-validation')

      Array.prototype.slice.call(forms)
        .forEach(function(form) {
          form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }
            form.classList.add('was-validated')
          }, false)
        })
    })()
  </script>
</body>

</html>