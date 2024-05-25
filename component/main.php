<?php
include_once ("../entities/article.class.php");
include_once ("../entities/subject.class.php");
$fp = '../log/statistic.txt';
$fo = fopen($fp, 'r');
$count = fread($fo, filesize($fp));
$count++;
$fc = fclose($fo);
$fo = fopen($fp, 'w');
$fw = fwrite($fo, $count);
$fc = fclose($fo);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Teacher Website</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/blog/">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <link rel="icon" href="../assets/images/logo.png" type="image/x-icon" />
    <link href="../css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/icon/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/blog.css">
    <link rel="stylesheet" href="../css/darkmode.css">
    <script src="../assets/js/jquery-slim.min.js"></script>
    <script src="../assets/js/holder.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js"></script>
</head>

<body>
    <div class="container">
        <?php
        include_once ("header.php");
        include_once ("slider.php")
            ?>
        <?php
        $articles = Article::list_articles();
        $featureone = $articles[count($articles) - 1];
        $featuretwo = $articles[count($articles) - 2];
        echo "<div class='row mb-2'>
            <div class='col-md-6'>
                <div class='card flex-md-row mb-4 box-shadow h-md-250'>
                    <div class='card-body d-flex flex-column align-items-start'>
                        <strong class='d-inline-block mb-2 text-primary'>" . Subject::get_subject($featureone["TYPE"])[0]["NAME"] . "</strong>
                        <h3 class='mb-0'>
                            <a class='text-dark feature-title' href='#'>" . $featureone["TITLE"] . ".</a>
                        </h3>
                        <div class='mb-1 text-muted'>" . $featureone["PUBLISH"] . "</div>
                        <p class='mb-auto feature-description'>" . $featureone["DESCRIPTION"] . "</p>
                        <a href='article_detail.php?id=" . $featureone["ID"] . "'>Tiếp tục đọc</a>
                    </div>
                    <img class='card-img-right flex-auto d-none d-md-block custom-image' src='" . $featureone["THUMBNAIL"] . "' alt='Card image cap'>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='card flex-md-row mb-4 box-shadow h-md-250'>
                    <div class='card-body d-flex flex-column align-items-start'>
                        <strong class='d-inline-block mb-2 text-primary green-color'>" . Subject::get_subject($featuretwo["TYPE"])[0]["NAME"] . "</strong>
                        <h3 class='mb-0'>
                            <a class='text-dark feature-title' href='#'>" . $featuretwo["TITLE"] . ".</a>
                        </h3>
                        <div class='mb-1 text-muted'>" . $featuretwo["PUBLISH"] . "</div>
                        <p class='mb-auto feature-description'>" . $featuretwo["DESCRIPTION"] . "</p>
                        <a href='article_detail.php?id=" . $featuretwo["ID"] . "'>Tiếp tục đọc</a>
                    </div>
                    <img class='card-img-right flex-auto d-none d-md-block custom-image' src='" . $featuretwo["THUMBNAIL"] . "' alt='Card image cap'>
                </div>
            </div>
        </div>"
            ?>
    </div>

    <main role="main" class="container">
        <div class="row">
            <div class="col-md-9 blog-main">
                <h3 class="pb-3 font-italic border-bottom">
                    Tin tức
                </h3>
                <div class="row">
                    <?php
                    $articles = Article::list_articles_news();
                    foreach ($articles as $article) {
                        echo "
                        <div class='col-md-4 news-card'>
                        <div class='card' style='width: 100%;'>
                            <a class='card-detail' href='article_detail.php?id=" . $article["ID"] . "'>
                                <img src=" . $article["THUMBNAIL"] . " class='card-img-top custom-card-image' alt='Article Thumbnail'>
                                <div class='card-body d-flex flex-column' style='height: 350px;'>
                                    <div class='card-top'>
                                        <span>" . $article["PUBLISH"] . "</span>
                                        <span class='subject'>" . Subject::get_subject($article["TYPE"])[0]["NAME"] . "</span>
                                    </div>
                                    <div style='flex: 1;' class='card-bottom d-flex flex-column'>
                                        <h4 style='margin-bottom: auto;' class='card-title'> " . $article["TITLE"] . "</h4>
                                        <p class='card-text'> " . $article["DESCRIPTION"] . "</p>
                                    </div>
                                </div>
                                </div>
                            </a>
                        </div>
                    ";
                    }
                    ?>
                </div>
                <a class="more" href="news.php">Xem thêm</a>
            </div>

            <aside class="col-md-3 blog-sidebar">
                <h3 class="pb-3 mb-4 font-italic border-bottom">
                    Thông báo
                </h3>

                <?php
                $notifications = Article::list_notifications();
                foreach ($notifications as $notification) {
                    echo "
                        <p>
                            <span class='ti-announcement'></span>
                            <a href='article_detail.php?id=" . $notification["ID"] . "' class='notification-title'> " . $notification["TITLE"] . "</a>
                            <span class='publish-day'>" . $notification["PUBLISH"] . "</span>
                        </p>
                    ";
                }
                ?>
            </aside>

        </div>
        <div class="spacer">
        </div>
        <div class="row">
            <div class="col-md-9 blog-main">
                <h3 class="pb-3 font-italic border-bottom">
                    Tất cả tin tức
                </h3>
                <div class="row">
                    <?php
                    $articles = Article::list_articles_pagination(1, 6);
                    foreach ($articles as $article) {
                        echo "
                        <div class='col-md-4 news-card'>
                        <div class='card' style='width: 100%;'>
                            <a class='card-detail' href='article_detail.php?id=" . $article["ID"] . "'>
                                <img src=" . $article["THUMBNAIL"] . " class='card-img-top custom-card-image' alt='Article Thumbnail'>
                                <div class='card-body d-flex flex-column' style='height: 350px;'>
                                    <div class='card-top'>
                                        <span>" . $article["PUBLISH"] . "</span>
                                        <span class='subject'>" . Subject::get_subject($article["TYPE"])[0]["NAME"] . "</span>
                                    </div>
                                    <div style='flex: 1;' class='card-bottom d-flex flex-column'>
                                        <h4 style='margin-bottom: auto;' class='card-title'> " . $article["TITLE"] . "</h4>
                                        <p class='card-text'> " . $article["DESCRIPTION"] . "</p>
                                    </div>
                                </div>
                                </div>
                            </a>
                        </div>
                    ";
                    }
                    ?>
                </div>
                <a class="more" href="news.php">Xem thêm</a>
            </div>
        </div>
        <div class="spacer">
        </div>
    </main>

    <?php include_once ("footer.php") ?>

    <script src="../assets/js/jquery-slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="../assets/js/jquery-slim.min.js"><\/script>')
    </script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/holder.min.js"></script>
    <script>
        Holder.addTheme('thumb', {
            bg: '#55595c',
            fg: '#eceeef',
            text: 'Thumbnail'
        });
    </script>
    <script src="../js/darkmode.js"></script>
</body>

</html>