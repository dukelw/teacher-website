<?php
include_once("./entities/document.class.php");
include_once("./entities/doccategory.class.php");
include_once("./entities/major.class.php");
include_once("./dashboardheader.php");

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
    header("Location: list_document.php");
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
  <meta charset="utf-8">
  <title>Thêm tài liệu</title>
  <link rel="stylesheet" href="./css/add_article.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="./assets/js/jquery-slim.min.js"></script>
  <script src="./assets/js/holder.min.js"></script>
  <script src="./assets/js/popper.min.js"></script>
  <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="./css/dashboard.css" rel="stylesheet">
  <link href="./css/add_document.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
</head>

<body>
  <div class="main container" style="margin-top: 100px;">
    <h3 class="pb-3 font-italic border-bottom">
      Thêm tài liệu
    </h3>
    <div class="container mt-4">
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
              <button class="btn btn-primary major-btn">Thêm chuyên ngành</button>
              <button class="btn btn-primary category-btn">Thêm thể loại</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
<!-- Major form -->
<form class="row g-3 needs-validation main custom-modal major-modal hide" method="post" action="add_document.php" novalidate>
  <div class="d-flex justify-content-between align-items-center">
    <h3 class="pb-3 font-italic border-bottom">
      Thêm chuyên ngành
    </h3>
    <button class="btn btn-danger major-close-btn">&times;</button>
  </div>
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

<!-- Category form -->
<form class="row g-3 needs-validation main custom-modal category-modal hide" method="post" action="add_document.php">
  <div class="d-flex justify-content-between align-items-center">
    <h3 class="pb-3 font-italic border-bottom">
      Thêm chuyên ngành
    </h3>
    <button class="btn btn-danger category-close-btn">&times;</button>
  </div>
  <div class="col-md-12">
    <label for="category-name" class="form-label">Tên chuyên ngành</label>
    <input type="text" name="txtCategoryName" class="form-control" id="category-name" required>
    <div class="invalid-feedback">
      Vui lòng nhập tên thể loại
    </div>
  </div>
  <div class="col-12">
    <button class="btn btn-primary" name="btncategorysubmit" type="submit">Thêm thể loại</button>
  </div>
</form>

<div class="overlay hide"></div>

</html>

<script>
  const majorBtn = document.querySelector('.major-btn');
  const majorForm = document.querySelector('.major-modal');
  const majorCloseBtn = document.querySelector('.major-close-btn')
  majorBtn.onclick = (e) => {
    e.preventDefault();
    majorForm.classList.remove('hide');
  }
  majorCloseBtn.onclick = (e) => {
    e.preventDefault();
    majorForm.classList.add('hide');
  }

  const categoryBtn = document.querySelector('.category-btn');
  const categoryForm = document.querySelector('.category-modal');
  const categoryCloseBtn = document.querySelector('.category-close-btn')
  categoryBtn.onclick = (e) => {
    e.preventDefault();
    categoryForm.classList.remove('hide');
  }
  categoryCloseBtn.onclick = (e) => {
    e.preventDefault();
    categoryForm.classList.add('hide');
  }
</script>