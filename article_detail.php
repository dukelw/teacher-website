  <div class="container">
    <?php include_once("./header.php"); ?>
  </div>
  <?php
  include_once("./entities/article.class.php");
  include_once("./entities/subject.class.php");
  include_once("./entities/comment.class.php");
  include_once("./entities/user.class.php");
  ?>

  <?php
  if (isset($_GET["id"]) == null) {
    header("Location: notfound.php");
  } else {
    $id = $_GET["id"];
    $article = Article::get_article($id);
  }
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  if (isset($_SESSION['useremail'])) {
    if (isset($_POST['content'])) {
      $articleID = $_GET["id"];
      $userID = intval($_SESSION['userID']);
      $username = $_SESSION["username"];
      $userthumb = $_SESSION["userthumb"];
      $parentName = '';
      $content = $_POST["content"];
      if (isset($_POST["parentID"])) {
        $parent_comment_id = $_POST["parentID"];
        $parentName = User::get_user_by_ID($userID)[0]["NAME"];
      } else {
        $parent_comment_id = -1;
      }
      $result = Comment::createComment($articleID, $userID, $username, $userthumb, $parentName, $content, $parent_comment_id);
      if ($result) {
        header("Location: #");
      }
    }
  } else if (!isset($_SESSION['useremail']) && isset($_POST['content'])) {
    header("Location: signin.php");
  }

  if (isset($_POST["delete-target"])) {
    $result = Comment::deleteComment($_POST["delete-target"]);
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
    <link rel="stylesheet" href="./css/darkmode.css">
    <script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js"></script>
  </head>

  <body>
    <main role="main" class="container">
      <div class="row">
        <div class="col-md-9 blog-main" style="overflow: hidden;">
          <?= $article[0]["CONTENT"] ?>
          <p style="margin-top: 16px;">
            Tag:
            <a href="news.php?page=1&subject=<?= $article[0]['TYPE'] ?>" style="padding: 6px 12px; background-color: red; color: white; border-radius: 12px;"><?= Subject::get_subject($article[0]["TYPE"])[0]["NAME"] ?></a>
          </p>
          <h3 class="pb-3 font-italic border-bottom">
            Bình luận
          </h3>
          <form class="comment-container" action="" method="POST">
            <textarea class="comment-input-box" name="content" placeholder="Nhập bình luận tại đây..." id="comment"></textarea>
            <input type="button" value="Tạo" class="submitbtn">
          </form>
          <?php
          function calculateTimeAgo($createdAt)
          {
            date_default_timezone_set('Asia/Ho_Chi_Minh');

            $createdAtDate = new DateTime($createdAt);
            $currentDate = new DateTime();

            $timeDifference = $currentDate->getTimestamp() - $createdAtDate->getTimestamp();
            $minutesAgo = floor($timeDifference / 60);
            $hoursAgo = floor($timeDifference / (60 * 60));
            $daysAgo = floor($timeDifference / (60 * 60 * 24));
            $monthsAgo = floor($daysAgo / 30);

            if ($minutesAgo < 60) {
              return $minutesAgo <= 1 ? 'Just now' : $minutesAgo . ' minutes ago';
            } elseif ($hoursAgo < 24) {
              return $hoursAgo <= 1 ? '1 hour ago' : $hoursAgo . ' hours ago';
            } elseif ($daysAgo < 30) {
              return $daysAgo <= 1 ? '1 day ago' : $daysAgo . ' days ago';
            } else {
              return $monthsAgo <= 1 ? '1 month ago' : $monthsAgo . ' months ago';
            }
          }

          function displayComments($comments, $depth = 0)
          {
            foreach ($comments as $comment) {
              echo "<div class='comment__card reply-" . $comment["parentID"] . "' style='margin-left: " . ($depth * 20) . "px;'>";
              echo "<div class='info'>";
              echo "<img src='" . User::get_user_by_ID($comment['userID'])[0]["AVATAR"] . "' alt='Ảnh đại diện'>";
              echo "<div class='right'>";
              echo "<h5 class='comment__title'>" . User::get_user_by_ID($comment['userID'])[0]["NAME"] . "</h5>";
              echo "<p>" . $comment['content'] . "</p>";
              echo "</div>";
              echo "</div>";
              echo "<div class='comment__card-footer'>";
              $childrenComments = Comment::get_comment_by_parentID($comment['titleID'], $comment['ID']);
              $numChildren = count($childrenComments);
              $time = new DateTime();
              echo "<div class='time'>" . calculateTimeAgo($comment['createAt']) . " </div>";
              echo "<div class='actions'>";
              echo "<div class='action reply-btn show-replies' onclick='handleReply(" . $comment['ID'] . ")'>Reply";
              if ($numChildren > 0) {
                echo " [$numChildren]";
              }
              echo "</div>";
              echo "<div class='action' onclick='handleDelete(" . $comment['ID'] . ")'>Delete</div>";
              echo "</div>";
              echo "</div>";

              echo "<form style='display: none;' class='reply-relate comment-container reply-" . $comment['ID'] . "' action='' method='POST'>";
              echo "<textarea class='comment-input-box' name='content' placeholder='Nhập bình luận tại đây...'></textarea>";
              echo "<input type='button' value='Tạo' class='submitbtn-reply'>";
              echo "<input hidden type='text' name='parentID' class='reply-id-" . $comment['ID'] . "' value='" . $comment['ID'] . "'>";
              echo "</form>";

              displayComments($childrenComments, $depth + 1);

              echo "</div>";
            }
          }

          $parentComments = Comment::get_all_parent_comment($_GET['id']);
          displayComments($parentComments);
          ?>
          <form class="delete-form" action="" method="POST">
            <input hidden class='delete-target' name="delete-target"></input>
          </form>
        </div>

        <aside class=" col-md-3 blog-sidebar">
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
    <script>
      pID = -1
      createForm = document.querySelector('.comment-container');
      commentInput = document.querySelector('#comment')
      replyInput = document.querySelector('.reply-id');
      submitBtn = document.querySelector('.submitbtn');
      submitReplyBtns = document.querySelectorAll('.submitbtn-reply');
      replyBtn = document.querySelector('.reply-btn');
      submitBtn.onclick = function() {
        createForm.submit();
      }
      commentInput.addEventListener('keydown', function(event) {
        if (event.key === "Enter" && !event.shiftKey && !event.ctrlKey) {
          event.preventDefault();
          createForm.submit();
        }
      });

      function handleReply(parentID) {
        const replyForm = document.querySelector(`.reply-${parentID}`)
        replyForm.addEventListener('keydown', function(event) {
          if (event.key === "Enter" && !event.shiftKey && !event.ctrlKey) {
            event.preventDefault();
            replyForm.submit();
          }
        });
        const replyTarget = document.querySelector(`.reply-id-${parentID}`);
        const childrenReply = document.querySelectorAll(`.child-reply-${parentID}`);
        pID = parentID;
        replyTarget.value = parentID;
        const replyBox = document.querySelector(`.reply-${parentID}`)
        if (replyBox.classList.contains("show")) {
          childrenReply.forEach(child => {
            child.classList.add('hidden');
          })
          replyBox.classList.remove('show');
        } else {
          replyBox.classList.add('show');
          childrenReply.forEach(child => {
            child.classList.remove('hidden');
          })
        }
      }

      function handleDelete(ID) {
        const deleteForm = document.querySelector('.delete-form');
        const deleteTarget = document.querySelector('.delete-target');
        deleteTarget.value = ID;
        deleteForm.submit();
      }

      submitReplyBtns.forEach(btn => {
        btn.onclick = function() {
          const replyContentForm = document.querySelector(`.reply-${pID}`)
          replyContentForm.submit();
        }
      })
    </script>
    <script src="./js/darkmode.js"></script>
  </body>

  </html>