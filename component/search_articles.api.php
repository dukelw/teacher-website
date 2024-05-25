<?php
include_once ("../entities/article.class.php");

if (isset($_POST['keysearch']) && $_POST['keysearch'] != '') {
  $keySearch = $_POST['keysearch'];
  $articlesPerPage = 6;
  $page = isset($_POST['page']) ? $_POST['page'] : 1;
  $start = ($page - 1) * $articlesPerPage;

  $foundArticles = Article::list_articles_by_keyword($keySearch, $start, $articlesPerPage);

  echo json_encode($foundArticles);
} else {
  echo json_encode([]);
}
