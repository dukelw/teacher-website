<?php
require_once("./entities/teacher.class.php");
if (isset($_POST["email"]) && isset($_POST["password"])) {
    $success = Teacher::checkLogin($_POST["email"], $_POST["password"]);
    if ($success) {
        echo "Đăng nhập thành công";
    } else {
        echo "Đăng nhập thất bại";
    }
}
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Signin Template for Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/signin.css" rel="stylesheet">
    <form class="form-signin" action="#" method="POST">
        <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p class="mt-4">Chưa có tài khoản liên hệ <a href="#">thầy Dzoãn Thanh đẹp trai</a> để lấy tài khoản</p>
        <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>
    </body>

    </html>