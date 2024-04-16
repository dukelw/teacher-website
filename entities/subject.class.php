<?php
require_once("./config/db.class.php");


class Subject
{
  public $ID;
  public $name;

  public function __construct($_name)
  {
    $this->name = $_name;
  }

  public static function list_subject()
  {
    $db = new Db();
    $sql = "SELECT * FROM subject";
    $result = $db->select_to_array($sql);
    return $result;
  }
}
