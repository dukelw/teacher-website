<?php
require_once("../config/db.class.php");
?>
<?php
class Notification
{
  public $article;
  public $content;
  public $sendTo;
  public $articleID;
  public $sendFrom;
  public $createdAt;
  public $isRead;

  public function __construct(
    $article,
    $content,
    $sendTo,
    $articleID,
    $sendFrom,
  ) {
    $this->article = $article;
    $this->content = $content;
    $this->sendTo = $sendTo;
    $this->articleID = $articleID;
    $this->sendFrom = $sendFrom;
  }

  public function save()
  {
    $db = new Db();
    $createdAt = date('Y-m-d H:i:s');
    $sql = "INSERT INTO notification (article, content, sendto, articleID, sendFrom, createdAt) VALUES (
        '" . mysqli_real_escape_string($db->connect(), $this->article) . "',
        '" . mysqli_real_escape_string($db->connect(), $this->content) . "',
        '" . mysqli_real_escape_string($db->connect(), $this->sendTo) . "',
        '" . mysqli_real_escape_string($db->connect(), $this->articleID) . "',
        '" . mysqli_real_escape_string($db->connect(), $this->sendFrom) . "',
        '" . mysqli_real_escape_string($db->connect(), $createdAt) . "'
    )";
    $result = $db->query_execute($sql);
    return $result;
  }

  public static function list_notification_of_user($id)
  {
    $db = new Db();
    $sql = "SELECT * FROM notification WHERE sendTo = '$id'";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function checked($id)
  {
    $db = new Db();
    $sql = "UPDATE notification SET isRead = 1 WHERE ID = '$id'";
    $result = $db->query_execute($sql);
    return $result;
  }
}
?>