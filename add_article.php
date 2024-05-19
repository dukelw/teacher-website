<?php
include_once("./entities/subject.class.php");
include_once("./entities/article.class.php");
include_once("./dashboardheader.php");
if (isset($_POST["btnsubmit"])) {
  $title = $_POST["txtName"];
  $type = intval($_POST["txtCategory"]);
  $content = $_POST["txtContent"];
  $description = $_POST["txtDescription"];
  $picture = $_FILES["txtThumbnail"];
  $noti = $_POST["txtType"];

  // Set CONSTANT values for test
  $publish = date("Y-m-d");
  $author = "Lê Phan Thế Vĩ";
  $aid = intval("1");
  $newArticle = new Article($title, $type, $content, $publish, $author, $aid, $picture, $description, $noti);
  $result = $newArticle->save();
  if ($result) {
    header("Location: list_article.php");
  } else {
    echo "Thêm thất bại";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Thêm bài báo</title>
  <link rel="stylesheet" href="./css/add_article.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="./assets/js/jquery-slim.min.js"></script>
  <script src="./assets/js/holder.min.js"></script>
  <script src="./assets/js/popper.min.js"></script>
  <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="./dashboard.css" rel="stylesheet">
</head>

<body>
  <div class="main container" style="margin-top: 100px;">
    <h3 class="pb-3 font-italic border-bottom">
      Thêm bài viết
    </h3>
    <form action="#" method="post">
      <div id="editor"></div>
    </form>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/super-build/ckeditor.js"></script>
    <script>
      let editor;
      CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
          toolbar: {
            items: [
              'exportPDF', 'exportWord', '|',
              'findAndReplace', 'selectAll', '|',
              'heading', '|',
              'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
              'bulletedList', 'numberedList', 'todoList', '|',
              'outdent', 'indent', '|',
              'undo', 'redo',
              '-',
              'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
              'alignment', '|',
              'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
              'specialCharacters', 'horizontalLine', 'pageBreak', '|',
              'textPartLanguage', '|',
              'sourceEditing'
            ],
            shouldNotGroupWhenFull: true
          },
          list: {
            properties: {
              styles: true,
              startIndex: true,
              reversed: true
            }
          },
          heading: {
            options: [{
                model: 'paragraph',
                title: 'Paragraph',
                class: 'ck-heading_paragraph'
              },
              {
                model: 'heading1',
                view: 'h1',
                title: 'Heading 1',
                class: 'ck-heading_heading1'
              },
              {
                model: 'heading2',
                view: 'h2',
                title: 'Heading 2',
                class: 'ck-heading_heading2'
              },
              {
                model: 'heading3',
                view: 'h3',
                title: 'Heading 3',
                class: 'ck-heading_heading3'
              },
              {
                model: 'heading4',
                view: 'h4',
                title: 'Heading 4',
                class: 'ck-heading_heading4'
              },
              {
                model: 'heading5',
                view: 'h5',
                title: 'Heading 5',
                class: 'ck-heading_heading5'
              },
              {
                model: 'heading6',
                view: 'h6',
                title: 'Heading 6',
                class: 'ck-heading_heading6'
              }
            ]
          },
          placeholder: 'Viết bài báo tại đây',
          fontFamily: {
            options: [
              'default',
              'Arial, Helvetica, sans-serif',
              'Courier New, Courier, monospace',
              'Georgia, serif',
              'Lucida Sans Unicode, Lucida Grande, sans-serif',
              'Tahoma, Geneva, sans-serif',
              'Times New Roman, Times, serif',
              'Trebuchet MS, Helvetica, sans-serif',
              'Verdana, Geneva, sans-serif'
            ],
            supportAllValues: true
          },
          fontSize: {
            options: [10, 12, 14, 'default', 18, 20, 22],
            supportAllValues: true
          },
          htmlSupport: {
            allow: [{
              name: /.*/,
              attributes: true,
              classes: true,
              styles: true
            }]
          },
          htmlEmbed: {
            showPreviews: true
          },
          link: {
            decorators: {
              addTargetToExternalLinks: true,
              defaultProtocol: 'https://',
              toggleDownloadable: {
                mode: 'manual',
                label: 'Downloadable',
                attributes: {
                  download: 'file'
                }
              }
            }
          },
          mention: {
            feeds: [{
              marker: '@',
              feed: [
                '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                '@sugar', '@sweet', '@topping', '@wafer'
              ],
              minimumCharacters: 1
            }]
          },
          removePlugins: [
            'AIAssistant',
            'CKBox',
            'CKFinder',
            'EasyImage',
            'MultiLevelList',
            'RealTimeCollaborativeComments',
            'RealTimeCollaborativeTrackChanges',
            'RealTimeCollaborativeRevisionHistory',
            'PresenceList',
            'Comments',
            'TrackChanges',
            'TrackChangesData',
            'RevisionHistory',
            'Pagination',
            'WProofreader',
            'MathType',
            'SlashCommand',
            'Template',
            'DocumentOutline',
            'FormatPainter',
            'TableOfContents',
            'PasteFromOfficeEnhanced',
            'CaseChange'
          ]
        }).then(newEditor => {
          editor = newEditor;
          editor.model.document.on('change:data', () => {
            const main = document.getElementById("main");
            const content = document.getElementById("content");
            main.innerHTML = editor.getData();
            content.value = editor.getData();
          });
        })
        .catch(error => {
          console.error(error);
        });
    </script>
    <script>
      let submitBtn = document.getElementById("submit");
      const main = document.getElementById("main")
    </script>
    <div class="container mt-4">
      <form enctype="multipart/form-data" class="row g-3 needs-validation" method="post" action="add_article.php" novalidate>
        <div class="col-md-6">
          <label for="name" class="form-label">Tiêu đề</label>
          <input type="text" name="txtName" class="form-control" id="name" required>
          <div class="valid-feedback">
            Looks good!
          </div>
        </div>
        <div class="col-md-6">
          <label for="category" class="form-label">Danh mục</label>
          <select class="form-select" name="txtCategory" id="category" required>
            <option selected disabled value="">Choose...</option>
            <?php
            $subjects = Subject::list_subject();
            foreach ($subjects as $subject) {
              echo "<option value=" . $subject['ID'] . ">" . $subject["NAME"] . "</option>";
            }
            ?>
          </select>
          <div class="invalid-feedback">
            Please select a valid state.
          </div>
        </div>
        <div class="col-md-6">
          <label for="type" class="form-label">Thể loại</label>
          <select class="form-select" name="txtType" id="type" required>
            <option selected disabled value="">--Chọn loại bài viết--</option>
            <option value="article">Bài báo</option>
            <option value="notification">Thông báo</option>
          </select>
          <div class="invalid-feedback">
            Please select a valid state.
          </div>
        </div>
        <div class="col-md-6">
          <label for="thumbnail" class="form-label">Hình nền</label>
          <input type="file" accept=".PNG, .GIF, .JPG" name="txtThumbnail" class="form-control" id="thumbnail" required>
          <div class="invalid-feedback">
            Please provide a valid city.
          </div>
        </div>
        <div class="col-md-12">
          <label for="description" class="form-label">Mô tả</label>
          <textarea type="text" name="txtDescription" class="form-control" id="description" required> </textarea>
          <div class="invalid-feedback">
            Please describe the product.
          </div>
        </div>
        <div class="col-md-12">
          <input style="display: none;" type="text" name="txtContent" class="form-control" id="content" required>
        </div>
        <div class="col-12">
          <button class="btn btn-primary" name="btnsubmit" type="submit">Tạo bài viết</button>
        </div>
      </form>
    </div>
    <?= "<h1 class='spacer'>Bài viết hiện tại</h1>" ?>
    <div id="main"></div>
  </div>
</body>

</html>

<style>
  .main {
    width: 82vw;
    background-color: #fff5;
    backdrop-filter: blur(7px);
    box-shadow: 0 0.4rem 0.8rem #0005;
    border-radius: 0.8rem;
    padding: 20px;
  }
</style>