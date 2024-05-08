<?php
include_once("./entities/article.class.php");
include_once("./entities/subject.class.php");
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">
  <title>Teacher Website</title>
  <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/blog/">
  <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
  <link rel="icon" href="./assets/images/logo.svg" type="image/x-icon" />
  <link href="./assets/css/blog.css" rel="stylesheet">
  <link href="./css/article_detail.css" rel="stylesheet">
  <link rel="stylesheet" href="./assets/icon/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="./css/news.css">
  <script src="./assets/js/jquery-slim.min.js"></script>
  <script src="./assets/js/holder.min.js"></script>
  <script src="./assets/js/popper.min.js"></script>
</head>

<body>
  <div class="container">
    <?php include_once("./header.php");
    ?>
  </div>

  <main role="main" class="container">
    <div class="row">
      <div class="col-md-9 blog-main">
        <?php
        if (isset($_GET['subject'])) {
          echo "<h3 class='pb-3 font-italic border-bottom'>
            " . Subject::get_subject($_GET['subject'])[0]["NAME"] . "
          </h3>";
        } else {
          echo "<h3 class='pb-3 font-italic border-bottom'>
            Tất cả thông báo
          </h3>";
        }
        ?>
        <div class="row">
          <?php
          $articlesPerPage = 6;
          $page = isset($_GET['page']) ? $_GET['page'] : 1;

          $start = ($page - 1) * $articlesPerPage;

          if (isset($_GET['subject']) == null) {
            $articles = Article::list_notifications_pagination($start, $articlesPerPage);
          } else {
            $articles = Article::list_notifications_pagination_type($start, $articlesPerPage, $_GET["subject"]);
          }

          foreach ($articles as $item) {
            echo "
              <div class='col-md-6'>
                  <div class='d-flex justify-content-between align-items-center'>
                      <img class='news-image' src='" . $item["THUMBNAIL"] . "' alt='Thumbnail'/>
                      <p>
                          <a href='article_detail.php?id=" . $item["ID"] . "' class='notification-title'> " . $item["TITLE"] . "</a>
                          <span class='publish-day'>" . $item["PUBLISH"] . "</span>
                      </p>
                  </div>
              </div>
              ";
          }
          ?>
        </div>
        <?php
        if (isset($_GET["subject"]) == null) {
          $totalArticles = count(Article::list_notifications());
          $totalPages = ceil($totalArticles / $articlesPerPage);
        } else {
          $totalArticles = count(Article::list_notifications_by_type($_GET['subject']));
          $totalPages = ceil($totalArticles / $articlesPerPage);
        }

        if ($totalArticles != 0) {
          echo "<nav aria-label='Page navigation example'>
                    <ul class='pagination' style='justify-content: center;'>";

          $prevPage = ($page > 1) ? $page - 1 : 1;
          if (isset($_GET['subject'])) {
            echo "<li class='page-item'><a class='page-link' href='notifications.php?page=$prevPage&subject=" . $_GET['subject'] . "' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";

            for ($i = 1; $i <= $totalPages; $i++) {
              $activeClass = ($page == $i) ? 'active' : '';
              echo "<li class='page-item $activeClass'><a class='page-link' href='notifications.php?page=$i&subject=" . $_GET['subject'] . "'>$i</a></li>";
            }

            $nextPage = ($page < $totalPages) ? $page + 1 : $totalPages;
            echo "<li class='page-item'><a class='page-link' href='notifications.php?page=$nextPage&subject=" . $_GET['subject'] . "' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
          } else {
            echo "<li class='page-item'><a class='page-link' href='notifications.php?page=$prevPage' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";

            for ($i = 1; $i <= $totalPages; $i++) {
              $activeClass = ($page == $i) ? 'active' : '';
              echo "<li class='page-item $activeClass'><a class='page-link' href='notifications.php?page=$i'>$i</a></li>";
            }

            $nextPage = ($page < $totalPages) ? $page + 1 : $totalPages;
            echo "<li class='page-item'><a class='page-link' href='notifications.php?page=$nextPage' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
          }

          echo "</ul></nav>";
        } else {
          echo "Không có tin tức nào thuộc thể loại này";
        }
        ?>
      </div>

      <aside class="col-md-3 blog-sidebar">
        <h3 class="pb-3 mb-4 font-italic border-bottom">
          Danh mục
        </h3>

        <?php
        $subject = Subject::list_subject();
        foreach ($subject as $subject) {
          echo "                            
            <div class='sort-type d-flex justify-content-start align-items-center'> <span style='margin-right: 4px;' class='icon ti-agenda'></span> <a class='link' href='notifications.php?page=" . $page . "&subject=" . $subject["ID"] . "'>" . $subject["NAME"] .
            "</a></div>";
        }
        ?>
      </aside>
    </div>
  </main>

  <?php include_once("./footer.php") ?>

  <script src="./assets/js/jquery-slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script>
    window.jQuery || document.write('<script src="./assets/js/jquery-slim.min.js"><\/script>')
  </script>
  <script src="./assets/js/popper.min.js"></script>
  <script src="./assets/js/bootstrap.min.js"></script>
  <script src="./assets/js/holder.min.js"></script>
  <script>
    Holder.addTheme('thumb', {
      bg: '#55595c',
      fg: '#eceeef',
      text: 'Thumbnail'
    });
  </script>
</body>

</html>