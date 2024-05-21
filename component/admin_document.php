<?php
include_once('../entities/document.class.php');
?>

<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
<!-- My CSS -->
<link rel="stylesheet" href="../css/dashboard.css">
<link rel="stylesheet" href="../css/admin_article.css">

<title>Tài liệu</title>
<!-- MAIN -->
<main id="main">
  <div class="head-title">
    <div class="left">
      <h1>Tài liệu (<?= count(Document::list_document_with_category()) ?>)</h1>
      <ul class="breadcrumb">
        <li>
          <a class="navigate" href="dashboard.php">Dashboard</a>
        </li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li>
          <a class="active" class="navigate" href="#">Tài liệu</a>
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
        <h3>Các tài liệu</h3>
        <i class='bx bx-search'></i>
        <i class='bx bx-filter'></i>
      </div>
      <table>
        <thead>
          <tr>
            <th>STT</th>
            <th>Tên tài liệu</th>
            <th>Mô tả</th>
            <th>Ngày đăng</th>
            <th>Thể loại</th>
            <th>Tùy chọn</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $documents = Document::list_document_with_category();
          $order = 1;
          foreach ($documents as $document) {
            echo "<tr>
              <td>" . $order . "</td>
              <td><a class='article-item' href='" . $document["docfile"] . "' target='_blank'>" . $document["TITLE"] . "</a></td>
              <td>" . $document["DESCRIPTION"] . "</td>
              <td>" . $document["PUBLISH"] . "</td>
              <td>" . $document["CATENAME"] . "</td>
              <td>
                <div class='actions'>
                  <div class='edit-btn'>
                    <a href='edit_document.php?edit-document=" . $document["ID"] . "'><i class='bx bx-edit-alt' ></i></a>
                  </div>
                  <div class='delete-btn'>
                    <a onclick='handleDeleteDocument(" . $document["ID"] . ")'><i class='bx bx-trash'></i></a>
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
  <input type="text" name="delete-document" class="delete-document">
</form>
<a class="add-article-btn navigate" href="add_document.php">Thêm tài liệu</a>
<script src="../js/dashboard.js"></script>