<link rel="stylesheet" href="./css/header.css">
<header class="blog-header py-3">
  <div class="row flex-nowrap justify-content-between align-items-center">
    <div class="col-4 pt-1">
      <a class="text-muted" href="#">Về trang chủ</a>
    </div>
    <div class="col-4 text-center">
      <a class="blog-header-logo text-dark" href="main.php">Khoa công nghệ thông tin</a>
    </div>
    <div class="col-4 d-flex justify-content-end align-items-center">
      <a class="text-muted" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3">
          <circle cx="10.5" cy="10.5" r="7.5"></circle>
          <line x1="21" y1="21" x2="15.8" y2="15.8"></line>
        </svg>
      </a>
      <?php
      include_once("./entities/teacher.class.php");
      session_start();
      if (isset($_SESSION['username']) && $_SESSION['username'] != "") {
        echo "
          <div class='user-info'>
            <img class='user-avatar' alt='Avatar' src='" . Teacher::get_teacher($_SESSION["useremail"])[0]["AVATAR"] . "'>
            <span class=\"username\">" . $_SESSION["username"] . "</span>
            <ul class='user-options'>
              <li class='user-item'><a class='navigate-link' href='logout.php'>Đăng xuất</a></li>
              <li class='user-item'><a class='navigate-link' href='update_info.php'>Cập nhật thông tin</a></li>
              <li class='user-item'><a class='navigate-link' href='logout.php'>Đăng xuất</a></li>
              <li class='user-item'><a class='navigate-link' href='logout.php'>Đăng xuất</a></li>
            </ul>
          </div>";
      } else {
        echo "<a class='btn btn-sm btn-outline-secondary' href='./signin.php'>Sign up</a>";
      }
      ?>
    </div>
  </div>
</header>

<div class="nav-scroller py-1 mb-2">
  <nav class="nav d-flex justify-content-between">
    <a class="p-2 text-muted" href="#">Giới thiệu</a>
    <a class="p-2 text-muted" href="#">Giáo dục</a>
    <a class="p-2 text-muted" href="notifications.php">Thông báo</a>
    <a class="p-2 text-muted" href="news.php">Tin tức</a>
    <a class="p-2 text-muted" href="#">Doanh nghiệp</a>
    <a class="p-2 text-muted" href="#">Tuyển sinh</a>
    <a class="p-2 text-muted" href="#">Cấm thi</a>
  </nav>
</div>

<script>
  const user = document.querySelector(".user-info")
  user.onclick = () => {
    const optionsForm = document.querySelector('.user-options')
    if (optionsForm.classList.contains('active')) {
      optionsForm.classList.remove('active')
    } else {
      optionsForm.classList.add('active')
    }
  }
</script>