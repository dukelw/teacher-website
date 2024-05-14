<?php
ob_start();
include_once("./entities/article.class.php");
session_start();
?>

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
            <ul class='user-options'>
              <li class='user-item'><a class='navigate-link' href='logout.php'>Đăng xuất</a></li>
              <li class='user-item'><a class='navigate-link' href='update_info.php'>Cập nhật thông tin</a></li>
              <li class='user-item'><a class='navigate-link' href='logout.php'>Đăng xuất</a></li>
              <li class='user-item'><a class='navigate-link' href='logout.php'>Đăng xuất</a></li>
            </ul>
          </div>";
      } else {
        echo "<a class='btn btn-sm btn-outline-secondary' href='./signin.php'>Sign in</a>";
      }
      ?>
    </div>
  </div>
</header>

<div class="nav-scroller py-1 mb-2">
  <nav class="nav d-flex justify-content-between">
    <a class="p-2 text-muted" href="introduction.php">Giới thiệu</a>
    <a class="p-2 text-muted" href="education.php">Giáo dục</a>
    <a class="p-2 text-muted" href="document.php">Tài liệu</a>
    <a class="p-2 text-muted" href="notifications.php">Thông báo</a>
    <a class="p-2 text-muted" href="news.php">Tin tức</a>
    <a class="p-2 text-muted" href="./career.php">Doanh nghiệp</a>
  </nav>
</div>

<script>
  const searchToggle = document.querySelector('.search-toggle');
  const searchWrapper = document.querySelector('.search-wrapper');
  const searchBox = document.querySelector('.search-box');
  const searchIcon = document.querySelector('.search-icon');
  const searchResults = document.querySelector('.search-results');
  const hiddenInput = document.querySelector('input[name="keysearch"]');
  const closeBtn = document.querySelector('.close-btn');

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