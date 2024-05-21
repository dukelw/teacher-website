<?php
require_once("../config/db.class.php");
?>
<?php
class Article
{
  public $title;
  public $type;
  public $content;
  public $publish;
  public $author;
  public $aid;
  public $thumbnail;
  public $description;
  public $noti;

  public function __construct(
    $title,
    $type,
    $content,
    $publish,
    $author,
    $aid,
    $thumbnail,
    $description,
    $noti
  ) {
    $this->title = $title;
    $this->type = $type;
    $this->content = $content;
    $this->publish = $publish;
    $this->author = $author;
    $this->aid = $aid;
    $this->thumbnail = $thumbnail;
    $this->description = $description;
    $this->noti = $noti;
  }

  public function save()
  {
    $file_temp = $this->thumbnail['tmp_name'];
    $user_file = $this->thumbnail['name'];
    $timestamp = date("Y") . date("m") . date("d") . date("h") . date("i") . date("s");
    $filepath = "../upload/article-thumbnails/" . $timestamp . $user_file;
    if (move_uploaded_file($file_temp, $filepath) == false) {
      return false;
    }
    $db = new Db();
    $sql = "INSERT INTO article (title, type, content, publish, author, aid, thumbnail, description, isNoti) VALUES (
      '" . mysqli_real_escape_string($db->connect(), $this->title) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->type) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->content) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->publish) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->author) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->aid) . "',
      '" . mysqli_real_escape_string($db->connect(), $filepath) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->description) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->noti) . "'
    )";
    $result = $db->query_execute($sql);
    return $result;
  }

  public static function list_items()
  {
    $db = new Db();
    $sql = "SELECT * FROM article";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function list_articles()
  {
    $db = new Db();
    $sql = "SELECT * FROM article WHERE isNoti != 'notification'";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function list_articles_pagination($start, $limit)
  {
    $db = new Db();
    $sql = "SELECT * FROM article WHERE isNoti != 'notification' LIMIT $start, $limit";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function list_articles_by_keyword($keywork, $start, $limit)
  {
    if ($keywork != '') {
      $db = new Db();
      $sql = "SELECT * FROM article WHERE title LIKE '%$keywork%' OR description LIKE '%$keywork%' LIMIT $start, $limit";
      $result = $db->select_to_array($sql);
      return $result;
    }
  }

  public static function list_articles_pagination_type($start, $limit, $type)
  {
    $db = new Db();
    $sql = "SELECT * FROM article WHERE isNoti != 'notification' AND TYPE = $type LIMIT $start, $limit";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function list_articles_activities()
  {
    $db = new Db();
    $sql = "SELECT * FROM article WHERE isNoti != 'notification' AND TYPE = 1";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function list_articles_researchs()
  {
    $db = new Db();
    $sql = "SELECT * FROM article WHERE isNoti != 'notification' AND TYPE = 2";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function list_articles_news()
  {
    $db = new Db();
    $sql = "SELECT * FROM article WHERE isNoti != 'notification' AND TYPE = 3 LIMIT 3";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function list_notifications()
  {
    $db = new Db();
    $sql = "SELECT * FROM article WHERE isNoti = 'notification'";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function list_notifications_pagination($start, $limit)
  {
    $db = new Db();
    $sql = "SELECT * FROM article WHERE isNoti = 'notification' LIMIT $start, $limit";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function list_notifications_pagination_type($start, $limit, $type)
  {
    $db = new Db();
    $sql = "SELECT * FROM article WHERE isNoti = 'notification' AND TYPE = $type LIMIT $start, $limit";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function list_articles_by_type($type)
  {
    $db = new Db();
    $sql = "SELECT * FROM article WHERE type='$type' AND isNoti != 'notification'";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function list_notifications_by_type($type)
  {
    $db = new Db();
    $sql = "SELECT * FROM article WHERE type='$type' AND isNoti = 'notification'";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function list_articles_relate($type, $id, $isNoti)
  {
    $db = new Db();
    $sql = "SELECT * FROM article WHERE type='$type' AND ID != '$id' AND isNoti = '$isNoti'";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function get_article($id)
  {
    $db = new Db();
    $sql = "SELECT * FROM article WHERE ID = '$id'";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public function update($id)
  {
    $db = new Db();

    $existing_article = $this->get_article($id);

    // Initialize $filepath
    $filepath = '';

    // Check if a new file is uploaded
    if (!empty($this->thumbnail['tmp_name'])) {
      // Generate a unique file name
      $unique_filename = uniqid() . '_' . $this->thumbnail['name'];
      $filepath = "../upload/article-thumbnails/" . $unique_filename;

      // Move the uploaded file to the destination directory
      if (!move_uploaded_file($this->thumbnail['tmp_name'], $filepath)) {
        // Handle file upload error (e.g., log error or show user message)
        return false;
      }
    } else {
      // If no new file uploaded, use the existing file path
      $filepath = $existing_article[0]['THUMBNAIL'];
    }
    $sql = "UPDATE article SET 
            title = '" . mysqli_real_escape_string($db->connect(), $this->title) . "',
            type = '" . mysqli_real_escape_string($db->connect(), $this->type) . "',
            content = '" . mysqli_real_escape_string($db->connect(), $this->content) . "',
            description = '" . mysqli_real_escape_string($db->connect(), $this->description) . "',
            isNoti = '" . mysqli_real_escape_string($db->connect(), $this->noti) . "',
            thumbnail = '" . mysqli_real_escape_string($db->connect(), $filepath) . "'
            WHERE ID = '" . mysqli_real_escape_string($db->connect(), $id) . "'";

    $result = $db->query_execute($sql);
    return $result;
  }

  public static function delete($id)
  {
    $db = new Db();
    $sql = "DELETE FROM article
            WHERE ID = '" . mysqli_real_escape_string($db->connect(), $id) . "'";
    $result = $db->query_execute($sql);
    return $result;
  }

  public static function to_string($article)
  {
    echo "TITLE: " . $article->title;
    echo "TYPE: " . $article->type;
    echo "CONTENT: " . $article->content;
    echo "PUBLISH: " . $article->publish;
    echo "AUTHOR: " . $article->author;
    echo "AID: " . $article->aid;
    echo "THUMBNAIL: " . $article->thumbnail;
    echo "DESCRIPTION: " . $article->description;
    echo "NOTI: " . $article->noti;
  }
}
