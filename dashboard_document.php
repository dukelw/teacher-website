<?php
include_once('./entities/article.class.php');
include_once('./entities/document.class.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">
  <title>Dashboard Document</title>
  <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/dashboard/">
  <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="./dashboard.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
</head>

<body>
  <?php include_once("./dashboardheader.php") ?>
  <div class="container">
    <div class="row">
      <?php include_once("./list_document.php") ?>
    </div>
</body>

</html>
<style>
  .main {
    margin-top: 100px;
  }

  .statistic-image {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50px;
    height: 50px;
    margin-right: 12px;
  }

  .statistic-item {
    margin-bottom: 20px;
    border-radius: 20px;
    width: 80%;
  }

  .statistic-item.article {
    background-color: #86e49d;
  }

  .statistic-item.file {
    background-color: #d893a3;
  }

  .statistic-item.access {
    background-color: #ebc474;
  }

  .statistic-content {
    font-size: 16px;
  }
</style>