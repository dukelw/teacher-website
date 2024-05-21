<?php
include_once('../entities/article.class.php');
include_once('../entities/user.class.php');
include_once('../entities/notification.class.php');
session_start();
?>

<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
<!-- My CSS -->
<link rel="stylesheet" href="../css/admin_article.css">

<title>Bài báo</title>
<!-- MAIN -->
<main id="main">
  <div class="head-title">
    <div class="left">
      <h1>Thông báo của bạn (<?= count(Notification::list_notification_of_user($_SESSION['userid'])) ?>)
      </h1>
      <ul class="breadcrumb">
        <li>
          <a class="navigate" href="dashboard.php">Dashboard</a>
        </li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li>
          <a class="active" class="navigate" href="#">Thông báo của bạn</a>
        </li>
      </ul>
    </div>
  </div>

  <div class="table-data">
    <div class="order">
      <div class="head">
        <h3>Các thông báo</h3>
        <i class='bx bx-search'></i>
        <i class='bx bx-filter'></i>
      </div>
      <table>
        <thead>
          <tr>
            <th>STT</th>
            <th>Từ</th>
            <th>Nội dung</th>
            <th>Thời gian</th>
            <th>Thể loại</th>
            <th>Tùy chọn</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $articles = Notification::list_notification_of_user($_SESSION['userid']);
          $order = 1;
          foreach ($articles as $article) {
            $type = "notification";
            $subject = $article["ARTICLE"];
            if ($subject == "Bình luận") {
              $type = "news";
            } elseif ($subject == "Báo cáo") {
              $type = "science";
            }
            $userAvatar = User::get_user_by_ID($article['SENDFROM'])[0]["AVATAR"];
            $userName = User::get_user_by_ID($article['SENDFROM'])[0]["NAME"];
            echo "<tr " . ($article["isREAD"] == 1 ? "class='readed'" : "") . ">
                <td>" . $order . "</td>
                <td class='infor-container'> <img style='margin-right: 8px;' src='" . $userAvatar . "' alt='Ảnh hiển thị của bài báo'>" . $userName . "</td>
                <td><a class='article-item' href='article_detail.php?id=" . $article["ARTICLEID"] . "'>" . $article["CONTENT"] . "</a></td>
                <td>" . $article["CREATEDAT"] . "</td>
                <td>
                  <p class='status news'>" . $article["ARTICLE"] . "</p>
                </td>
                <td>
                  <div class='actions'>
                    <div class='delete-btn'>
                      <a onclick='handleRead(" . $article["ID"] . ")'><i class='bx bx-check'></i></i></a>
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
<form hidden action="" class="read-form" method="POST">
  <input type="text" name="read-noti" class="read-article">
</form>
<script src='../js/dashboard.js'></script>