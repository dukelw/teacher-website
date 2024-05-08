<?php
require_once ("./config/db.class.php");
?>
<?php
class User
{
  public $ID;
  public $name;
  public $mail;
  public $password;
  public $address;
  public $avatar;
  public $gender;
  public $phone;
  public $birthday;

  public function __construct(
    $name,
    $mail,
    $password,
    $avatar,
    $gender,
    $phone,
    $birthday,
    $address
  ) {
    $this->name = $name;
    $this->mail = $mail;
    $this->password = $password;
    $this->avatar = $avatar;
    $this->gender = $gender;
    $this->phone = $phone;
    $this->birthday = $birthday;
    $this->address = $address;
  }

  public function save()
  {
    $file_temp = $this->avatar['tmp_name'];
    $user_file = $this->avatar['name'];
    $timestamp = date("Y") . date("m") . date("d") . date("h") . date("i") . date("s");
    $filepath = "./upload/avatars/" . $timestamp . $user_file;
    if (move_uploaded_file($file_temp, $filepath) == false) {
      return false;
    }
    $db = new Db();
    $sql = "INSERT INTO user (name, mail, password, avatar, gender, phone, birthday, address) VALUES (
      '" . mysqli_real_escape_string($db->connect(), $this->name) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->mail) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->password) . "',
      '" . mysqli_real_escape_string($db->connect(), $filepath) . "',
      " . intval($this->gender) . ",
      '" . mysqli_real_escape_string($db->connect(), $this->phone) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->birthday) . "',
      '" . mysqli_real_escape_string($db->connect(), $this->address) . "'
    )";
    $result = $db->query_execute($sql);
    return $result;
  }

  public static function checkLogin($mail, $password)
  {
    $db = new Db();
    $sql = "SELECT * FROM user WHERE mail = '$mail' AND password = '$password'";
    $result = $db->query_execute($sql);

    if ($result->num_rows > 0) {
      return true;
    } else {
      return false;
    }
  }

  public static function get_user($email)
  {
    $db = new Db();
    $sql = "SELECT * FROM user WHERE mail = '$email'";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function get_user_by_ID($id)
  {
    $db = new Db();
    $sql = "SELECT * FROM user WHERE ID = '$id'";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function list_user()
  {
    $db = new Db();
    $sql = "SELECT * FROM user";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public function update_information($id)
  {
    $existing_user = $this->get_user_by_ID($id);

    $filepath = '';

    if (!empty($this->avatar['tmp_name']) && is_uploaded_file($this->avatar['tmp_name'])) {
      // Nếu $this->avatar là một ảnh mới đã được tải lên từ máy khách
      $unique_filename = uniqid() . '_' . $this->avatar['name'];
      $filepath = "./upload/avatars/" . $unique_filename;

      if (!move_uploaded_file($this->avatar['tmp_name'], $filepath)) {
        return false;
      }
    } else {
      // Nếu $this->avatar là ảnh cũ
      $filepath = $existing_user[0]['AVATAR'];
    }

    $db = new Db();
    $sql = "UPDATE user SET 
            mail = '" . mysqli_real_escape_string($db->connect(), $this->mail) . "',
            avatar = '" . mysqli_real_escape_string($db->connect(), $filepath) . "',
            name = '" . mysqli_real_escape_string($db->connect(), $this->name) . "',
            address = '" . mysqli_real_escape_string($db->connect(), $this->address) . "',
            gender = $this->gender,
            birthday = '" . mysqli_real_escape_string($db->connect(), $this->birthday) . "',
            phone = '" . mysqli_real_escape_string($db->connect(), $this->phone) . "'
            WHERE ID = '" . mysqli_real_escape_string($db->connect(), $id) . "'";

    $result = $db->query_execute($sql);
    return $result;
  }
}
