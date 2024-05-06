<?php
include_once('./entities/article.class.php');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">
    <title>Dashboard Admin</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/dashboard/">
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="./dashboard.css" rel="stylesheet">
</head>

<body>
    <?php include_once("./dashboardheader.php") ?>
    <div class="main">
        <h3 class="pb-3 font-italic border-bottom">
            Tất cả
        </h3>
        <div class="row">
            <div class="col-md-3 d-flex justify-content-center">
                <div class="statistic-item article d-flex justify-content-center align-items-center">
                    <img class="statistic-image" src="./upload/article.png" alt="">
                    <div class="d-flex flex-column justify-content-center align-items-between">
                        <h2><?= count(Article::list_items()) ?></h2>
                        <p class="statistic-content">Bài viết</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex justify-content-center">
                <div class="statistic-item file article d-flex justify-content-center align-items-center">
                    <img class="statistic-image" src="./upload/file.png" alt="">
                    <div class="d-flex flex-column justify-content-center align-items-between">
                        <h2>123456</h2>
                        <p class="statistic-content">Tệp</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex justify-content-center">
                <div class="statistic-item access d-flex justify-content-center align-items-center">
                    <img class="statistic-image" src="./upload/access.png" alt="">
                    <div class="d-flex flex-column justify-content-center align-items-between">
                        <h2>123456</h2>
                        <p class="statistic-content">Lượt truy cập</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex justify-content-center">
                <div class="statistic-item article d-flex justify-content-center align-items-center">
                    <img class="statistic-image" src="./upload/article.png" alt="">
                    <div class="d-flex flex-column justify-content-center align-items-between">
                        <h2>123456</h2>
                        <p class="statistic-content">Bài viết</p>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once("./list_article.php") ?>
    </div>
</body>

</html>

<style>
    .main {
        margin-top: 100px;
    }

    .statistic-image {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 50px;
        height: 50px;
        margin-right: 12px;
    }

    .statistic-item {
        margin-bottom: 20px;
        border-radius: 20px;
        width: 80%;
    }

    .statistic-item.article {
        background-color: #86e49d;
    }

    .statistic-item.file {
        background-color: #d893a3;
    }

    .statistic-item.access {
        background-color: #ebc474;
    }

    .statistic-content {
        font-size: 16px;
    }
</style>

.status.job {
background-color: #6fcaea;
}