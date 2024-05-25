<?php include_once ("../entities/slide.class.php");
if (isset($_POST["btnsubmit"])) {
  $file = $_FILES["txtFile"];
  $filepath = $file;
  $newSlide = new Slide($filepath);
  $result = $newSlide->
    save();
  if ($result) {
    header("Location: dashboard.php");
  } else {
    echo "Thêm thất bại";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <!-- My CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous">
  <script src="../assets/js/jquery-slim.min.js"></script>
  <script src="../assets/js/holder.min.js"></script>
  <script src="../assets/js/popper.min.js"></script>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/dashboard.css">
  <link href="../css/add_slide.css" rel="stylesheet">
  <title>Thêm slide</title>
</head>

<body>
  <!-- SIDEBAR -->
  <section id="sidebar">
    <a href="#" class="brand">
      <i class='bx bxs-smile'></i>
      <span class="text">Dashboard</span>
    </a>
    <ul class="side-menu top">
      <li>
        <a href="dashboard.php">
          <i class='bx bxs-dashboard'></i>
          <span class="text">Trang chủ</span>
        </a>
      </li>
      <li>
        <a class="navigate" href="add_article.php">
          <i class='bx bx bxs-calendar-check'></i>
          <span class="text">Thêm bài viết</span>
        </a>
      </li>
      <li>
        <a class="navigate" href="add_document.php">
          <i class='bx bx bxs-calendar-check'></i>
          <span class="text">Thêm tài liệu</span>
        </a>
      </li>
      <li class="active">
        <a class="navigate" href="add_slide.php">
          <i class='bx bx bxs-calendar-check'></i>
          <span class="text">Thêm slide</span>
        </a>
      </li>
    </ul>
    <ul class="side-menu">
      <li>
        <a href="main.php">
          <i class='bx bx-user-circle'></i>
          <span class="text">Về trang người dùng</span>
        </a>
      </li>
      <li>
        <a href="signin.php" class="logout">
          <i class='bx bxs-log-out-circle'></i>
          <span class="text">Đăng xuất</span>
        </a>
      </li>
    </ul>
  </section>
  <section id="content">
    <nav>
      <i class='bx bx-menu'></i>
      <a class="navigate" href="#" class="nav-link">Categories</a>
      <form action="#">
        <div class="form-input">
          <input type="search" placeholder="Search...">
          <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
        </div>
      </form>
      <input type="checkbox" id="switch-mode" hidden>
      <label for="switch-mode" class="switch-mode"></label>
      <a class="navigate" href="#" class="notification">
        <i class='bx bxs-bell'></i>
        <span class="num">8</span>
      </a>
      <a class="navigate" href="update_info.php" class="profile">
        <?php
        if (isset($user[0]['AVATAR']) && !empty($user[0]['AVATAR'])) {
          echo '<img style=\'width: 36px;height: 36px;object-fit: cover;border-radius: 50%;\' src="' . $user[0]['AVATAR'] . '">';
        } else {
          echo '<img style=\'width: 36px;height: 36px;object-fit: cover;border-radius: 50%;\' src="https://i.pinimg.com/originals/ac/0b/3b/ac0b3b4f2f7c1a89e045b2f186d6f7e1.jpg">';
        }
        ?>
      </a>
    </nav>

    <main id="main">
      <div class="head-title">
        <div class="left">
          <h1>Dashboard</h1>
          <ul class="breadcrumb">
            <li>
              <a class="navigate" href="dashboard.php">Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
              <a class="active" class="navigate" href="#">Thêm slide</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="col-12 d-flex justify-content-between align-items-center">
        <form enctype="multipart/form-data" class="col-12 row g-3 needs-validation" method="post"
          action="add_slide.php" novalidate>
          <div class="col-md-6">
            <label for="file" class="form-label">Slide</label>
            <input type="file" name="txtFile" class="form-control" id="thumbnail" required>
            <div class="invalid-feedback">
              Please provide a valid city.
            </div>
          </div>
          <div class="col-md-4 d-flex flex-column">
            <label for="file" class="form-label">Hình ảnh</label>
            <img style="width: 150px; height: 150px;" id="preview" src="" alt="">
          </div>
          <div class="col-md-2">
            <button class="btn btn-primary" name="btnsubmit" type="submit">Lưu thay đổi</button>
          </div>
        </form>
    </main>
  </section>
</body>

</html>

<style>
  a {
    text-decoration: none !important;
  }

  ul {
    padding-left: 0 !important;
  }

  label {
    color: var(--dark);
  }

  .breadcrumb {
    background-color: unset !important;
  }
</style>

<script>
  const thumbnailInput = document.querySelector('#thumbnail');
  const previewImg = document.querySelector('#preview');

  thumbnailInput.addEventListener('change', function () {
    if (thumbnailInput.files && thumbnailInput.files[0]) {
      const reader = new FileReader();
      reader.onload = function (e) {
        previewImg.src = e.target.result;
      };

      reader.readAsDataURL(thumbnailInput.files[0]);
    }
  });
</script>

<script src='../js/dashboard.js'></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
  integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
  integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
  crossorigin="anonymous"></script>