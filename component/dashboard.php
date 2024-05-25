<?php
include_once ('../entities/user.class.php');
session_start();
if (!isset($_SESSION['adminemail'])) {
  header("Location: admin_login.php");
}

include_once ('../entities/slide.class.php');
include_once('../entities/article.class.php');
include_once('../entities/document.class.php');
include_once('../entities/subject.class.php');
include_once('../entities/notification.class.php');

if (isset($_POST["delete-article"])) {
  $delete_id = $_POST["delete-article"];
  $result = Article::delete($delete_id);
}

if (isset($_POST["delete-document"])) {
  $document_id = $_POST["delete-document"];
  $result = Document::delete($document_id);
}

if (isset($_POST["delete-user"])) {
  $delete_id = $_POST["delete-user"];
  $result = User::delete($delete_id);
}

if (isset($_POST["delete-slide"])) {
  $slide_id = $_POST["delete-slide"];
  $result = Slide::delete($slide_id);

if (isset($_POST["read-noti"])) {
  $noti_id = $_POST["read-noti"];
  $result = Notification::checked($noti_id);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <!-- My CSS -->
  <link rel="stylesheet" href="../css/dashboard.css">
  <link rel="stylesheet" href="../css/admin_article.css">
  <link rel="icon" href="../assets/images/dashboard.png" type="image/x-icon" />

  <title>AdminHub</title>
</head>

<body>
  <!-- SIDEBAR -->
  <section id="sidebar">
    <a href="#" class="brand">
      <i class='bx bxs-smile'></i>
      <span class="text">Dashboard</span>
    </a>
    <ul class="side-menu top">
      <li class="active">
        <a href="dashboard.php">
          <i class='bx bxs-dashboard'></i>
          <span class="text">Trang chủ</span>
        </a>
      </li>
      <li>
        <a class="navigate" href="admin_article.php">
          <i class='bx bx bxs-calendar-check'></i>
          <span class="text">Bài báo</span>
        </a>
      </li>
      <li>
        <a class="navigate" href="admin_document.php">
          <i class='bx bxs-file'></i>
          <span class="text">Tài liệu</span>
        </a>
      </li>
      <li>
        <a class="navigate" href="admin_slide.php">
          <i class='bx bxs-group'></i>
          <span class="text">Slide</span>
        </a>
      </li>
      <li>
        <a class="navigate" href="admin_user.php">
          <i class='bx bxs-group'></i>
          <span class="text">Người dùng</span>
        </a>
      </li>
      <li>
        <a class="navigate" href="admin_notification.php">
          <i class='bx bxs-message-dots'></i>
          <span class="text">Thông báo</span>
        </a>
      </li>
    </ul>
    <ul class="side-menu">
      <li>
        <a href="main.php">
          <i class='bx bx-user-circle'></i>
          <span class="text">Về trang người dùng</span>
        </a>
      </li>
      <li>
        <a href="logout.php" class="logout">
          <i class='bx bxs-log-out-circle'></i>
          <span class="text">Đăng xuất</span>
        </a>
      </li>
    </ul>
  </section>
  <!-- SIDEBAR -->

  <!-- CONTENT -->
  <section id="content">
    <!-- NAVBAR -->
    <nav>
      <i class='bx bx-menu'></i>
      <form action="#">
        <div class="form-input">
          <input type="search" placeholder="Tìm bài viết...">
          <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
        </div>
        <ul class='search-results hide'>
        </ul>
      </form>
      <input type="checkbox" id="switch-mode" hidden>
      <label for="switch-mode" class="switch-mode"></label>
      <a href="notice.php" class="notification navigate">
        <i class='bx bxs-bell'></i>
        <span class="num"><?= count(Notification::list_notification_of_user($_SESSION['userid'])) ?></span>
      </a>
      <a href="update_info.php" class="profile">
        <?php
        $admin = User::get_admin_by_email($_SESSION['adminemail']);
        if (isset($admin[0]['AVATAR']) && !empty($admin[0]['AVATAR'])) {
          echo '<img src="' . $admin[0]['AVATAR'] . '">';
        } else {
          echo '<img src="https://i.pinimg.com/originals/ac/0b/3b/ac0b3b4f2f7c1a89e045b2f186d6f7e1.jpg">';
        }
        ?>
      </a>
    </nav>
    <!-- NAVBAR -->

    <!-- MAIN -->
    <main id="main">
      <div class="head-title">
        <div class="left">
          <h1>Dashboard</h1>
          <ul class="breadcrumb">
            <li>
              <a class="navigate" href="#">Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
              <a class="active" class="navigate" href="#">Trang chủ</a>
            </li>
          </ul>
        </div>
        <a class="navigate" href="#" class="btn-download">
          <i class='bx bxs-cloud-download'></i>
          <span class="text">Download PDF</span>
        </a>
      </div>

      <ul class="box-info">
        <li>
          <i class='bx bxs-calendar-check'></i>
          <span class="text">
            <h3><?= count(Article::list_items()) ?></h3>
            <p>Bài viết và thông báo</p>
          </span>
        </li>
        <li>
          <i class='bx bxs-file'></i>
          <span class="text">
            <h3><?= count(Document::list_document_with_category()) ?></h3>
            <p>File tài liệu</p>
          </span>
        </li>
        <li>
          <i class='bx bxs-group'></i>
          <span class="text">
            <h3><?php
            $fp = '../log/statistic.txt';
            $fo = fopen($fp, 'r');
            $count = fread($fo, filesize($fp));
            echo $count;
            ?></h3>
            <p>Lượt truy cập</p>
          </span>
        </li>
      </ul>

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
  <script>
    function handleDeleteArticle(ID) {
      deleteForm = document.querySelector('.delete-form');
      inputDelete = document.querySelector('.delete-article');
      inputDelete.value = ID
      const deleteSuccess = true;
      deleteForm.submit()
    }

    function handleRead(ID) {
      readForm = document.querySelector('.read-form');
      inputRead = document.querySelector('.read-article');
      inputRead.value = ID
      readForm.submit()
    }
  </script>
  <script src="../js/dashboard.js"></script>
  <script>
    document.querySelectorAll('.navigate').forEach(link => {
      link.addEventListener('click', function (event) {
        event.preventDefault();

        let href = this.getAttribute('href');

        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
          if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
              document.getElementById('main').innerHTML = xhr.responseText;
            }
          }
        };
        xhr.open('GET', href, true);
        xhr.send();
      });
    });

    function handleDeleteDocument(ID) {
      if (confirm("Bạn có chắc chắn muốn xóa tài liệu này không?")) {
        deleteForm = document.querySelector('.delete-form');
        inputDelete = document.querySelector('.delete-document');
        inputDelete.value = ID
        deleteForm.submit();
      }
    }

    function handleDeleteUser(ID) {
      if (confirm("Bạn có chắc chắn muốn xóa tài liệu này không?")) {
        deleteForm = document.querySelector('.delete-form');
        inputDelete = document.querySelector('.delete-user');
        inputDelete.value = ID
        deleteForm.submit();
      }
    }


    function handleDeleteSlide(ID) {
      if (confirm("Bạn có chắc chắn muốn xóa slide này không?")) {
        deleteForm = document.querySelector('.delete-form');
        inputDelete = document.querySelector('.delete-slide');
        inputDelete.value = ID
        deleteForm.submit();
      }

    const searchBox = document.querySelector('input[type=search]');
    const searchResults = document.querySelector('.search-results');
    const searchBtn = document.querySelector('.search-btn');

    searchBox.oninput = function(event) {
      performSearch();
    }

    searchBox.addEventListener('keypress', function(event) {
      if (event.key === 'Enter') {
        event.preventDefault();
        performSearch();
      }
    });

    searchBtn.onclick = (event) => {
      event.preventDefault();
      performSearch();
    }

    function performSearch() {
      searchResults.classList.remove('hide')
      const keySearch = searchBox.value.trim();
      if (keySearch !== '') {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'search_articles.api.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            const articles = JSON.parse(xhr.responseText);
            displayResults(articles);
          }
        };

        xhr.send(`keysearch=${keySearch}`);
      }
    }

    function displayResults(articles) {
      searchResults.innerHTML = "<li class='text-right close-btn'> &times </li>";
      if (articles.length > 0) {
        articles.forEach(article => {
          searchResults.innerHTML += `
                <li class='d-flex justify-content-between align-items-center'>
                    <img class='news-image' src='${article.THUMBNAIL}' alt='Thumbnail'/>
                    <div class='info'>
                        <a href='article_detail.php?id=${article.ID}' class='notification-title'>${article.TITLE}</a>
                        <span class='publish-day'>${article.PUBLISH}</span>
                    </div>
                </li>`;
        });
      } else {
        searchResults.innerHTML += "<li>Không có bài báo nào được tìm thấy</li>";
      }

      document.querySelector('.close-btn').onclick = function(event) {
        searchResults.innerHTML = '';
        searchResults.classList.add = 'hide';
      };
    }
  </script>
</body>

</html>