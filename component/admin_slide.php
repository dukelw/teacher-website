<?php
include_once ('../entities/article.class.php');
include_once ('../entities/document.class.php');
include_once ('../entities/subject.class.php');
include_once ('../entities/slide.class.php');
?>

<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

<!-- My CSS -->
<link rel="stylesheet" href="../css/dashboard.css">
<link rel="stylesheet" href="../css/admin_slide.css">

<title>Slide</title>
<main id="main">
  <div class="head-title">
    <div class="left">
      <h1>Slide (<?= count(Slide::list_slides()) ?>)
      </h1>
      <ul class="breadcrumb">
        <li>
          <a class="navigate" href="dashboard.php">Dashboard</a>
        </li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li>
          <a class="active" class="navigate" href="#">Slide</a>
        </li>
      </ul>
    </div>
    <div class="right">
      <a href="add_slide.php" class="btn btn-primary">Thêm</a>
    </div>
  </div>
  </div>
  <div class="table-data">
    <div class="order">
      <div class="head">
        <h3>Các bài viết</h3>
        <i class='bx bx-search'></i>
        <i class='bx bx-filter'></i>
      </div>
      <table>
        <thead>
          <tr>
            <th>STT</th>
            <th>Hình ảnh</th>
            <th>Đường dẫn</th>
            <th>Tùy chọn</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $slides = Slide::list_slides();
          $order = 1;
          foreach ($slides as $slide) {
            echo "<tr>
                <td style='text-align: left;'>" . $order . "</td>
                <td class='infor-container'> <img style='margin-right: 8px; width: 150px; height: 150px;' src='" . $slide["FILE"] . "' alt='Ảnh hiển thị của bài báo'><a class='article-item' href='article_detail.php?id=" . $slide["ID"] . "'></a></td>
                <td><p class='article-item'>" . $slide["FILE"] . "</p></td>
                <td>
                  <div class='actions' style='text-align: left !important;'>
                    <div class='delete-btn'>
                      <a onclick='handleDeleteSlide(" . $slide["ID"] . ")'><i class='bx bx-trash'></i></a>
                    </div>
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
  <input type="text" name="delete-slide" class="delete-slide">
</form>
<a class="add-slide-btn navigate" href="add_slide.php">Thêm slide</a>
<script src='../js/dashboard.js'></script>

<script>

</script>