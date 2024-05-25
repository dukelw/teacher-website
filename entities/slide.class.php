<?php
require_once ("../config/db.class.php");

class Slide
{
  public $ID;
  public $file;

  public function __construct($_file)
  {
    $this->file = $_file;
  }

  public static function list_slides()
  {
    $db = new Db();
    $sql = "SELECT * FROM slide";
    return $db->select_to_array($sql);
  }

  public function save()
  {
    $user_file = $this->file['name'];
    $file_temp = $this->file['tmp_name'];
    $filepath = "../upload/slides/" . $user_file;
    $db = new Db();
    if (move_uploaded_file($file_temp, $filepath) == false) {
      return false;
    }

    $sql = "INSERT INTO slide (file) VALUES (
        '" . mysqli_real_escape_string($db->connect(), $filepath) . "'
      )";
    $result = $db->query_execute($sql);
    return $result;
  }

  public static function delete($id)
  {
    $db = new Db();
    $sql = "DELETE FROM slide
            WHERE ID = '" . mysqli_real_escape_string($db->connect(), $id) . "'";
    $result = $db->query_execute($sql);
    return $result;
  }
}
?>