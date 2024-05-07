<?php
require_once ("./config/db.class.php");
?>
<?php
class Doccategory
{
  public $ID;
  public $CATENAME;

  public function __construct($_name)
  {
    $this->CATENAME = $_name;
  }

  public static function list_doccategory()
  {
    $db = new Db();
    $sql = "SELECT * FROM doccategory";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function list_doccategory_by_id($id)
  {
    $db = new Db();
    $sql = "SELECT * FROM doccategory WHERE ID = '$id'";
    $result = $db->select_to_array($sql);
    return $result;
  }
}
?>