<?php
include_once("./entities/document.class.php");
include_once("./entities/doccategory.class.php");
include_once("./entities/major.class.php");
?>

<?php
$editingDocument = Document::get_document($_GET['edit-document']);

if (isset($_POST["btnsubmit"])) {
  $originalDocument = Document::get_document($_POST['edit-document']);
  $title = $_POST["txtName"];
  $category = intval($_POST["txtCategory"]);
  $description = $_POST["txtDescription"];
  $file = $_FILES["txtFile"];
  $major = $_POST["txtMajor"];

  $docfile = (!empty($file['tmp_name'])) ? $file : $editingDocument[0]["docfile"];

  $newDocument = new Document(
    $title,
    $description,
    $category,
    $docfile,
    $originalDocument[0]['PUBLISH'], // Giữ nguyên ngày xuất bản,
    $major
  );

  // Thực hiện cập nhật tài liệu
  $result = $newDocument->update_document($_POST['edit-document']);

  if ($result) {
    header("Location: dashboard.php");
  } else {
    echo "Cập nhật thất bại";
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
  <link rel="stylesheet" href="./css/add_article.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="./assets/js/jquery-slim.min.js"></script>
  <script src="./assets/js/holder.min.js"></script>
  <script src="./assets/js/popper.min.js"></script>
  <link rel="stylesheet" href="./css/dashboard.css">
  <link rel="stylesheet" href="./css/admin_article.css">

  <title>Chỉnh sửa tài liệu</title>
</head>

<body>
  <!-- SIDEBAR -->
  <section id="sidebar">
    <a href="dashboard.php" class="brand">
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
      <li class="active">
        <a class="navigate" href="#">
          <i class='bx bx bxs-calendar-check'></i>
          <span class="text">Cập nhật tài liệu</span>
        </a>
      </li>
    </ul>
  </section>
  <!-- SIDEBAR -->

  <!-- CONTENT -->
  <section id="content">
    <!-- NAVBAR -->
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
    <!-- NAVBAR -->

    <!-- MAIN -->
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
              <a class="active" class="navigate" href="#">Cập nhật tài liệu</a>
            </li>
          </ul>
        </div>
        <a class="navigate" href="#" class="btn-download">
          <i class='bx bxs-cloud-download'></i>
          <span class="text">Download PDF</span>
        </a>
      </div>

      <div class="main container">
        <h1>Cập nhật tài liệu</h1>
        <form enctype="multipart/form-data" class="row g-3 needs-validation" method="post" action="" novalidate>
          <div class="col-md-6">
            <label for="name" class="form-label">Tiêu đề</label>
            <input type="text" name="txtName" class="form-control" id="name" required value="<?php if (isset($_GET['edit-document'])) {
                                                                                                echo $editingDocument[0]["TITLE"];
                                                                                              } ?>">
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>
          <div class="col-md-6">
            <label for="major" class="form-label">Chuyên ngành</label>
            <select class="form-select" name="txtMajor" id="major" required>
              <?php
              $majors = Major::list_major();
              foreach ($majors as $major) {
                if ((isset($_GET['edit-document']))) {
                  $selected = ($editingDocument[0]["subject"] == $major['ID']) ? 'selected' : '';
                  echo "<option value=" . $major['ID'] . " " . $selected . ">" . $major["name"] . "</option>";
                } else {
                  echo "<option value=" . $major['ID'] . ">" . $major["name"] . "</option>";
                }
              }
              ?>
            </select>
            <div class="invalid-feedback">
              Please select a valid state.
            </div>
          </div>
          <div class="col-md-6">
            <label for="category" class="form-label">Thể loại</label>
            <select class="form-select" name="txtCategory" id="category" required>
              <option selected disabled value="">Choose...</option>
              <?php
              $categories = Doccategory::list_doccategory();
              foreach ($categories as $category) {
                if ((isset($_GET['edit-document']))) {
                  $selected = ($editingDocument[0]["cateID"] == $category['ID']) ? 'selected' : '';
                  echo "<option value=" . $category['ID'] . " " . $selected . ">" . $category["CATENAME"] . "</option>";
                } else {
                  echo "<option value=" . $category['ID'] . ">" . $category["CATENAME"] . "</option>";
                }
              }
              ?>
            </select>
            <div class="invalid-feedback">
              Please select a valid category.
            </div>
          </div>
          <div class="col-md-6">
            <label for="file" class="form-label">Tài liệu</label>
            <p><?php echo $editingDocument[0]["docfile"]; ?></p>
            <input type="file" name="txtFile" class="form-control" id="file">
            <div class="invalid-feedback">
              Please provide a valid file.
            </div>
          </div>
          <div class="col-md-12">
            <label for="description" class="form-label">Mô tả</label>
            <textarea type="text" name="txtDescription" class="form-control" id="description" required><?php if (isset($_GET['edit-document'])) {
                                                                                                          echo $editingDocument[0]["DESCRIPTION"];
                                                                                                        } ?></textarea>
            <div class="invalid-feedback">
              Please describe the document.
            </div>
          </div>
          <input hidden type="text" name="edit-document" value="<?php if (isset($_GET["edit-document"])) {
                                                                  echo $_GET["edit-document"];
                                                                } ?>">
          <div class="col-12 mb-4">
            <button class="btn btn-primary" name="btnsubmit" type="submit">Cập nhật tài liệu</button>
          </div>
        </form>
      </div>
    </main>
  </section>
  <script src="./js/dashboard.js"></script>

</body>

</html>
