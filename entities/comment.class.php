<?php
require_once("./config/db.class.php");
?>
<?php
class Comment
{
  public $ID;
  public $content;
  public $parentID;
  public $userID;
  public $createAt;
  public $like;
  public $dislike;

  public function __construct(
    $content,
    $parentID,
    $userID,
    $createAt,
    $like,
    $dislike
  ) {
    $this->content = $content;
    $this->parentID = $parentID;
    $this->userID = $userID;
    $this->$createAt = $createAt;
    $this->$like = $like;
    $this->$dislike = $dislike;
  }

  public function save()
  {
    $db = new Db();
    $sql = "INSERT INTO comment (content, parentID, userID, createAt, likeNum, dislikeNum) VALUES (
      '" . mysqli_real_escape_string($db->connect(), $this->content) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->parentID) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->userID) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->createAt) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->like) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->dislike) . "',
    )";
    $result = $db->query_execute($sql);
    return $result;
  }

  public static function get_comment($ID)
  {
    $db = new Db();
    $sql = "SELECT * FROM comment WHERE ID = '$ID'";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function list_comments()
  {
    $db = new Db();
    $sql = "SELECT * FROM teacher";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function update_information($oldEmail, $avatar, $name, $newEmail, $address, $phone, $gender, $birthday)
  {
    if ($avatar) {
      $file_temp = $avatar['tmp_name'];
      $user_file = $avatar['name'];
      $timestamp = date("Y") . date("m") . date("d") . date("h") . date("i") . date("s");
      $filepath = "./upload/" . $timestamp . $user_file;
      move_uploaded_file($file_temp, $filepath);
    }

    $db = new Db();
    $sql = "UPDATE teacher SET mail = '$newEmail', avatar = '$filepath', name = '$name', address = '$address', phone = '$phone', gender = $gender, birthday = '$birthday' WHERE mail = '$oldEmail'";
    if (!$avatar) {
      $sql = "UPDATE teacher SET mail = '$newEmail', name = '$name', address = '$address', phone = '$phone', gender = $gender, birthday = '$birthday' WHERE mail = '$oldEmail'";
    }
    $result = $db->query_execute($sql);
    if ($result) {
      return true;
    } else {
      return false;
    }
  }
}
