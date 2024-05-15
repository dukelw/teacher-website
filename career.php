<?php
include_once("./entities/article.class.php");
include_once("./entities/subject.class.php");
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
  <link href="./css/article_detail.css" rel="stylesheet">
  <link rel="stylesheet" href="./assets/icon/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="./css/news.css">
  <link rel="stylesheet" href="./css/darkmode.css">
  <script src="./assets/js/jquery-slim.min.js"></script>
  <script src="./assets/js/holder.min.js"></script>
  <script src="./assets/js/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js"></script>
</head>

<body>
  <div class="container">
    <?php include_once("./header.php");
    ?>
  </div>

  <main role="main" class="container">
    <div class="row">
      <div class="col-md-12 blog-main">
        <?php
        // Lấy thông tin chủ đề có ID là 4
        $subject = Subject::get_subject(4);
        if (!empty($subject)) {
          echo "<h3 class='pb-3 font-italic border-bottom'>
            " . $subject[0]["NAME"] . "
          </h3>";

          $articlesPerPage = 6;
          $page = isset($_GET['page']) ? $_GET['page'] : 1;
          $start = ($page - 1) * $articlesPerPage;

          // Lấy danh sách các bài viết thuộc chủ đề có ID là 4
          $articles = Article::list_articles_pagination_type($start, $articlesPerPage, 4);

          foreach ($articles as $item) {
            echo "
              <div class='col-md-6'>
                  <div class='d-flex justify-content-between align-items-center'>
                      <img class='news-image' src='" . $item["THUMBNAIL"] . "' alt='Thumbnail'/>
                      <p>
                          <a href='article_detail.php?id=" . $item["ID"] . "' class='notification-title'> " . $item["TITLE"] . "</a>
                          <span class='publish-day'>" . $item["PUBLISH"] . "</span>
                      </p>
                  </div>
              </div>
              ";
          }
        } else {
          echo "<h3 class='pb-3 font-italic border-bottom'>
            Không có chủ đề nào có ID là 4
          </h3>";
        }
        ?>
      </div>
    </div>
  </main>
  <div class="container">
    <div class="title text-center mb-3">
      <h4>DOANH NGHIỆP IT NỔI BẬT</h4>
    </div>
    <div class="row">
      <div class="gsc-column col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="column-content">
          <div class="post-block row" style="padding-bottom: 40px;">
            <div class="col-md-4 no-padding col-md-offset-1" style="box-shadow: 0 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%); margin-bottom: 20px;margin-left:97.4875px;width:389.987px;">
              <div class="row">
                <div class="post-image col-sm-4 col-xs-4"><img style="max-width:100%;" src="./upload/IPSIP.png" alt="Công ty TNHH MTV IPSIP VIỆT NAM"></div>
                <div class="post-content col-sm-8 col-xs-8 no-padding" style="padding-top: 18px !important;">
                  <div class="post-title">Công ty TNHH MTV IPSIP VIỆT NAM</div>
                  <div>Website: <a href="https://www.ipsip.vn/" target="__blank">https://www.ipsip.vn/</a></div>
                </div>
              </div>
            </div>
            <div class="col-md-4 no-padding col-md-offset-2" style="box-shadow: 0 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%); margin-bottom: 20px;margin-left:195px">
              <div class="row">
                <div class="post-image col-sm-4 col-xs-4"><img style="max-width:100%;" src="./upload/techbase.png" alt="Công ty TNHH TECHBASE VIỆT NAM"></div>
                <div class="post-content col-sm-8 col-xs-8 no-padding" style="padding-top: 18px !important;">
                  <div class="post-title">Công ty TNHH TECHBASE VIỆT NAM</div>
                  <div>Website: <a href="https://www.techbasevn.com/" target="__blank">https://www.techbasevn.com/</a></div>
                </div>
              </div>
            </div>
          </div>


        </div>
        <div class="post-block row" style="padding-bottom: 40px;">
          <div class="col-md-4 no-padding col-md-offset-1" style="box-shadow: 0 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%); margin-bottom: 20px; margin-left:97.4875px;">
            <div class="row">
              <div class="post-image col-sm-4 col-xs-4"><img style="max-width:100%;" src="./upload//TPS.png" alt="Công ty Cổ phần Phần mềm TPS"></div>
              <div class="post-content col-sm-8 col-xs-8 no-padding" style="padding-top: 18px !important;">
                <div class="post-title">Công ty Cổ phần Phần mềm TPS</div>
                <div>Website: <a href="https://www.tpssoft.com/" target="__blank">https://www.tpssoft.com/</a></div>
              </div>
            </div>
          </div>
          <div class="col-md-4 no-padding col-md-offset-2" style="box-shadow: 0 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%); margin-bottom: 20px; margin-left:195px">
            <div class="row">
              <div class="post-image col-sm-4 col-xs-4"><img style="max-width:100%;" src="./upload/HARVEY-NASH.png" alt="Công ty TNHH HARVEY NASH VIỆT NAM"></div>
              <div class="post-content col-sm-8 col-xs-8 no-padding" style="padding-top: 18px !important;">
                <div class="post-title">Công ty TNHH HARVEY NASH VIỆT NAM</div>
                <div>Website: <a href="https://nashtechglobal.com" target="__blank">https://nashtechglobal.com</a></div>
              </div>
            </div>
          </div>
        </div>

        <div class="post-block row" style="padding-bottom: 40px;">
          <div class="col-md-4 no-padding col-md-offset-1" style="box-shadow: 0 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%); margin-bottom: 20px; margin-left:97.4875px;">
            <div class="row">
              <div class="post-image col-sm-4 col-xs-4"><img style="max-width:100%;" src="./upload/NUS.png" alt="Công ty CỔ PHẦN CÔNG NGHỆ PHẦN MỀM NUS"></div>
              <div class="post-content col-sm-8 col-xs-8 no-padding" style="padding-top: 18px !important;">
                <div class="post-title">Công ty CỔ PHẦN CÔNG NGHỆ PHẦN MỀM NUS</div>
                <div>Website: <a href="https://www.nustechnology.com" target="__blank">https://www.nustechnology.com</a></div>
              </div>
            </div>
          </div>
          <div class="col-md-4 no-padding col-md-offset-2" style="box-shadow: 0 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%); margin-bottom: 20px; margin-left:195px">
            <div class="row">
              <div class="post-image col-sm-4 col-xs-4"><img style="max-width:100%;" src="./upload//idtek.png" alt="Công ty Cổ phần IDTEK"></div>
              <div class="post-content col-sm-8 col-xs-8 no-padding" style="padding-top: 18px !important;">
                <div class="post-title">Công ty Cổ phần IDTEK</div>
                <div>Website: <a href="https://www.idtek.com.vn/" target="__blank">https://www.idtek.com.vn/</a></div>
              </div>
            </div>
          </div>
        </div>

        <div class="post-block row" style="padding-bottom: 40px;">
          <div class="col-md-4 no-padding col-md-offset-1" style="box-shadow: 0 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%); margin-bottom: 20px; margin-left:97.4875px;">
            <div class="row">
              <div class="post-image col-sm-4 col-xs-4"><img style="max-width:100%;" src="./upload/logix_technology.png" alt="Công ty TNHH Logix Technology Việt Nam"></div>
              <div class="post-content col-sm-8 col-xs-8 no-padding" style="padding-top: 18px !important;">
                <div class="post-title">Công ty TNHH Logix Technology Việt Nam</div>
                <div>Website: <a href="https://logixtek.com/" target="__blank">https://logixtek.com/</a></div>
              </div>
            </div>
          </div>
          <div class="col-md-4 no-padding col-md-offset-2" style="box-shadow: 0 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%); margin-bottom: 20px; margin-left:195px">
            <div class="row">
              <div class="post-image col-sm-4 col-xs-4"><img style="max-width:100%;" src="./upload/OMN1.png" alt="Công ty TNHH GIẢI PHÁP OMN1"></div>
              <div class="post-content col-sm-8 col-xs-8 no-padding" style="padding-top: 18px !important;">
                <div class="post-title">Công ty TNHH GIẢI PHÁP OMN1</div>
                <div>Website: <a href="https://omn1solution.com/" target="__blank">https://omn1solution.com/</a></div>
              </div>
            </div>
          </div>
        </div>

        <div class="post-block row" style="padding-bottom: 40px;">
          <div class="col-md-4 no-padding col-md-offset-1" style="box-shadow: 0 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%); margin-bottom: 20px; margin-left:97.4875px;">
            <div class="row">
              <div class="post-image col-sm-4 col-xs-4"><img style="max-width:100%;" src="./upload/gameloft.png" alt="Công ty TNHH GAMELOFT"></div>
              <div class="post-content col-sm-8 col-xs-8 no-padding" style="padding-top: 18px !important;">
                <div class="post-title">Công ty TNHH GAMELOFT</div>
                <div>Website: <a href="https://www.gameloft-sea.com/" target="__blank">https://www.gameloft-sea.com/</a></div>
              </div>
            </div>
          </div>
          <div class="col-md-4 no-padding col-md-offset-2" style="box-shadow: 0 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%); margin-bottom: 20px; margin-left:195px">
            <div class="row">
              <div class="post-image col-sm-4 col-xs-4"><img style="max-width:100%;" src="./upload/CYBERLOGITEC.png" alt="Công ty TNHH CYBERLOGITEC"></div>
              <div class="post-content col-sm-8 col-xs-8 no-padding" style="padding-top: 18px !important;">
                <div class="post-title">Công ty TNHH CYBERLOGITEC</div>
                <div>Website: <a href="http://www.cyberlogitec.com.vn/" target="__blank">http://www.cyberlogitec.com.vn/</a></div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
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
  <script src="./js/darkmode.js"></script>
</body>

</html>