<?php

require_once("../config/db.class.php");
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
header('Content-Type: text/html; charset=utf-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
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
    $filepath = "../upload/avatars/" . $timestamp . $user_file;
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
    $sql = "SELECT * FROM user WHERE mail = '$mail' AND password = '$password' AND isAdmin != 1";
    $result = $db->query_execute($sql);

    if ($result->num_rows > 0) {
      return true;
    } else {
      return false;
    }
  }

  public static function checkAdmin($mail, $password)
  {
    $db = new Db();
    $sql = "SELECT * FROM user WHERE mail = '$mail' AND password = '$password' AND isAdmin = 1";
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
    $sql = "SELECT * FROM user WHERE mail = '$email' AND isAdmin != 1";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function get_user_by_ID($id)
  {
    $db = new Db();
    $sql = "SELECT * FROM user WHERE ID = '$id' AND isAdmin != 1";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function get_admin_by_email($email)
  {
    $db = new Db();
    $sql = "SELECT * FROM user WHERE MAIL = '$email' AND isAdmin = 1";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public static function list_user()
  {
    $db = new Db();
    $sql = "SELECT * FROM user WHERE isAdmin != 1";
    $result = $db->select_to_array($sql);
    return $result;
  }

  public function update_information($id)
  {
    $existing_user = $this->get_user_by_ID($id);

    $filepath = '';

    if (!empty($this->avatar['tmp_name']) && is_uploaded_file($this->avatar['tmp_name'])) {
      $unique_filename = uniqid() . '_' . $this->avatar['name'];
      $filepath = "../upload/avatars/" . $unique_filename;

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

  public function signUp()
  {
    $filepath = "../upload/avatars/defaultAvatar.jpg";
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

  // Hàm gửi email để đặt lại mật khẩu
  public static function sendResetPasswordEmail($to, $resetLink)
  {
    $mail = new PHPMailer(true);

    try {
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com'; // Địa chỉ SMTP server của bạn
      $mail->SMTPAuth = true;
      $mail->Username = 'vinhquang2610345@gmail.com'; // Tên đăng nhập SMTP của bạn
      $mail->Password = 'dakznqktcjehswgo'; // Mật khẩu SMTP của bạn
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;

      $mail->setFrom('noreply@gmail.com', 'Nguyen Quang Vinh'); // Địa chỉ email người gửi
      $mail->addAddress($to); // Địa chỉ email người nhận
      $mail->isHTML(true);
      $subject = "Password Reset Request";
      $encoded_subject = mb_convert_encoding($subject, 'UTF-8', 'auto');
      $mail->Subject = $encoded_subject;

      $mail->Body = "You have requested to reset your password. Please click the following link to reset your password: $resetLink";

      $mail->send();
      return true;
    } catch (Exception $e) {
      echo "Lỗi khi gửi email: {$mail->ErrorInfo}";
      return false;
    }
  }

  public static function forgotPassword($email)
  {
    $db = new Db();
    $sql = "SELECT ID FROM user WHERE mail = '$email'";
    $result = $db->select_to_array($sql);

    if (!empty($result)) {
      $userId = $result[0]['ID'];
      $token = bin2hex(random_bytes(32));

      $sql = "INSERT INTO reset_tokens (user_id, token) VALUES ('$userId', '$token')";
      $insertResult = $db->query_execute($sql);

      if ($insertResult) {
        $resetLink = "http://localhost:3000/Users/ASUS/OneDrive/Desktop/teacher-website/reset_password.php?token=$token";

        if (self::sendResetPasswordEmail($email, $resetLink)) {
          return true;
        }
      }
    }
    return false;
  }



  // Hàm đặt lại mật khẩu với mã hóa
  public static function resetPassword($token, $newPassword)
  {
    $db = new Db();
    $sql = "SELECT user_id FROM reset_tokens WHERE token = '$token'";
    $result = $db->select_to_array($sql);

    if ($result) {
      $userId = $result[0]['user_id'];

      // Mã hóa mật khẩu mới trước khi cập nhật vào cơ sở dữ liệu
      $sqlUpdate = "UPDATE user SET password = '$newPassword' WHERE ID = $userId";
      $resultUpdate = $db->query_execute($sqlUpdate);

      if ($resultUpdate) {
        $sqlDelete = "DELETE FROM reset_tokens WHERE token = '$token'";
        $db->query_execute($sqlDelete);
        return true;
      }
    }
    return false;
  }

  public static function delete($id)
  {
    $db = new Db();
    $sql = "DELETE FROM user
            WHERE ID = '" . mysqli_real_escape_string($db->connect(), $id) . "'";
    $result = $db->query_execute($sql);
    return $result;
  }
}
