<?php
require_once("./config/db.class.php");
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

  public function __construct(
    $title,
    $type,
    $content,
    $publish,
    $author,
    $aid,
    $thumbnail,
    $description
  ) {
    $this->title = $title;
    $this->type = $type;
    $this->content = $content;
    $this->publish = $publish;
    $this->author = $author;
    $this->aid = $aid;
    $this->thumbnail = $thumbnail;
    $this->description = $description;
  }

  public function save()
  {
    $file_temp = $this->thumbnail['tmp_name'];
    $user_file = $this->thumbnail['name'];
    $timestamp = date("Y") . date("m") . date("d") . date("h") . date("i") . date("s");
    $filepath = "./upload/" . $timestamp . $user_file;
    if (move_uploaded_file($file_temp, $filepath) == false) {
      return false;
    }
    $db = new Db();
    $sql = "INSERT INTO article (title, type, content, publish, author, aid, thumbnail, description) VALUES (
      '" . mysqli_real_escape_string($db->connect(), $this->title) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->type) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->content) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->publish) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->author) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->aid) . "',
      '" . mysqli_real_escape_string($db->connect(), $filepath) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->description) . "'
    )";
    $result = $db->query_execute($sql);
    return $result;
  }
}
