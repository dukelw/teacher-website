<?php
require_once("../config/db.class.php");


class Subject
{
  public $ID;
  public $name;

  public function __construct($_name)
  {
    $this->name = $_name;
  }

  public function save()
  {
    $db = new Db();
    $sql = "INSERT INTO subject (name) VALUES (
      '" . mysqli_real_escape_string($db->connect(), $this->name) . "'
    )";
    $result = $db->query_execute($sql);
    return $result;
  }

  public static function list_subject()
  {
    $db = new Db();
    $sql = "SELECT * FROM subject";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function get_subject($id)
  {
    $db = new Db();
    $sql = "SELECT * FROM subject WHERE ID = '$id'";
    $result = $db->select_to_array($sql);
    return $result;
  }
}
