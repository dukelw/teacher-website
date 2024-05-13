<?php
include_once("./entities/subject.class.php");
include_once("./entities/article.class.php");

if (isset($_GET['edit-article'])) {
  $editingArticle = Article::get_article($_GET['edit-article']);
}

if (isset($_POST["btnsubmit"])) {
  $originalArticle = Article::get_article($_POST['edit-article']);
  $title = $_POST["txtName"];
  $type = intval($_POST["txtCategory"]);
  $content = $_POST["txtContent"];
  $description = $_POST["txtDescription"];
  $noti = $_POST["txtType"];
  $file = $_FILES["txtThumbnail"];

  $thumbnail = (!empty($file['tmp_name'])) ? $file : $editingArticle[0]["THUMBNAIL"];

  if ($title != $originalArticle[0]['TITLE']) {
    $originalArticle[0]['TITLE'] = $title;
  }

  if ($type != $originalArticle[0]['TYPE']) {
    $originalArticle[0]['TYPE'] = $type;
  }

  if ($content != $originalArticle[0]['CONTENT'] && $content != "") {
    $originalArticle[0]['CONTENT'] = $content;
  }

  if ($description != $originalArticle[0]['DESCRIPTION']) {
    $originalArticle[0]['DESCRIPTION'] = $description;
  }

  if ($noti != $originalArticle[0]['isNoti']) {
    $originalArticle[0]['isNoti'] = $noti;
  }

  $newArticle = new Article(
    $originalArticle[0]['TITLE'],
    $originalArticle[0]['TYPE'],
    $originalArticle[0]['CONTENT'],
    $originalArticle[0]['PUBLISH'],
    $originalArticle[0]['AUTHOR'],
    $originalArticle[0]['AID'],
    $thumbnail,
    $originalArticle[0]['DESCRIPTION'],
    $originalArticle[0]['isNoti']
  );

  $result = $newArticle->update($_POST['edit-article']);

  if ($result) {
    header("Location: dashboard.php");
  } else {
    echo "Cập nhật thất bại";
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
  <link rel="stylesheet" href="./css/add_article.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="./assets/js/jquery-slim.min.js"></script>
  <script src="./assets/js/holder.min.js"></script>
  <script src="./assets/js/popper.min.js"></script>
  <link rel="stylesheet" href="./css/dashboard.css">
  <link rel="stylesheet" href="./css/admin_article.css">

  <title>AdminHub</title>
</head>

<body>
  <!-- SIDEBAR -->
  <section id="sidebar">
    <a href="dashboard.php" class="brand">
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
        <a class="navigate" href="#">
          <i class='bx bx bxs-calendar-check'></i>
          <span class="text">Cập nhật bài báo</span>
        </a>
      </li>
    </ul>
  </section>
  <!-- SIDEBAR -->

  <!-- CONTENT -->
  <section id="content">
    <!-- NAVBAR -->
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
    <!-- NAVBAR -->

    <!-- MAIN -->
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
              <a class="active" class="navigate" href="#">Cập nhật bài báo</a>
            </li>
          </ul>
        </div>
        <a class="navigate" href="#" class="btn-download">
          <i class='bx bxs-cloud-download'></i>
          <span class="text">Download PDF</span>
        </a>
      </div>
      <div class="container mt-4">
        <form action="" method="post">
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
            })
            .then(newEditor => {
              editor = newEditor;
              editor.setData('<?= $editingArticle[0]["CONTENT"] ?>');
              editor.model.document.on('change:data', () => {
                const content = document.getElementById("article_content");
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
          <form enctype="multipart/form-data" class="row g-3 needs-validation" method="post" action="edit_article.php" novalidate>
            <div class="col-md-6">
              <label for="name" class="form-label">Tiêu đề</label>
              <input type="text" name="txtName" class="form-control" id="name" required value="<?php if (isset($_GET['edit-article'])) {
                                                                                                  echo $editingArticle[0]["TITLE"];
                                                                                                } ?>">
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
                  if ((isset($_GET['edit-article']))) {
                    $selected = ($editingArticle[0]["TYPE"] == $subject['ID']) ? 'selected' : '';
                    echo "<option value=" . $subject['ID'] . " " . $selected . ">" . $subject["NAME"] . "</option>";
                  } else {
                    echo "<option value=" . $subject['ID'] . ">" . $subject["NAME"] . "</option>";
                  }
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
                <?php
                if ((isset($_GET['edit-article']))) {
                  if ($editingArticle[0]["isNoti"] == "article") {
                    echo "<option value='article' selected>Bài báo</option>
                  <option value='notification'>Thông báo</option>";
                  } else {
                    echo "<option value='article'>Bài báo</option>
                <option value='notification' selected>Thông báo</option>";
                  }
                } else {
                  echo "<option value='article'>Bài báo</option>
              <option value='notification'>Thông báo</option>";
                }
                ?>
              </select>
              <div class="invalid-feedback">
                Please select a valid state.
              </div>
            </div>
            <div class="col-md-6">
              <span class="">Thumbnail</span>
              <div class="d-flex justify-content-start" style="margin-top:8px;">
                <?php if (isset($_GET['edit-article']) && !empty($editingArticle[0]["THUMBNAIL"])) { ?>
                  <img class="col-md-3 thumbnail-img" src="<?= $editingArticle[0]["THUMBNAIL"] ?>" alt="Current Thumbnail" style="width: 100px; height: 100px; object-fit: cover; margin-top: 20px; margin-left: 12px;">
                  <div style="margin-left: 10px; padding-right:30px;" class="col-md-9">
                    <p><?php echo $editingArticle[0]["THUMBNAIL"]; ?></p>
                    <input type="file" name="txtThumbnail" class="form-control" id="file" accept="image/*">
                  </div>
                <?php } ?>
              </div>
              <div class="invalid-feedback">
                Hãy chọn ảnh mới
              </div>
            </div>
            <div class="col-md-12">
              <label for="description" class="form-label">Mô tả</label>
              <textarea type="text" name="txtDescription" class="form-control" id="description" re quired><?= isset($_GET['edit-article']) ? $editingArticle[0]["DESCRIPTION"] : "" ?></textarea>
              <div class="invalid-feedback">
                Please describe the product.
              </div>
            </div>
            <input hidden id="article_content" type="text" name="txtContent" class="form-control">
            <input hidden type=" text" name="edit-article" value="<?php if (isset($_GET["edit-article"])) {
                                                                    echo $_GET["edit-article"];
                                                                  } ?>">
            <div class="col-12 mb-4">
              <button class="btn btn-primary" name="btnsubmit" type="submit">Cập nhật bài viết</button>
            </div>
          </form>
        </div>
      </div>
    </main>
  </section>
  <script src="./js/dashboard.js"></script>
  <script>
    document.getElementById('file').addEventListener('change', function(event) {
      const file = event.target.files[0];
      const reader = new FileReader();

      reader.onload = function(e) {
        document.querySelector('.thumbnail-img').setAttribute('src', e.target.result);
      };

      reader.readAsDataURL(file);
    });
  </script>
</body>

</html>