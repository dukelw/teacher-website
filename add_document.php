<?php
include_once ("./entities/document.class.php");
include_once ("./entities/doccategory.class.php");
include_once ("./dashboardheader.php");

if (isset($_POST["btnsubmit"])) {
  $title = $_POST["txtName"];
  $category = intval($_POST["txtCategory"]);
  $description = $_POST["txtDescription"];
  $file = $_FILES["txtFile"];

  // Set CONSTANT values for test
  $publish = date("Y-m-d");
  $docfile = $file;
  $newDocument = new Document($title, $description, $category, $docfile, $publish);
  $result = $newDocument->save();
  if ($result) {
    header("Location: list_document.php");
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous">
  <script src="./assets/js/jquery-slim.min.js"></script>
  <script src="./assets/js/holder.min.js"></script>
  <script src="./assets/js/popper.min.js"></script>
  <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="./css/dashboard.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
</head>

<body>
  <div class="main container" style="margin-top: 100px;">
    <h3 class="pb-3 font-italic border-bottom">
      Thêm tài liệu
    </h3>
    <div class="container mt-4">
      <form enctype="multipart/form-data" class="row g-3 needs-validation" method="post"
        action="add_document.php" novalidate>
        <div class="col-md-6">
          <label for="name" class="form-label">Tiêu đề</label>
          <input type="text" name="txtName" class="form-control" id="name" required>
          <div class="valid-feedback">
            Looks good!
          </div>
        </div>
        <div class="col-md-6">
          <label for="category" class="form-label">Thể loại</label>
          <select class="form-select" name="txtCategory" id="category" onchange="checkOther(this);"
            required>
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
          <textarea type="text" name="txtDescription" class="form-control" id="description"
            required> </textarea>
          <div class="invalid-feedback">
            Please describe the document.
          </div>
        </div>
        <div class="col-12">
          <button class="btn btn-primary" name="btnsubmit" type="submit">Thêm tài liệu</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>

<style>
  .main {
    width: 82vw;
    background-color: #fff5;
    backdrop-filter: blur(7px);
    box-shadow: 0 0.4rem 0.8rem #0005;
    border-radius: 0.8rem;
    padding: 20px;
  }

  body {
    font-size: 16px;
  }
</style>