
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
  rel="stylesheet"
  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
  crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
  integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
  integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
  crossorigin="anonymous"></script>
<link href="./assets/css/blog.css" rel="stylesheet">
<title>Teacher Website</title>
<link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/blog/">
<link href="./assets/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
<link rel="icon" href="./assets/images/logo.svg" type="image/x-icon" />
<link href="./assets/css/blog.css" rel="stylesheet">
<link href="./css/main.css" rel="stylesheet">
<link href="./css/update_info.css" rel="stylesheet">
<link rel="stylesheet" href="./assets/icon/themify-icons/themify-icons.css">
<?php
echo "<div class='container'>";
include_once ("./entities/user.class.php");
session_start();
echo "</div>";

if (isset($_POST["name"]) || isset($_POST["btnsubmit"]) || isset($_FILES["thumbnail"])) {
  $name = $_POST["name"];
  $thumbnail = $_FILES["thumbnail"];
  $address = $_POST["address"];
  $phone = $_POST["phone"];
  $gender = intval($_POST["gender"]);
  $day = $_POST["birthdayDay"];
  $month = $_POST["birthdayMonth"];
  $year = $_POST["birthdayYear"];
  $birthday = $year . "-" . $month . "-" . $day;
  $user = User::get_user_by_ID($_SESSION['userID']);
  $file = $_FILES['thumbnail'];

  $avatar = (!empty($file['tmp_name'])) ? $file : $user[0]["AVATAR"];

  if ($name != $user[0]['NAME']) {
    $user[0]['NAME'] = $name;
  }

  if ($address != $user[0]['ADDRESS']) {
    $user[0]['ADDRESS'] = $address;
  }

  if ($phone != $user[0]['PHONE']) {
    $user[0]['PHONE'] = $phone;
  }

  if ($gender != $user[0]['GENDER']) {
    $user[0]['GENDER'] = $gender;
  }

  if ($birthday != $user[0]['BIRTHDAY']) {
    $user[0]['BIRTHDAY'] = $birthday;
  }

  $newUser = new User(
    $user[0]['NAME'],
    $user[0]['MAIL'],
    $user[0]['PASSWORD'],
    $avatar,
    $user[0]['GENDER'],
    $user[0]['PHONE'],
    $user[0]['BIRTHDAY'],
    $user[0]['ADDRESS'],
  );

  $result = $newUser->update_information($_SESSION['userID']);


  if ($result) {
    header("Location main.php");
  } else {
    header("Location update_info.php");
  }
}
?>

<form enctype="multipart/form-data" action="update_info.php" method="POST"
  class="container rounded bg-white mt-5 mb-5">
  <div class="row">
    <div class="col-md-3 border-right">
      <div style="padding-bottom: 12px !important;"
        class="d-flex flex-column align-items-center text-center py-5"><img
          class="user-avatar-big rounded-circle avatar"
          src="<?= User::get_user($_SESSION['useremail'])[0]["AVATAR"] ?>"> <span
          class="font-weight-bold"><?= User::get_user($_SESSION['useremail'])[0]["NAME"] ?></span><span
          class="text-black-50"><?= User::get_user($_SESSION['useremail'])[0]["MAIL"] ?></span><span>
        </span></div>
      <div class="col-md-12">
        <label for="thumbnail" class="form-label">Đổi hình nền</label>
        <input disabled type="file" accept=".PNG, .GIF, .JPG" name="thumbnail" class="form-control"
          id="thumbnail">
      </div>
      <div style="visibility: hidden;"
        class="col-md-12 d-flex flex-column align-items-center thumbnail-wrapper">
        <h4 class="mt-4">Ảnh xem trước</h4>
        <img id="preview" class="user-avatar-big rounded-circle"
          src="<?= User::get_user($_SESSION['useremail'])[0]["AVATAR"] ?>">
      </div>
    </div>
    <div class="col-md-9 border-right">
      <div class="p-3 py-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <span class="title text-right">Thay đổi thông tin</span>
          <button class="btn btn-primary edit-btn" type="button">Chỉnh sửa</button>
        </div>
        <div class="row mt-3">
          <div class="col-md-12"><label class="labels">Tên</label><input disabled type="text"
              name="name" class="form-control"
              value="<?= User::get_user($_SESSION['useremail'])[0]["NAME"] ?>"></div>
          <div class="col-md-12"><label class="labels">Email</label><input disabled type="text"
              name="email" class="form-control"
              value="<?= User::get_user($_SESSION['useremail'])[0]["MAIL"] ?>"></div>
          <div class="col-md-12"><label class="labels">Số điện thoại</label><input disabled
              type="text" name="phone" class="form-control"
              value="<?= User::get_user($_SESSION['useremail'])[0]["PHONE"] ?>"></div>
          <div class="col-md-12"><label class="labels">Địa chỉ</label><input disabled type="text"
              name="address" class="form-control"
              value="<?= User::get_user($_SESSION['useremail'])[0]["ADDRESS"] ?>"></div>
          <div class="col-md-12">
            <label class="labels">Giới tính</label>
            <select name="gender" disabled type="text" class="form-control">
              <option value="_">Giới tính</option>
              <option value="1" <?php echo (User::get_user($_SESSION['useremail'])[0]["GENDER"] == 1) ? 'selected' : ''; ?>>Nam</option>
              <option value="0" <?php echo (User::get_user($_SESSION['useremail'])[0]["GENDER"] == 0) ? 'selected' : ''; ?>>Nữ</option>
            </select>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-6">
            <label class="labels">Ngày sinh</label>
            <div class="row">
              <div class="col">
                <select disabled name="birthdayDay" class="form-control">
                  <?php
                  $selectedDay = date('d', strtotime(User::get_user($_SESSION['useremail'])[0]["BIRTHDAY"]));
                  for ($day = 1; $day <= 31; $day++) {
                    echo '<option value="' . $day . '"';
                    if ($day == $selectedDay)
                      echo ' selected';
                    echo '>' . $day . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col">
                <select disabled name="birthdayMonth" class="form-control">
                  <?php
                  $selectedMonth = date('m', strtotime(User::get_user($_SESSION['useremail'])[0]["BIRTHDAY"]));
                  $months = [
                    '01' => 'Tháng 1',
                    '02' => 'Tháng 2',
                    '03' => 'Tháng 3',
                    '04' => 'Tháng 4',
                    '05' => 'Tháng 5',
                    '06' => 'Tháng 6',
                    '07' => 'Tháng 7',
                    '08' => 'Tháng 8',
                    '09' => 'Tháng 9',
                    '10' => 'Tháng 10',
                    '11' => 'Tháng 11',
                    '12' => 'Tháng 12',
                  ];
                  foreach ($months as $key => $month) {
                    echo '<option value="' . $key . '"';
                    if ($key == $selectedMonth)
                      echo ' selected';
                    echo '>' . $month . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col">
                <select disabled name="birthdayYear" class="form-control">
                  <?php
                  $currentYear = date('Y');
                  $startYear = $currentYear - 100;
                  $endYear = $currentYear;
                  $selectedYear = date('Y', strtotime(User::get_user($_SESSION['useremail'])[0]["BIRTHDAY"]));
                  for ($year = $endYear; $year >= $startYear; $year--) {
                    echo '<option value="' . $year . '"';
                    if ($year == $selectedYear)
                      echo ' selected';
                    echo '>' . $year . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-5 text-center"><button class="btn btn-primary profile-button save-btn"
            name="btnsubmit" type="submit" disabled>Lưu thay đổi</button></div>
      </div>
    </div>
  </div>
</form>
<?php
include_once ("footer.php");
?>
<script>
  const editBtn = document.querySelector('.edit-btn');
  const saveBtn = document.querySelector('.save-btn');
  const name = document.querySelector('input[name="name"]');
  const thumbnail = document.querySelector('input[name="thumbnail"]');
  const email = document.querySelector('input[name="email"]');
  const phone = document.querySelector('input[name="phone"]');
  const address = document.querySelector('input[name="address"]');
  const gender = document.querySelector('select[name="gender"]');
  const birthdayDay = document.querySelector('select[name="birthdayDay"]');
  const birthdayMonth = document.querySelector('select[name="birthdayMonth"]');
  const birthdayYear = document.querySelector('select[name="birthdayYear"]');
  editBtn.onclick = function () {
    const isDisabled = name.disabled;
    saveBtn.disabled = !isDisabled;
    name.disabled = !isDisabled;
    thumbnail.disabled = !isDisabled;
    phone.disabled = !isDisabled;
    address.disabled = !isDisabled;
    gender.disabled = !isDisabled;
    birthdayDay.disabled = !isDisabled;
    birthdayMonth.disabled = !isDisabled;
    birthdayYear.disabled = !isDisabled;
    if (isDisabled) {
      editBtn.textContent = "Chỉ đọc"
    } else {
      editBtn.textContent = "Chỉnh sửa"
    }

    const thumbnailWrapper = document.querySelector(".thumbnail-wrapper");
    if (isDisabled) {
      thumbnailWrapper.classList.add('active');
    } else {
      thumbnailWrapper.classList.remove('active');
    }
  }

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