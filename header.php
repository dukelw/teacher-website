<?php
ob_start();
include_once("./entities/article.class.php");
session_start();
?>

<?php
require_once("./entities/user.class.php");
$loginAttempted=true;
if (isset($_SESSION['username']) != "") {

}
if (isset($_POST["email"]) && isset($_POST["password"])) {
    $loginAttempted = false; // Khởi tạo biến kiểm tra đăng nhập
    $success = User::checkLogin($_POST["email"], $_POST["password"]);
    if (!$success) {
        $loginAttempted = false; // Đã thử đăng nhập
    } else {
        $email = $_POST["email"];
        $username = User::get_user($email);
        $_SESSION['userID'] = $username[0]['ID'];
        $_SESSION['username'] = $username[0]["NAME"];
        $_SESSION['useremail'] = $email;
        $_SESSION['userthumb'] = $username[0]['AVATAR'];
    }
}
?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
<link rel="stylesheet" href="./css/header.css">
<header class="blog-header py-3">
  <div class="row flex-nowrap justify-content-between align-items-center">
    <div class="col-4 pt-1 d-flex justify-content-center align-items-start flex-column search-container">
      <div class="col-12 pt-1 d-flex justify-content-start align-items-center">
        <span class="text-muted search-toggle">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3">
            <circle cx="10.5" cy="10.5" r="7.5"></circle>
            <line x1="21" y1="21" x2="15.8" y2="15.8"></line>
          </svg>
        </span>
        <form action="#" class="search-wrapper">
          <input class="search-box" type="text" placeholder="Nhập từ khóa...">
          <span class="search-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3">
              <circle cx="10.5" cy="10.5" r="7.5"></circle>
              <line x1="21" y1="21" x2="15.8" y2="15.8"></line>
            </svg>
          </span>
          <input type="text" hidden name="keysearch">
        </form>
      </div>
      <ul class='search-results hide'>
      </ul>
    </div>
    <div class="col-4 text-center">
      <a class="blog-header-logo text-dark" href="main.php">Website giảng viên</a>
    </div>
    <div class="col-4 d-flex justify-content-end align-items-center">
      <?php
      include_once("./entities/user.class.php");
      if (isset($_SESSION['username']) && $_SESSION['username'] != "") {
        echo "
          <div class='user-info'>
            <img class='user-avatar' alt='Avatar' src='" . User::get_user($_SESSION["useremail"])[0]["AVATAR"] . "'>
            <span class=\"username\">" . User::get_user($_SESSION["useremail"])[0]["NAME"] . "</span>
            <ul class='dropdown__menu'>
               <li class='dropdown__item'>  
               <a class='dropdown__item' href='logout.php'>
                  <i class='ri-message-3-line dropdown__icon'></i>
                  <span class='dropdown__name'>Đăng xuất</span>
                </a>
                 
               </li>

               <li class='dropdown__item'>
                  <a class='dropdown__item' href='update_info.php'>
                    <i class='ri-lock-line dropdown__icon'></i>
                    <span class='dropdown__name'>Thông tin tài khoản</span>
                  </a>
                  
               </li>

               <li class='dropdown__item'>
                  <i class='ri-settings-3-line dropdown__icon'></i>
                  <span class='dropdown__name'>Settings</span>
               </li>
            </ul>
          </div>";
      } else {
        echo "<i style='cursor:pointer;' class='ri-user-line' id='login-btn'></i>";
      }
      ?>
    </div>
  </div>

  <!--==================== LOGIN ====================-->
  <div class="login" id="login">
         <form class="login__form" action="" method="POST">
            <h2 class="login__title">Log In</h2>

            <?php if ($loginAttempted===false) : ?>
              <div class="alert alert-danger" role="alert">
                  <i class="ri-error-warning-line mr-2"></i> Sai mật khẩu hoặc tài khoản!
              </div>
            <?php endif; ?>

            <div class="login__group">
               <div>
                  <label for="email" class="login__label">Email</label>
                  <input type="email" name="email" placeholder="Write your email" id="email" class="login__input">
               </div>
               
               <div>
                  <label for="" class="login__label">Password</label>
                  <input type="password" name="password" placeholder="Enter your password" id="password" class="login__input">
               </div>
            </div>

            <div>
               <p class="login__signup">
                  You do not have an account? <a href="./signup.php">Sign up</a>
               </p>
   
               <a href="./forgot_password.php" class="login__forgot">
                  You forgot your password
               </a>
   
               <button type="submit" class="login__button">Log In</button>
            </div>
         </form>

         <i class="ri-close-line login__close" id="login-close"></i>
      </div>
</header>

<div class="nav-scroller py-1 mb-2">
  <nav class="nav d-flex justify-content-between">
    <a class="p-2 text-muted" href="introduction.php">Giới thiệu</a>
    <a class="p-2 text-muted" href="document.php">Tài liệu</a>
    <a class="p-2 text-muted" href="notifications.php">Thông báo</a>
    <a class="p-2 text-muted" href="news.php">Tin tức</a>
    <a class="p-2 text-muted" href="./career.php">Doanh nghiệp</a>
  </nav>
</div>
<script src="./js/header.js"></script>
<script>

  const searchToggle = document.querySelector('.search-toggle')
  const searchWrapper = document.querySelector('.search-wrapper')
  const searchBox = document.querySelector('.search-box')
  const searchIcon = document.querySelector('.search-icon')
  const hiddenInput = document.querySelector('input[name="keysearch"]')
  const closeBtn = document.querySelector('.close-btn')

  searchToggle.onclick = function(event) {
    searchWrapper.classList.add('active-flex');
    searchToggle.classList.add('hide');
    searchBox.focus();
  }

  searchBox.oninput = function(event) {
    performSearch();
  }

  searchBox.addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
      event.preventDefault();
      performSearch();
    }
  });

  if (closeBtn != null) {
    closeBtn.onclick = function(event) {
      hiddenInput.value = '';
      searchResults.innerHTML = '';
      searchWrapper.classList.remove('active-flex');
      searchToggle.classList.remove('hide');
    }
  }

  function performSearch() {
    searchResults.classList.remove('hide')
    const keySearch = searchBox.value.trim();
    if (keySearch !== '') {
      hiddenInput.value = keySearch;

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
                <li class=''>
                    <div class='d-flex justify-content-between align-items-center'>
                        <img class='news-image' src='${article.THUMBNAIL}' alt='Thumbnail'/>
                        <p>
                            <a href='article_detail.php?id=${article.ID}' class='notification-title'>${article.TITLE}</a>
                            <span class='publish-day'>${article.PUBLISH}</span>
                        </p>
                    </div>
                </li>`;
      });
    } else {
      searchResults.innerHTML += "<li>Không có bài báo nào được tìm thấy</li>";
    }

    document.querySelector('.close-btn').onclick = function(event) {
      hiddenInput.value = '';
      searchResults.innerHTML = '';
      searchResults.classList.add = 'hide';
      searchWrapper.classList.remove('active-flex');
      searchToggle.classList.remove('hide');
    };
  }

  const user = document.querySelector(".user-info");

  if (user) {
    user.onmouseenter = () => {
      const optionsForm = document.querySelector('.user-options');
      optionsForm.classList.add('active');
    };

    user.onmouseleave = () => {
      const optionsForm = document.querySelector('.user-options');
      optionsForm.classList.remove('active');
    };
  }

</script>