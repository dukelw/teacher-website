<?php
require_once("../config/db.class.php");

class Document
{
  public $ID;
  public $title;
  public $description;
  public $publish;
  public $cateID;
  public $docfile;
  public $subject;

  public function __construct($_title, $_description, $_cateID, $_docfile, $_publish, $_subject)
  {
    $this->title = $_title;
    $this->description = $_description;
    $this->cateID = $_cateID;
    $this->docfile = $_docfile;
    $this->publish = $_publish;
    $this->subject = $_subject;
  }

  public function getTitle()
  {
    return $this->title;
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function getCateID()
  {
    return $this->cateID;
  }

  public function getDocfile()
  {
    return $this->docfile;
  }

  public function getPublish()
  {
    return $this->publish;
  }

  public static function list_document_with_category()
  {
    $db = new Db();
    $sql = "SELECT d.*, dc.CATENAME 
                FROM document d 
                JOIN doccategory dc ON d.cateID = dc.ID";
    return $db->select_to_array($sql);
  }

  public static function list_document_by_major($major)
  {
    $db = new Db();
    $sql = "SELECT d.*, dc.CATENAME 
                FROM document d 
                JOIN doccategory dc ON d.cateID = dc.ID WHERE subject = '$major'";
    return $db->select_to_array($sql);
  }

  public static function get_document($id)
  {
    $db = new Db();
    $sql = "SELECT d.*, dc.CATENAME
            FROM document d 
            JOIN doccategory dc ON d.cateID = dc.ID
            WHERE d.ID = '$id'";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public function save()
  {
    $file_temp = $this->docfile['tmp_name'];
    $user_file = $this->docfile['name'];
    $timestamp = date("Y") . date("m") . date("d") . date("h") . date("i") . date("s");
    $filepath = "../upload/documents/" . $timestamp . $user_file;
    if (move_uploaded_file($file_temp, $filepath) == false) {
      return false;
    }

    $db = new Db();
    $sql = "INSERT INTO document (title, description, publish, cateID, docfile, subject) VALUES (
        '" . mysqli_real_escape_string($db->connect(), $this->title) . "',
        '" . mysqli_real_escape_string($db->connect(), $this->description) . "',
        '" . mysqli_real_escape_string($db->connect(), $this->publish) . "',
        '" . mysqli_real_escape_string($db->connect(), $this->cateID) . "',
        '" . mysqli_real_escape_string($db->connect(), $filepath) . "',
        '" . mysqli_real_escape_string($db->connect(), $this->subject) . "'
    )";
    $result = $db->query_execute($sql);
    return $result;
  }

  public function update_document($id)
  {
    $db = new Db();

    // Get the existing document
    $existing_document = $this->get_document($id);

    // Initialize $filepath
    $filepath = '';

    // Check if a new file is uploaded
    if (!empty($this->docfile['tmp_name'])) {
      // Generate a unique file name
      $unique_filename = uniqid() . '_' . $this->docfile['name'];
      $filepath = "../upload/documents/" . $unique_filename;

      // Move the uploaded file to the destination directory
      if (!move_uploaded_file($this->docfile['tmp_name'], $filepath)) {
        // Handle file upload error (e.g., log error or show user message)
        return false;
      }
    } else {
      // If no new file uploaded, use the existing file path
      $filepath = $existing_document[0]['docfile'];
    }

    // Construct the SQL query to update the document
    $sql = "UPDATE document SET 
            title = '" . mysqli_real_escape_string($db->connect(), $this->title) . "', 
            description = '" . mysqli_real_escape_string($db->connect(), $this->description) . "', 
            publish = '" . mysqli_real_escape_string($db->connect(), $this->publish) . "', 
            cateID = '" . mysqli_real_escape_string($db->connect(), $this->cateID) . "', 
            docfile = '" . mysqli_real_escape_string($db->connect(), $filepath) . "',
            subject = '" . mysqli_real_escape_string($db->connect(), $this->subject) . "'
            WHERE ID = '" . mysqli_real_escape_string($db->connect(), $id) . "'";

    // Execute the SQL query
    $result = $db->query_execute($sql);

    // Return the result of the update operation
    return $result;
  }

  public static function delete($id)
  {
    $db = new Db();
    $sql = "DELETE FROM document
            WHERE ID = '" . mysqli_real_escape_string($db->connect(), $id) . "'";
    $result = $db->query_execute($sql);
    return $result;
  }

  public static function to_string($document)
  {
    echo $document->title;
    echo $document->description;
    echo $document->cateID;
    echo $document->docfile;
    echo $document->publish;
    echo $document->subject;
  }
}
