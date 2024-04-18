<?php
include_once("./entities/article.class.php");
include_once("./entities/subject.class.php");
?>

<?php
if (isset($_GET["id"]) == null) {
  header("Location: notfound.php");
} else {
  $id = $_GET["id"];
  $article = Article::get_article($id);
}
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
  <link rel="stylesheet" href="./assets/icon/themify-icons/themify-icons.css">
  <link href="./css/article_detail.css" rel="stylesheet">
</head>

<body>
  <div class="container">
    <?php include_once("./header.php"); ?>
  </div>

  <main role="main" class="container">
    <div class="row">
      <div class="col-md-9 blog-main" style="overflow: hidden;">
        <?= $article[0]["CONTENT"] ?>
        <p style="margin-top: 16px;">
          Tag:
          <a href="news.php?page=1&subject=<?= $article[0]['TYPE'] ?>" style="padding: 6px 12px; background-color: red; color: white; border-radius: 12px;"><?= Subject::get_subject($article[0]["TYPE"])[0]["NAME"] ?></a>
        </p>
      </div>

      <aside class="col-md-3 blog-sidebar">
        <h3 class="pb-3 mb-4 font-italic border-bottom">
          Tin liên quan
        </h3>
        <?php
        $articles = Article::list_articles_relate($article[0]["TYPE"], $article[0]["ID"], $article[0]["isNoti"]);
        foreach ($articles as $item) {
          echo "
            <div class='d-flex justify-content-between align-items-center'>
              <img class='news-image' src='" . $item["THUMBNAIL"] . "' alt='Thumbnail'/>
              <p>
                <a href='article_detail.php?id=" . $item["ID"] . "' class='notification-title'> " . $item["TITLE"] . "</a>
                <span class='publish-day'>" . $item["PUBLISH"] . "</span>
              </p>
            </div>
        ";
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