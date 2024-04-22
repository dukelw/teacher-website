<?php
require_once("./config/db.class.php");
?>
<?php
class Teacher
{
  public $ID;
  public $name;
  public $mail;
  public $password;
  public $avatar;
  public $gender;
  public $phone;
  public $birthday;
  public $joinyear;
  public $fired;
  public $position;

  public function __construct(
    $name,
    $mail,
    $password,
    $avatar,
    $gender,
    $phone,
    $birthday,
    $joinyear,
    $fired,
    $position,
  ) {
    $this->name = $name;
    $this->mail = $mail;
    $this->password = $password;
    $this->$avatar = $avatar;
    $this->$gender = $gender;
    $this->$phone = $phone;
    $this->$birthday = $birthday;
    $this->$joinyear = $joinyear;
    $this->$fired = $fired;
    $this->$position = $position;
  }

  public function save()
  {
    $file_temp = $this->avatar['tmp_name'];
    $user_file = $this->avatar['name'];
    $timestamp = date("Y") . date("m") . date("d") . date("h") . date("i") . date("s");
    $filepath = "./upload/" . $timestamp . $user_file;
    if (move_uploaded_file($file_temp, $filepath) == false) {
      return false;
    }
    $db = new Db();
    $sql = "INSERT INTO teacher (name, mail, password, avatar, gender, phone, birthday, joinyear, fired, position) VALUES (
      '" . mysqli_real_escape_string($db->connect(), $this->name) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->mail) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->password) . "',
      '" . mysqli_real_escape_string($db->connect(), $filepath) . "',
      " . ($this->gender ? 1 : 0) . ",
      '" . mysqli_real_escape_string($db->connect(), $this->phone) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->birthday) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->joinyear) . "',
      " . ($this->fired ? 1 : 0) . ",
      '" . mysqli_real_escape_string($db->connect(), $this->position) . "'
    )";
    $result = $db->query_execute($sql);
    return $result;
  }

  public static function checkLogin($mail, $password)
  {
    $db = new Db();
    $sql = "SELECT * FROM teacher WHERE mail = '$mail' AND password = '$password'";
    $result = $db->query_execute($sql);

    if ($result->num_rows > 0) {
      return true;
    } else {
      return false;
    }
  }

  public static function get_teacher($email)
  {
    $db = new Db();
    $sql = "SELECT * FROM teacher WHERE mail = '$email'";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function list_teacher()
  {
    $db = new Db();
    $sql = "SELECT * FROM teacher";
    $result = $db->select_to_array($sql);
    return $result;
  }

}
