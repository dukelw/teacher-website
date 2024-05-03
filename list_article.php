<?php
include_once("./entities/subject.class.php");
include_once("./entities/article.class.php");

if (isset($_POST["delete-article"])) {
  $delete_id = $_POST["delete-article"];
  $result = Article::delete($delete_id);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Tất cả bài viết</title>
  <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/blog/">
  <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
  <link href="./assets/css/blog.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/add_article.css" />
  <link rel="stylesheet" href="./css/list_article.css">
  <link rel="stylesheet" href="./css/header.css">
</head>

<body>
  <div id="toast" class="toast">Bài viết đã được xóa thành công!</div>
  <div class="nav-scroller py-1 mb-2">
    <nav class="nav d-flex justify-content-between">
      <a class="p-2 text-muted" href="dashboard.php">Trang chủ</a>
      <a class="p-2 text-muted" href="list_article.php">Tất cả bài viết</a>
      <a class="p-2 text-muted" href="add_article.php">Thêm bài viết mới</a>
      <!-- <a class="p-2 text-muted" href="news.php">Tin tức</a>
      <a class="p-2 text-muted" href="./career.php">Doanh nghiệp</a>
      <a class="p-2 text-muted" href="#">Tuyển sinh</a>
      <a class="p-2 text-muted" href="#">Cấm thi</a> -->
    </nav>
  </div>
  <main class="table" id="customers_table">
    <section class="table__header">
      <h1>Tất cả bài viết</h1>
      <div class="search-group">
        <input type="search" placeholder="Search Data...">
        <img src="./upload/search.png" alt="">
      </div>
    </section>
    <section class="table__body">
      <table>
        <thead>
          <tr style="position: relative; z-index: 100;">
            <th>STT<span class="icon-arrow">&UpArrow;</span></th>
            <th>Tên bài viết<span class="icon-arrow">&UpArrow;</span></th>
            <th>Mô tả<span class="icon-arrow">&UpArrow;</span></th>
            <th>Ngày viết<span class="icon-arrow">&UpArrow;</span></th>
            <th>Thể loại<span class="icon-arrow">&UpArrow;</span></th>
            <th>Tùy chọn<span class="icon-arrow">&UpArrow;</span></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $articles = Article::list_articles();
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
              <td> <img src='" . $article["THUMBNAIL"] . "' alt=''>" . $article["TITLE"] . "</td>
              <td>" . $article["DESCRIPTION"] . "</td>
              <td>" . $article["PUBLISH"] . "</td>
              <td>
                <p class='status " . $type . "'>" . $subject . "</p>
              </td>
              <td>
                <div class='actions'>
                  <div class='edit-btn'>
                    <button><a href='edit_article.php?edit-article=" . $article["ID"] . "'>Sửa</a></button>
                  </div>
                  <div class='delete-btn'>
                    <button onclick='handleDelete(" . $article["ID"] . ")'><a>Xóa</a></button>
                  </div>
                </div>
              </td>
          </tr>";
            $order++;
          }
          ?>
        </tbody>
      </table>
    </section>
  </main>
  <form hidden action="" class="delete-form" method="POST">
    <input type="text" name="delete-article" class="delete-article">
  </form>
  <script src="./js/list_article.js"></script>
  <script>
    function handleDelete(ID) {
      deleteForm = document.querySelector('.delete-form');
      inputDelete = document.querySelector('.delete-article');
      inputDelete.value = ID
      const deleteSuccess = true;

      if (deleteSuccess) {
        const toast = document.getElementById('toast');
        toast.classList.add('show');

        setTimeout(function() {
          toast.classList.remove('show');
        }, 3000);
      }
      deleteForm.submit()
    }
  </script>
</body>

</html>