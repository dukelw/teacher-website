<?php
include_once ("./entities/document.class.php");
include_once ("./entities/doccategory.class.php");
include_once ("./entities/major.class.php");
include_once ("./dashboardheader.php");
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
    header("Location: list_document.php");
  } else {
    echo "Cập nhật thất bại";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Cập nhật tài liệu</title>
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
    <h1>Cập nhật tài liệu</h1>
    <form enctype="multipart/form-data" class="row g-3 needs-validation" method="post" action=""
      novalidate>
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
        <textarea type="text" name="txtDescription" class="form-control" id="description"
          required><?php if (isset($_GET['edit-document'])) {
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