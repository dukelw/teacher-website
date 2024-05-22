<?php
include_once ("../entities/subject.class.php");
include_once ("../entities/article.class.php");
if (isset($_POST["btnsubmit"])) {
  $title = $_POST["txtName"];
  $type = intval($_POST["txtCategory"]);
  $content = $_POST["txtContent"];
  $description = $_POST["txtDescription"];
  $picture = $_FILES["txtThumbnail"];
  $noti = $_POST["txtType"];

  $publish = date("Y-m-d");
  $author = "Lê Phan Thế Vĩ";
  $aid = intval("1");
  $newArticle = new Article($title, $type, $content, $publish, $author, $aid, $picture, $description, $noti);
  $result = $newArticle->save();
  if ($result) {
    header("Location: dashboard.php");
  } else {
    echo "Thêm thất bại";
  }
}

if (isset($_POST["btncategorysubmit"])) {
  $subjectName = $_POST["txtCategoryName"];
  $newSubject = new Subject($subjectName);
  $result = $newSubject->save();
  if ($result) {
    header("Location: add_article.php");
  } else {
    echo "Thêm thất bại";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <!-- My CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous">
  <script src="../assets/js/jquery-slim.min.js"></script>
  <script src="../assets/js/holder.min.js"></script>
  <script src="../assets/js/popper.min.js"></script>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/dashboard.css">
  <title>Thêm bài viết</title>
</head>

<body>
  <!-- SIDEBAR -->
  <section id="sidebar">
    <a href="#" class="brand">
      <i class='bx bxs-smile'></i>
      <span class="text">Dashboard</span>
    </a>
    <ul class="side-menu top">
      <li>
        <a href="dashboard.php">
          <i class='bx bxs-dashboard'></i>
          <span class="text">Trang chủ</span>
        </a>
      </li>
      <li class="active">
        <a class="navigate" href="add_article.php">
          <i class='bx bx bxs-calendar-check'></i>
          <span class="text">Thêm bài viết</span>
        </a>
      </li>
      <li>
        <a class="navigate" href="add_document.php">
          <i class='bx bx bxs-calendar-check'></i>
          <span class="text">Thêm tài liệu</span>
        </a>
      </li>
      <li>
        <a class="navigate" href="add_slide.php">
          <i class='bx bx bxs-calendar-check'></i>
          <span class="text">Thêm slide</span>
        </a>
      </li>
    </ul>
    <ul class="side-menu">
      <li>
        <a href="main.php">
          <i class='bx bx-user-circle'></i>
          <span class="text">Về trang người dùng</span>
        </a>
      </li>
      <li>
        <a href="signin.php" class="logout">
          <i class='bx bxs-log-out-circle'></i>
          <span class="text">Đăng xuất</span>
        </a>
      </li>
    </ul>
  </section>
  <section id="content">
    <nav>
      <i class='bx bx-menu'></i>
      <a class="navigate" href="#" class="nav-link">Categories</a>
      <form action="#">
        <div class="form-input">
          <input type="search" placeholder="Search...">
          <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
        </div>
      </form>
      <input type="checkbox" id="switch-mode" hidden>
      <label for="switch-mode" class="switch-mode"></label>
      <a class="navigate" href="#" class="notification">
        <i class='bx bxs-bell'></i>
        <span class="num">8</span>
      </a>
      <a class="navigate" href="update_info.php" class="profile">
        <?php
        if (isset($user[0]['AVATAR']) && !empty($user[0]['AVATAR'])) {
          echo '<img style=\'width: 36px;height: 36px;object-fit: cover;border-radius: 50%;\' src="' . $user[0]['AVATAR'] . '">';
        } else {
          echo '<img style=\'width: 36px;height: 36px;object-fit: cover;border-radius: 50%;\' src="https://i.pinimg.com/originals/ac/0b/3b/ac0b3b4f2f7c1a89e045b2f186d6f7e1.jpg">';
        }
        ?>
      </a>
    </nav>
    <main id="main">
      <div class="head-title">
        <div class="left">
          <h1>Dashboard</h1>
          <ul class="breadcrumb">
            <li>
              <a class="navigate" href="dashboard.php">Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
              <a class="active" class="navigate" href="#">Thêm bài viết</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="mt-4">
        <form style="padding: 0;" action="#" method="post" class="col">
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
              const content = document.querySelector(".content");
              content.value = editor.getData();
            });
          })
            .catch(error => {
              console.error(error);
            });
        </script>
        <div style="padding: 0;" class="container mt-4">
          <form enctype="multipart/form-data" class="row g-3 needs-validation" method="post"
            action="add_article.php" novalidate>
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
              <input type="file" accept=".PNG, .GIF, .JPG" name="txtThumbnail" class="form-control"
                id="thumbnail" required>
              <div class="invalid-feedback">
                Please provide a valid city.
              </div>
            </div>
            <div class="col-md-12">
              <label for="description" class="form-label">Mô tả</label>
              <textarea type="text" name="txtDescription" class="form-control" id="description"
                required> </textarea>
              <div class="invalid-feedback">
                Please describe the product.
              </div>
            </div>
            <div class="col-md-12">
              <input hidden class="content" type="text" name="txtContent" class="form-control"
                required>
            </div>
            <div class="col-12">
              <button class="btn btn-primary" name="btnsubmit" type="submit">Tạo bài viết</button>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#categoryModal">
                Thêm danh mục
              </button>
            </div>
          </form>
        </div>
      </div>
    </main>
  </section>

</body>
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">
          Thêm thể loại
        </h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3 needs-validation" method="post" action="add_article.php">
          <div class="col-md-12">
            <label for="category-name" class="form-label">Tên danh mục</label>
            <input type="text" name="txtCategoryName" class="form-control" id="category-name"
              required>
            <div class="invalid-feedback">
              Vui lòng nhập tên danh mục
            </div>
          </div>
          <div class="col-12">
            <button class="btn btn-primary" name="btncategorysubmit" type="submit">Thêm danh
              mục</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

</html>

<style>
  a {
    text-decoration: none !important;
  }

  ul {
    padding-left: 0 !important;
  }

  label {
    color: var(--dark);
  }

  .breadcrumb {
    background-color: unset !important;
  }
</style>

<script src='../js/dashboard.js'></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
  integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
  integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
  crossorigin="anonymous"></script>