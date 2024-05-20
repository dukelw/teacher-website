<?php
include_once("../entities/user.class.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["avatar"])) {
        $_POST["avatar"] = ''; // Đặt giá trị mặc định cho avatar là chuỗi rỗng
    }
    // Lấy dữ liệu từ form
    $name = $_POST["full-name"];
    $mail = $_POST["email"];
    $password = $_POST["password"];
    $gender = "";
    if (isset($_POST['gender']) && !empty($_POST['gender'])) {
        $gender = $_POST['gender'];
    }
    $phone = $_POST["phone"];
    $birthday = $_POST["birth-day"];
    $address = "";

    // Tạo đối tượng User
    $user = new User($name, $mail, $password, $_POST["avatar"], $gender, $phone, $birthday, $address);

    // Lưu thông tin người dùng
    $result = $user->signUp();

    // Kiểm tra kết quả
    if ($result) {
        header("Location: main.php"); // Chuyển hướng về trang chính
        exit; // Dừng kịch bản hiện tại sau khi thực hiện chuyển hướng
    } else {
        echo "Đăng ký thất bại!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/signup.css">
</head>

<body>
    <div class="container">
        <div class="title">Sign Up</div>
        <form class="row" action="" novalidate method="POST">
            <!-- First name and last name -->
            <div class="col-md-12 m-2">
                <div class="row">
                    <!-- First Name -->
                    <div class="col">
                        <label for="full-name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Full Name" id="full-name" name="full-name" required />
                        <div class="invalid-feedback">
                            Please enter a valid Full Name
                        </div>
                    </div>
                </div>
            </div>
            <!-- Email -->
            <div class="col-md-12 m-2">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" placeholder="Email" id="email" name="email" required />
                <div class="invalid-feedback">Please enter a valid Email</div>
            </div>

            <!-- Phone -->
            <div class="col-md-12 m-2">
                <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" placeholder="Phone" id="phone" name="phone" required />
                <div class="invalid-feedback">Please enter a valid Phone</div>
            </div>

            <div class="col-md-12 m-2">
                <label for="birth-day" class="form-label">Birthday <span class="text-danger">*</span></label>
                <input type="date" class="form-control" placeholder="Birth day" id="birth-day" name="birth-day" required />
                <div id="birthday-feedback" class="invalid-feedback">Please enter a valid Birthday</div>
            </div>

            <!-- radio button -->
            <div class="col-md-12 m-2">
                <span>Gender<span class="text-danger">*</span></span>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="radioCheck1" name="gender" value="1" required />
                    <label class="form-check-label" for="radioCheck1">Male</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="radioCheck2" name="gender" value="0" required />
                    <label class="form-check-label" for="radioCheck2">Female</label>
                    <div class="valid-feedback">Option validated</div>
                    <div class="invalid-feedback">
                        Please select a valid option
                    </div>
                </div>
            </div>

            <!-- Password -->
            <div class="col-md-12 m-2">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" placeholder="Password" id="password" name="password" required />
            </div>

            <div class="col-md-12 m-2">
                <label for="confirm-password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" placeholder="Confirm Password" id="confirm-password" name="confirm-password" required />
                <div id="password-feedback" class="invalid-feedback">Passwords do not match</div>
            </div>

            <div class="col-md-12 m-2">
                <button id="submitBtn" class="btn btn-primary" type="submit">
                    Sign Up
                </button>
            </div>
            <a href="main.php" class="back" style="text-align: center;">Về trang chủ</a>
        </form>
    </div>

</body>

<script>
    const form = document.querySelector("form");

    form.addEventListener(
        "submit",
        (e) => {
            // Kiểm tra xem form đã được validate không
            if (!form.checkValidity()) {
                e.preventDefault();
            }

            // Kiểm tra và hiển thị các feedback của các trường đã nhập
            Array.from(form.elements).forEach((input) => {
                if (input.type !== "submit") {
                    if (!input.checkValidity()) {
                        input.classList.add('is-invalid');
                        input.classList.remove('is-valid');
                    } else {
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                    }

                    // Kiểm tra xem birth-day có lớn hơn ngày hiện tại không và không được để trống
                    if (input.name === "birth-day") {
                        const birthday = new Date(input.value);
                        const today = new Date();
                        if (input.value === "" || birthday > today) {
                            e.preventDefault();
                            input.classList.add('is-invalid');
                            input.classList.remove('is-valid');
                            document.getElementById("birthday-feedback").style.display = "block";
                        } else {
                            input.classList.remove('is-invalid');
                            input.classList.add('is-valid');
                            document.getElementById("birthday-feedback").style.display = "none";
                        }
                    }

                    // Kiểm tra xem mật khẩu và xác nhận mật khẩu có giống nhau không
                    if (input.name === "confirm-password") {
                        const password = document.getElementById("password").value;
                        const confirmPassword = document.getElementById("confirm-password").value;
                        if (password !== confirmPassword) {
                            e.preventDefault();
                            document.getElementById("password-feedback").style.display = "block";
                            input.classList.remove('is-valid');
                            input.classList.add('is-invalid');
                        } else {
                            document.getElementById("password-feedback").style.display = "none";
                        }
                    }
                }
            });

        },
        false
    );
</script>

</html>