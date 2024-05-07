<?php
include_once ('./entities/document.class.php');

if (isset($_POST["delete-document"])) {
  $document_id = $_POST["delete-document"];
  $result = Document::delete($document_id);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Tất cả tài liệu</title>
  <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/blog/">
  <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
  <link href="./assets/css/blog.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/add_article.css" />
  <link rel="stylesheet" href="./css/list_article.css">
  <link rel="stylesheet" href="./css/header.css">
</head>

<body style="margin-top: 100px;">
  <div id="toast" class="toast">Tài liệu đã được xóa thành công!</div>
  <?php include_once ('./dashboardheader.php') ?>
  <main class="table" id="customers_table">
    <section class="table__header">
      <h1>Tất cả tài liệu</h1>
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
            <th>Tên tài liệu<span class="icon-arrow">&UpArrow;</span></th>
            <th>Mô tả<span class="icon-arrow">&UpArrow;</span></th>
            <th>Ngày đăng<span class="icon-arrow">&UpArrow;</span></th>
            <th>Thể loại<span class="icon-arrow">&UpArrow;</span></th>
            <th>Tùy chọn<span class="icon-arrow">&UpArrow;</span></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $documents = Document::list_document_with_category();
          $order = 1;
          foreach ($documents as $document) {
            echo "<tr>
              <td>" . $order . "</td>
              <td><a class='document-item' href='" . $document["docfile"] . "' target='_blank'>" . $document["TITLE"] . "</a></td>
              <td>" . $document["DESCRIPTION"] . "</td>
              <td>" . $document["PUBLISH"] . "</td>
              <td>" . $document["CATENAME"] . "</td>
              <td>
                <div class='actions'>
                  <div class='edit-btn'>
                    <button><a href='edit_document.php?edit-document=" . $document["ID"] . "'>Sửa</a></button>
                  </div>
                  <div class='delete-btn'>
                    <button onclick='handleDelete(" . $document["ID"] . ")'><a>Xóa</a></button>
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
    <input type="text" name="delete-document" class="delete-document">
  </form>
  <a class="add-article-btn" href="add_document.php">Thêm tài liệu</a>
  <script src="./js/list_document.js"></script>
  <script>
    function handleDelete(ID) {
      if (confirm("Bạn có chắc chắn muốn xóa tài liệu này không?")) {
        deleteForm = document.querySelector('.delete-form');
        inputDelete = document.querySelector('.delete-document');
        inputDelete.value = ID
        const deleteSuccess = true;

        if (deleteSuccess) {
          const toast = document.getElementById('toast');
          toast.classList.add('show');

          setTimeout(function () {
            toast.classList.remove('show');
          }, 3000);
        }
        deleteForm.submit();
      }
    }
  </script>
</body>

</html>