<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<link rel="stylesheet" href="./assets/css/blog.css">
<link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">
<title>Teacher Website</title>
<link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/blog/">
<link href="./assets/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
<link rel="icon" href="./assets/images/logo.svg" type="image/x-icon" />
<link href="./assets/css/blog.css" rel="stylesheet">
<link rel="stylesheet" href="./assets/icon/themify-icons/themify-icons.css">
<script src="./assets/js/jquery-slim.min.js"></script>
<script src="./assets/js/holder.min.js"></script>
<script src="./assets/js/popper.min.js"></script>
<div class="container">
  <?php
  include_once("./header.php");
  ?>
</div>
<?php
require_once("./entities/teacher.class.php");
if (isset($_POST["btnsubmit"])) {
  $productName = $_POST["txtName"];
  $cateID = intval($_POST["txtCategory"]);
  $price = intval($_POST["txtPrice"]);
  $quantity = intval($_POST["txtQuantity"]);
  $address = $_POST["txtAddress"];
  $picture = $_FILES["txtThumbnail"];

  $newProduct = new Teacher($productName, $cateID, $price, $quantity, $Address, $picture);
  $result = $newProduct->save();
  if ($result) {
    echo "Thêm thành công";
    return;
    header("Location: teachers.php");
  } else {
    header("Location: add_product.php?failure");
  }
}
?>

<div class="container mt-4">
  <form enctype="multipart/form-data" class="row g-3 needs-validation" method="post" action="#" novalidate>
    <div class="col-md-6">
      <label for="name" class="form-label">Họ và tên</label>
      <input type="text" name="txtName" class="form-control" id="name" required>
      <div class="valid-feedback">
        Looks good!
      </div>
    </div>
    <div class="col-md-6">
      <label for="phone" class="form-label">Số điện thoại</label>
      <input type="text" phone="txtPhone" class="form-control" id="phone" required>
      <div class="valid-feedback">
        Looks good!
      </div>
    </div>
    <div class="col-md-6">
      <label for="price" class="form-label">Price</label>
      <input type="text" name="txtPrice" class="form-control" id="price" required>
      <div class="invalid-feedback">
        Please enter price
      </div>
    </div>
    <div class="col-md-6">
      <label for="thumbnail" class="form-label">Ảnh đại diện</label>
      <input type="file" accept=".PNG, .GIF, .JPG" name="txtThumbnail" class="form-control" id="thumbnail" required>
      <div class="invalid-feedback">
        Please provide a valid city.
      </div>
    </div>
    <div class="col-md-6">
      <label for="category" class="form-label">Vị trí</label>
      <select class="form-select" name="txtCategory" id="category" required>
        <option selected disabled value="">Choose...</option>
        <?php
        $categories = Category::list_category();
        foreach ($categories as $category) {
          echo "<option value=" . $category['CateID'] . ">" . $category["CategoryName"] . "</option>";
        }
        ?>
      </select>
      <div class="invalid-feedback">
        Please select a valid state.
      </div>
    </div>
    <div class="col-md-12">
      <label for="address" class="form-label">Địa chỉ</label>
      <textarea type="text" name="txtAddress" class="form-control" id="address" required> </textarea>
      <div class="invalid-feedback">
        Please describe the product.
      </div>
    </div>
    <div class="col-12">
      <button class="btn btn-primary" name="btnsubmit" type="submit">Submit form</button>
    </div>
  </form>
</div> -->