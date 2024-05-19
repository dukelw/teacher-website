<?php
// Import class Teacher
require_once ("./entities/teacher.class.php");

// Lấy danh sách giáo viên từ cơ sở dữ liệu
$teachers = User::list_user();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">
    <title>Introduction</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/blog/">
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <link rel="icon" href="./assets/images/logo.svg" type="image/x-icon" />
    <link href="./assets/css/blog.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/icon/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="./css/list_teacher.css">
    <script src="./assets/js/jquery-slim.min.js"></script>
    <script src="./assets/js/holder.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
</head>

<body>
    <div class="container">
        <?php include_once ("./header.php");
        ?>

        <div class="row">
            <div class="main-content col-xs-12 col-md-9 sb-r">
                <h1>Danh sách giáo viên</h1>
                <table class="list-teacher" border="1">
                    <tr>
                        <th>Nhân sự</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Giới tính</th>
                        <th>Điện thoại</th>
                        <th>Chức vụ</th>
                    </tr>
                    <?php foreach ($teachers as $teacher): ?>
                        <tr>
                            <td><img style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%"
                                    src="<?php echo $teacher['AVATAR']; ?>" alt="Ảnh đại diện"></td>
                            <td><?php echo $teacher['NAME']; ?></td>
                            <td><?php echo $teacher['MAIL']; ?></td>
                            <td><?php echo $teacher['GENDER'] ? 'Nam' : 'Nữ'; ?></td>
                            <td><?php echo $teacher['PHONE']; ?></td>
                            <td><?php echo $teacher['POSITION']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div
                class="col-lg-3 col-md-3 col-sm-12 col-xs-12 sidebar sidebar-right theiaStickySidebar">
                <?php include_once ("./introduction-sidebar.php");
                ?>
            </div>

        </div>

        <?php include_once ("./footer.php");
        ?>
    </div>
</body>