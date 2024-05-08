<?php
include_once("./entities/document.class.php");
include_once("./entities/doccategory.class.php");
include_once("./entities/major.class.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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
</head>

<body>

  <div class="container">
    <?php include_once("./header.php"); ?>
  </div>

  <main role="main" class="container">
    <div class="row">
      <div class="col-md-12 blog-main">
        <h3 class='pb-3 font-italic border-bottom'>Danh sách Tài liệu</h3>
        <?php
        // Assuming Major and Document classes with appropriate methods (replace with your actual implementation)
        $majors = Major::list_major();

        foreach ($majors as $major) {
          echo "<div class='row'>";
          echo "<div class='col-md-12'>";
          echo "<h3 class='pb-3 font-italic border-bottom'>" . $major['name'] . "</h3>";

          $documents = Document::list_document_by_major($major['ID']);

          if (!empty($documents)) { // Check if there are documents for this major
            echo "<div class='document-list'>";
            foreach ($documents as $document) {
              $image = './upload/export.png';
              $docfile = $document["docfile"];

              if (strpos(strtolower($docfile), '.pdf') !== false) {
                $image = './upload/pdf.png';
              } else if (strpos(strtolower($docfile), '.xlsx') !== false || strpos(strtolower($docfile), '.xls') !== false) {
                $image = './upload/excel.png';
              } else if (strpos(strtolower($docfile), '.pptx') !== false || strpos(strtolower($docfile), '.ppt') !== false) {
                $image = './upload/powerpoint.png';
              } else if (strpos(strtolower($docfile), '.docx') !== false || strpos(strtolower($docfile), '.doc') !== false) {
                $image = './upload/word.png';
              } else if (strpos(strtolower($docfile), '.sql') !== false) {
                $image = './upload/sql.png';
              }
              echo "<div class='document d-flex align-items-center'>";
              echo "<a href='document_detail.php?id=" . $document["ID"] . "'>";
              echo "<img class='type-image' src='" . $image . "" . "' alt='" . $document["TITLE"] . "'>";
              echo "</a>";
              echo "<div style='width: 100%;' class='d-flex align-items-center justify-content-between'>";
              echo "<div class='d-flex flex-column'>";
              echo "<div class='d-flex'>";
              echo "<a href='document_detail.php?id=" . $document["ID"] . "' class='document-title'>" . $document["TITLE"] . "</a>";
              echo "<a href='' style='padding: 6px 12px; background-color: red; color: white; border-radius: 12px; margin-left: 6px;'>" . Major::list_major_by_id($document['subject'])[0]['name'] . "</a>";
              echo "</div>";
              echo "<a href='document_detail.php?id=" . $document["ID"] . "' class='document-description'>" . $document["DESCRIPTION"] . "</a>";
              echo "</div>";
              echo "<div class='d-flex flex-column align-items-end'>";
              echo "<p class='document-category'>Thể loại: " . $document["CATENAME"] . "</p>";
              echo "<a class='document-link' href='" . $document["docfile"] . "' target='_blank'>Tải về</a>";
              echo "</div>";
              echo "</div>";
              echo "</div>";
            }
            echo "</div>";
          } else {
            echo "<p>Không có tài liệu nào cho chuyên ngành này.</p>"; // Inform user if no documents
          }
          echo "</div>";
          echo "</div>";
        }
        ?>
      </div>
      <aside class="col-md-3 blog-sidebar">
      </aside>
    </div>
  </main>

  <?php include_once("./footer.php") ?>
</body>

</html>