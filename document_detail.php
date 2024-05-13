<?php
include_once("./entities/document.class.php");

if (!isset($_GET["id"])) {
  header("Location: notfound.php");
  exit;
}

$id = $_GET["id"];

$document = Document::get_document($id)[0];

if (!$document) {
  header("Location: notfound.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document Detail</title>
  <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/blog/">
  <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
  <link rel="icon" href="./assets/images/logo.svg" type="image/x-icon" />
  <link href="./assets/css/blog.css" rel="stylesheet">
  <link href="./css/document.css" rel="stylesheet">
  <link rel="stylesheet" href="./assets/icon/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="./css/news.css">
  <script src="./assets/js/jquery-slim.min.js"></script>
  <script src="./assets/js/holder.min.js"></script>
  <script src="./assets/js/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.8.335/pdf.min.js"></script>
  <link rel="stylesheet" href="./css/document_detail.css">
</head>

<body>
  <div class="container">
    <?php include_once("./header.php"); ?>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-12 document-detail">
          <?php if (isset($document)) : ?>
            <div class="document-info col-md-3">
              <h5 class="">
                <?php echo isset($document["TITLE"]) ? $document["TITLE"] : "Không có tiêu đề"; ?>
              </h5>
              <p>Mô tả:
                <?php echo isset($document["DESCRIPTION"]) ? $document["DESCRIPTION"] : "Không có mô tả"; ?>
              </p>
              <p>Thể loại:
                <?php echo isset($document["CATENAME"]) ? $document["CATENAME"] : "Không có thể loại"; ?>
              </p>
            </div>

            <div class="document-file col-md-9">
              <?php if (isset($document)) : ?>
                <?php
                $file_path = $document["docfile"];
                $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
                ?>

                <?php if ($file_extension === 'pdf') : ?>
                  <canvas id="pdfViewer" style="border: 1px solid black;"></canvas>
                  <button id="prevPage">Trang trước</button>
                  <button id="nextPage">Trang kế tiếp</button>
                  <a href="<?php echo $file_path; ?>" download>
                    <button id="downloadPdfBtn">Tải tài liệu</button>
                  </a>
                  <script>
                    var url = "<?php echo $file_path; ?>";
                    var pdfjsLib = window['pdfjs-dist/build/pdf'];
                    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.8.335/pdf.worker.min.js';

                    var loadingTask = pdfjsLib.getDocument(url);
                    loadingTask.promise.then(function(pdf) {
                      var canvas = document.getElementById('pdfViewer');
                      var ctx = canvas.getContext('2d');
                      var currentPage = 1;

                      function renderPage(num) {
                        pdf.getPage(num).then(function(page) {
                          var viewport = page.getViewport({
                            scale: 1.25
                          });
                          canvas.height = viewport.height;
                          canvas.width = viewport.width;
                          var renderContext = {
                            canvasContext: ctx,
                            viewport: viewport
                          };
                          page.render(renderContext);
                        });
                      }

                      renderPage(currentPage);

                      document.getElementById('prevPage').addEventListener('click', function() {
                        if (currentPage > 1) {
                          currentPage--;
                          renderPage(currentPage);
                        }
                      });

                      document.getElementById('nextPage').addEventListener('click', function() {
                        if (currentPage < pdf.numPages) {
                          currentPage++;
                          renderPage(currentPage);
                        }
                      });
                    });
                  </script>
                <?php else : ?>
                  <embed src="<?php echo $file_path; ?>" type="application/<?php echo $file_extension; ?>" width="100%" height="600px" />
                  <a href="<?php echo $file_path; ?>" download>
                    <button>Tải tài liệu</button>
                  </a>
                <?php endif; ?>

              <?php else : ?>
                <p>Không tìm thấy tài liệu.</p>
              <?php endif; ?>
            </div>

          <?php else : ?>
            <p>Không tìm thấy tài liệu.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <?php include_once("./footer.php") ?>
</body>

</html>