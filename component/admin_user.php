<?php
include_once ('../entities/user.class.php');
?>

<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
<!-- My CSS -->
<link rel="stylesheet" href="../css/admin_article.css">

<title>Người dùng</title>
<!-- MAIN -->
<main id="main">
  <div class="head-title">
    <div class="left">
      <h1>Người dùng</h1>
      <ul class="breadcrumb">
        <li>
          <a class="navigate" href="dashboard.php">Dashboard</a>
        </li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li>
          <a class="active" class="navigate" href="#">Người dùng</a>
        </li>
      </ul>
    </div>
    <a class="navigate" href="#" class="btn-download">
      <i class='bx bxs-cloud-download'></i>
      <span class="text">Download PDF</span>
    </a>
  </div>

  <div class="table-data">
    <div class="order">
      <div class="head">
        <h3>Các người dùng hệ thống</h3>
        <i class='bx bx-search'></i>
        <i class='bx bx-filter'></i>
      </div>
      <table>
        <thead>
          <tr>
            <th>STT</th>
            <th>Tên người dùng</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Giới tính</th>
            <th>Tùy chọn</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $users = User::list_user();
          $order = 1;
          foreach ($users as $user) {
            echo "<tr>
              <td>" . $order . "</td>
              <td class='infor-container'> <img style='margin-right: 6px;' src='" . $user["AVATAR"] . "' alt='Ảnh hiển thị của bài báo'><a class='article-item' href='user_detail.php?id=" . $user["ID"] . "'>" . $user["NAME"] . "</a></td>
              <td>" . $user["MAIL"] . "</td>
              <td>" . $user["ADDRESS"] . "</td>
              <td>" . ($user["GENDER"] == 0 ? "Female" : "Male") . "</td>
              <td>
                <div class='delete-btn'>
                  <a onclick='handleDelete(" . $user["ID"] . ")'><i class='bx bx-trash'></i></a>
                </div>
              </td>
          </tr>";
            $order++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</main>
</section>
<form hidden action="" class="delete-form" method="POST">
  <input type="text" name="delete-user" class="delete-user">
</form>
<script src="../js/dashboard.js"></script>