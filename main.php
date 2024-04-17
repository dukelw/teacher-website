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
    <link href="./css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/icon/themify-icons/themify-icons.css">
</head>

<body>

    <div class="container">
        <?php include_once("./header.php") ?>

        <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
            <div class="col-md-6 px-0">
                <h1 class="display-4 font-italic">Title of a longer featured blog post</h1>
                <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and
                    efficiently about what's most interesting in this post's contents.</p>
                <p class="lead mb-0"><a href="#" class="text-white font-weight-bold">Continue reading...</a></p>
            </div>
        </div>

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
                        <p class='card-text mb-auto feature-description'>" . $featureone["DESCRIPTION"] . "</p>
                        <a href='#'>Tiếp tục đọc</a>
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
                        <p class='card-text mb-auto feature-description'>" . $featuretwo["DESCRIPTION"] . "</p>
                        <a href='#'>Tiếp tục đọc</a>
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
                <h3 class="pb-3 mb-4 font-italic border-bottom">
                    Tin tức
                </h3>
                <div class="row">
                    <?php
                    $articles = Article::list_articles();
                    foreach ($articles as $article) {
                        echo "
                        <div class='col-md-4'>
                            <div class='card' style='width: 100%;'>
                                <img src=" . $article["THUMBNAIL"] . " class='card-img-top' alt='Article Thumbnail'>
                                <div class='card-body'>
                                    <div class='card-top'>
                                        <span>" . $article["PUBLISH"] . "</span>
                                        <span>" . Subject::get_subject($article["TYPE"])[0]["NAME"]  . "</span>
                                    </div>
                                    <h4 class='card-title'> " . $article["TITLE"] . "</h4>
                                    <p class='card-text'> " . $article["DESCRIPTION"] . "</p>
                                </div>
                            </div>
                        </div>
                    ";
                    }
                    ?>
                </div>
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
                            <a href='' class='notification-title'> " . $notification["TITLE"] . "</a>
                            <span class='publish-day'>" . $notification["PUBLISH"] . "</span>
                        </p>
                    ";
                }
                ?>
            </aside>

        </div>

        <!-- Default row -->
        <div class="row">
            <div class="col-md-8 blog-main">
                <h3 class="pb-3 mb-4 font-italic border-bottom">
                    From the Firehose
                </h3>

                <div class="blog-post">
                    <h2 class="blog-post-title">Sample blog post</h2>
                    <p class="blog-post-meta">January 1, 2014 by <a href="#">Mark</a></p>

                    <p>This blog post shows a few different types of content that's supported and styled with Bootstrap.
                        Basic typography, images, and code are all supported.</p>
                    <hr>
                    <p>Cum sociis natoque penatibus et magnis <a href="#">dis parturient montes</a>, nascetur ridiculus
                        mus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Sed posuere
                        consectetur est at lobortis. Cras mattis consectetur purus sit amet fermentum.</p>
                    <blockquote>
                        <p>Curabitur blandit tempus porttitor. <strong>Nullam quis risus eget urna mollis</strong>
                            ornare vel eu leo. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    </blockquote>
                    <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet
                        fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                    <h2>Heading</h2>
                    <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non
                        commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Morbi leo risus,
                        porta ac consectetur ac, vestibulum at eros.</p>
                    <h3>Sub-heading</h3>
                    <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                    <pre><code>Example code block</code></pre>
                    <p>Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod.
                        Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
                    <h3>Sub-heading</h3>
                    <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean
                        lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce
                        dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit
                        amet risus.</p>
                    <ul>
                        <li>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</li>
                        <li>Donec id elit non mi porta gravida at eget metus.</li>
                        <li>Nulla vitae elit libero, a pharetra augue.</li>
                    </ul>
                    <p>Donec ullamcorper nulla non metus auctor fringilla. Nulla vitae elit libero, a pharetra augue.
                    </p>
                    <ol>
                        <li>Vestibulum id ligula porta felis euismod semper.</li>
                        <li>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</li>
                        <li>Maecenas sed diam eget risus varius blandit sit amet non magna.</li>
                    </ol>
                    <p>Cras mattis consectetur purus sit amet fermentum. Sed posuere consectetur est at lobortis.</p>
                </div><!-- /.blog-post -->

                <div class="blog-post">
                    <h2 class="blog-post-title">Another blog post</h2>
                    <p class="blog-post-meta">December 23, 2013 by <a href="#">Jacob</a></p>

                    <p>Cum sociis natoque penatibus et magnis <a href="#">dis parturient montes</a>, nascetur ridiculus
                        mus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Sed posuere
                        consectetur est at lobortis. Cras mattis consectetur purus sit amet fermentum.</p>
                    <blockquote>
                        <p>Curabitur blandit tempus porttitor. <strong>Nullam quis risus eget urna mollis</strong>
                            ornare vel eu leo. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    </blockquote>
                    <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet
                        fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                    <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non
                        commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Morbi leo risus,
                        porta ac consectetur ac, vestibulum at eros.</p>
                </div><!-- /.blog-post -->

                <div class="blog-post">
                    <h2 class="blog-post-title">New feature</h2>
                    <p class="blog-post-meta">December 14, 2013 by <a href="#">Chris</a></p>

                    <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean
                        lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce
                        dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit
                        amet risus.</p>
                    <ul>
                        <li>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</li>
                        <li>Donec id elit non mi porta gravida at eget metus.</li>
                        <li>Nulla vitae elit libero, a pharetra augue.</li>
                    </ul>
                    <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet
                        fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                    <p>Donec ullamcorper nulla non metus auctor fringilla. Nulla vitae elit libero, a pharetra augue.
                    </p>
                </div><!-- /.blog-post -->

                <nav class="blog-pagination">
                    <a class="btn btn-outline-primary" href="#">Older</a>
                    <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
                </nav>

            </div><!-- /.blog-main -->

            <aside class="col-md-4 blog-sidebar">
                <div class="p-3 mb-3 bg-light rounded">
                    <h4 class="font-italic">About</h4>
                    <p class="mb-0">Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur
                        purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                </div>

                <div class="p-3">
                    <h4 class="font-italic">Archives</h4>
                    <ol class="list-unstyled mb-0">
                        <li><a href="#">March 2014</a></li>
                        <li><a href="#">February 2014</a></li>
                        <li><a href="#">January 2014</a></li>
                        <li><a href="#">December 2013</a></li>
                        <li><a href="#">November 2013</a></li>
                        <li><a href="#">October 2013</a></li>
                        <li><a href="#">September 2013</a></li>
                        <li><a href="#">August 2013</a></li>
                        <li><a href="#">July 2013</a></li>
                        <li><a href="#">June 2013</a></li>
                        <li><a href="#">May 2013</a></li>
                        <li><a href="#">April 2013</a></li>
                    </ol>
                </div>

                <div class="p-3">
                    <h4 class="font-italic">Elsewhere</h4>
                    <ol class="list-unstyled">
                        <li><a href="#">GitHub</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Facebook</a></li>
                    </ol>
                </div>
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
</body>

</html>