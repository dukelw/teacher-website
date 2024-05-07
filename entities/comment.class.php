<?php
require_once("./config/db.class.php");
?>
<?php
class Comment
{
  public $ID;
  public $articleID;
  public $content;
  public $parentID;
  public $userID;
  public $createAt;
  public $like;
  public $dislike;

  public function __construct(
    $content,
    $articleID,
    $parentID,
    $userID,
    $createAt,
    $like,
    $dislike,
  ) {
    $this->articleID = $articleID;
    $this->content = $content;
    $this->parentID = $parentID;
    $this->userID = $userID;
    $this->createAt = $createAt;
    $this->like = $like;
    $this->dislike = $dislike;
  }

  public static function createComment($title_id, $user_id, $user_name, $user_thumb, $parent_name, $content, $parentID)
  {
    $db = new Db();
    // Set timezone to GMT +7
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $publish = date("Y-m-d H:i:s");

    // Create a new Comment object
    $comment = new Comment(
      $content,
      $title_id,
      $parentID,
      $user_id,
      $publish,
      0, // initial like count
      0  // initial dislike count
    );

    $sql = "INSERT INTO comment (content, titleID, parentID, userID, createAt, likeNum, dislikeNum) VALUES (
        '" . mysqli_real_escape_string($db->connect(), $comment->content) . "',
        '" . mysqli_real_escape_string($db->connect(), $comment->articleID) . "',
        '" . mysqli_real_escape_string($db->connect(), $comment->parentID) . "',
        '" . mysqli_real_escape_string($db->connect(), $comment->userID) . "',
        '" . mysqli_real_escape_string($db->connect(), $comment->createAt) . "',
        '" . mysqli_real_escape_string($db->connect(), $comment->like) . "',
        '" . mysqli_real_escape_string($db->connect(), $comment->dislike) . "'
    )";
    $result = $db->query_execute($sql);

    return $result;
  }


  public static function deleteComment($comment_id)
  {
    $db = new Db();

    $sql = "DELETE FROM comment WHERE ID = '{$comment_id}' OR parentID = '{$comment_id}'";
    $result = $db->query_execute($sql);

    return $result;
  }


  public static function get_all_parent_comment()
  {
    $db = new Db();

    $sql = "SELECT * FROM comment WHERE parentID = '-1'";
    $result = $db->select_to_array($sql);

    return $result;
  }

  public static function get_comment_by_parentID($product_id, $parentID, $limit = 10, $offset = 0)
  {
    $db = new Db();
    $query = "SELECT * FROM comment WHERE titleID = '$product_id' AND parentID = '$parentID' ";
    $result = $db->select_to_array($query);
    return $result;
  }

  public static function get_all_comment_by_articleID($articleID)
  {
    $db = new Db();

    $sql = "SELECT * FROM comment WHERE titleID = '{$articleID}' ORDER BY commentLeft ASC";
    $result = $db->select_to_array($sql);

    return $result;
  }
}
