<?php
include_once("./entities/document.class.php");
include_once("./entities/doccategory.class.php");
include_once("./entities/major.class.php");

if (isset($_POST["btnsubmit"])) {
  $title = $_POST["txtName"];
  $category = intval($_POST["txtCategory"]);
  $major = intval($_POST["txtMajor"]);
  $description = $_POST["txtDescription"];
  $file = $_FILES["txtFile"];

  $publish = date("Y-m-d");
  $docfile = $file;
  $newDocument = new Document($title, $description, $category, $docfile, $publish, $major);
  $result = $newDocument->save();
  if ($result) {
    header("Location: dashboard.php");
  } else {
    echo "Thêm thất bại";
  }
}

if (isset($_POST["btnmajorsubmit"])) {
  $majorName = $_POST["txtMajorName"];
  $majorDescription = $_POST["txtMajorDescription"];

  $newMajor = new Major($majorName, $majorDescription);
  $result = $newMajor->save();
  if ($result) {
    header("Location: add_document.php");
  } else {
    echo "Thêm thất bại";
  }
}

if (isset($_POST["btncategorysubmit"])) {
  $categoryName = $_POST["txtCategoryName"];
  $newCategory = new Doccategory($categoryName);
  $result = $newCategory->save();
  if ($result) {
    header("Location: add_document.php");
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="./assets/js/jquery-slim.min.js"></script>
  <script src="./assets/js/holder.min.js"></script>
  <script src="./assets/js/popper.min.js"></script>
  <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/dashboard.css">
  <link href="./css/add_document.css" rel="stylesheet">
  <title>Thêm tài liệu</title>
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
      <li class="active">
        <a class="navigate" href="add_document.php">
          <i class='bx bx bxs-calendar-check'></i>
          <span class="text">Thêm tài liệu</span>
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
              <a class="active" class="navigate" href="#">Thêm tài liệu</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="mt-4">
        <form enctype="multipart/form-data" class="row g-3 needs-validation" method="post" action="add_document.php" novalidate>
          <div class="col-md-6">
            <label for="name" class="form-label">Tiêu đề</label>
            <input type="text" name="txtName" class="form-control" id="name" required>
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>
          <div class="col-md-6">
            <label for="major" class="form-label">Chuyên ngành</label>
            <select class="form-select" name="txtMajor" id="major" onchange="checkOther(this);" required>
              <?php
              $majors = Major::list_major();
              foreach ($majors as $major) {
                echo "<option value=" . $major['ID'] . ">" . $major["name"] . "</option>";
              }
              ?>
            </select>
            <div class="invalid-feedback">
              Please select a valid state.
            </div>
          </div>
          <div class="col-md-6">
            <label for="category" class="form-label">Thể loại</label>
            <select class="form-select" name="txtCategory" id="category" onchange="checkOther(this);" required>
              <?php
              $categories = Doccategory::list_doccategory();
              foreach ($categories as $category) {
                echo "<option value=" . $category['ID'] . ">" . $category["CATENAME"] . "</option>";
              }
              ?>
            </select>
            <div class="invalid-feedback">
              Please select a valid state.
            </div>
          </div>
          <div class="col-md-6">
            <label for="file" class="form-label">Tài liệu</label>
            <input type="file" name="txtFile" class="form-control" id="file" required>
            <div class="invalid-feedback">
              Please provide a valid city.
            </div>
          </div>
          <div class="col-md-12">
            <label for="description" class="form-label">Mô tả</label>
            <textarea type="text" name="txtDescription" class="form-control" id="description" required> </textarea>
            <div class="invalid-feedback">
              Please describe the document.
            </div>
          </div>
          <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
              <button class="btn btn-primary" name="btnsubmit" type="submit">Thêm tài liệu</button>
              <div class="actions">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#majorModal">
                  Thêm chuyên ngành
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">
                  Thêm thể loại
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </main>
  </section>

</body>

<div class="modal fade" id="majorModal" tabindex="-1" aria-labelledby="majorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">
          Thêm chuyên ngành
        </h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3 needs-validation" method="post" action="add_document.php" novalidate>
          <div class="col-md-12">
            <label for="major-name" class="form-label">Tên chuyên ngành</label>
            <input type="text" name="txtMajorName" class="form-control" id="major-name" required>
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>
          <div class="col-md-12">
            <label for="major-description" class="form-label">Mô tả</label>
            <input type="text" name="txtMajorDescription" class="form-control" id="major-description" required>
            <div class="invalid-feedback">
              Please describe the document.
            </div>
          </div>
          <div class="col-12">
            <button class="btn btn-primary" name="btnmajorsubmit" type="submit">Thêm chuyên ngành</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">
          Thêm thể loại
        </h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3 needs-validation" method="post" action="add_document.php">
          <div class="col-md-12">
            <label for="category-name" class="form-label">Tên thể loại</label>
            <input type="text" name="txtCategoryName" class="form-control" id="category-name" required>
            <div class="invalid-feedback">
              Vui lòng nhập tên thể loại
            </div>
          </div>
          <div class="col-12">
            <button class="btn btn-primary" name="btncategorysubmit" type="submit">Thêm thể loại</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

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

<script src='./js/dashboard.js'></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
