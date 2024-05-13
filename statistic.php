<?php
include_once("./entities/subject.class.php");
include_once("./entities/article.class.php");
include_once("./dashboardheader.php");
$fp = './log/statistic.txt';
$fo = fopen($fp, 'r');
$count = fread($fo, filesize($fp));
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Thống kê truy cập</title>
  <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/blog/">
  <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
  <link href="./assets/css/blog.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/add_article.css" />
  <link rel="stylesheet" href="./css/list_article.css">
  <link rel="stylesheet" href="./css/header.css">
</head>

<body style="margin-top: 100px;">
  <?= $count ?> lượt truy cập
</body>

</html>