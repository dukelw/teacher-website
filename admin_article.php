<?php
include_once('./entities/article.class.php');
include_once('./entities/document.class.php');
include_once('./entities/subject.class.php');
?>

<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
<!-- My CSS -->
<link rel="stylesheet" href="./css/admin_article.css">

<title>Bài báo</title>
<!-- MAIN -->
<main id="main">
  <div class="head-title">
    <div class="left">
      <h1>Bài báo (<?= count(Article::list_items()) ?>)
      </h1>
      <ul class="breadcrumb">
        <li>
          <a class="navigate" href="dashboard.php">Dashboard</a>
        </li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li>
          <a class="active" class="navigate" href="#">Bài báo</a>
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
        <h3>Các bài viết</h3>
        <i class='bx bx-search'></i>
        <i class='bx bx-filter'></i>
      </div>
      <table>
        <thead>
          <tr>
            <th>STT</th>
            <th>Tên bài viết</th>
            <th>Mô tả</th>
            <th>Ngày viết</th>
            <th>Thể loại</th>
            <th>Tùy chọn</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $articles = Article::list_items();
          $order = 1;
          foreach ($articles as $article) {
            $type = "notification";
            $subject = Subject::get_subject($article["TYPE"])[0]["NAME"];
            if ($subject == "Tin tức") {
              $type = "news";
            } elseif ($subject == "Nghiên cứu khoa học") {
              $type = "science";
            } elseif ($subject == "Tuyển dụng") {
              $type = "job";
            }
            echo "<tr>
                <td>" . $order . "</td>
                <td class='infor-container'> <img style='margin-right: 8px;' src='" . $article["THUMBNAIL"] . "' alt='Ảnh hiển thị của bài báo'><a class='article-item' href='article_detail.php?id=" . $article["ID"] . "'>" . $article["TITLE"] . "</a></td>
                <td><a class='article-item' href='article_detail.php?id=" . $article["ID"] . "'>" . $article["DESCRIPTION"] . "</a></td>
                <td>" . $article["PUBLISH"] . "</td>
                <td>
                  <p class='status " . $type . "'>" . $subject . "</p>
                </td>
                <td>
                  <div class='actions'>
                    <div class='edit-btn'>
                      <a href='edit_article.php?edit-article=" . $article["ID"] . "'><i class='bx bx-edit-alt' ></i></a>
                    </div>
                    <div class='delete-btn'>
                      <a onclick='handleDeleteArticle(" . $article["ID"] . ")'><i class='bx bx-trash'></i></a>
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
  <input type="text" name="delete-article" class="delete-article">
</form>
<a class="add-article-btn navigate" href="add_article.php">Thêm bài viết</a>
<script src='./js/dashboard.js'></script>