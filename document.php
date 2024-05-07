<?php
include_once ("./entities/document.class.php");
include_once ("./entities/doccategory.class.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/blog/">
  <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
  <link rel="icon" href="./assets/images/logo.svg" type="image/x-icon" />
  <link href="./assets/css/blog.css" rel="stylesheet">
  <link href="./css/document.css" rel="stylesheet">
  <link rel="stylesheet" href="./assets/icon/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="./css/news.css">
  <script src="./assets/js/jquery-slim.min.js"></script>
  <script src="./assets/js/holder.min.js"></script>
  <script src="./assets/js/popper.min.js"></script>
</head>

<body>

  <div class="container">
    <?php include_once ("./header.php"); ?>
  </div>

  <main role="main" class="container">
    <div class="row">
      <div class="col-md-12 blog-main">
        <h3 class='pb-3 font-italic border-bottom'>Danh sách Tài liệu</h3>
        <div class="row">
          <?php
          $documents = Document::list_document_with_category();
          foreach ($documents as $document) {
            echo "
                <div class='col-md-12'>
                    <div class='document'>
                        <h4 class='document-title'><a href='document_detail.php?id=" . $document["ID"] . "'>" . $document["TITLE"] . "</a></h4>
                        <p class='document-description'>" . $document["DESCRIPTION"] . "</p>
                        <p class='document-category'>Thể loại: " . $document["CATENAME"] . "</p>
                        <a class='document-link' href='" . $document["docfile"] . "' target='_blank'>Tải về</a>
                    </div>
                </div>";
          }
          ?>
        </div>
      </div>
      <aside class="col-md-3 blog-sidebar">
      </aside>
    </div>
  </main>

  <?php include_once ("./footer.php") ?>
</body>

</html>