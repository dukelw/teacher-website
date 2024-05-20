<?php
require_once("../config/db.class.php");
?>
<?php
class Major
{
  public $ID;
  public $name;
  public $description;

  public function __construct($name, $description)
  {
    $this->name = $name;
    $this->description = $description;
  }

  public function save()
  {
    $db = new Db();
    $sql = "INSERT INTO major (name, description) VALUES (
      '" . mysqli_real_escape_string($db->connect(), $this->name) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->description) . "'
    )";
    $result = $db->query_execute($sql);
    return $result;
  }

  public static function list_major()
  {
    $db = new Db();
    $sql = "SELECT * FROM major";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function list_major_by_id($id)
  {
    $db = new Db();
    $sql = "SELECT * FROM major WHERE ID = '$id'";
    $result = $db->select_to_array($sql);
    return $result;
  }
}
?>