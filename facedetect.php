<?php
function get_dataset()
{
  $command = escapeshellcmd(command: 'python ./ai/01_face_dataset.py');
  exec($command, $output, $resultCode);
}

function training()
{
  $command = escapeshellcmd(command: 'python ./ai/02_face_training.py');
  exec($command, $output, $resultCode);
}

function face_recognition()
{
  include_once('./entities/user.class.php');
  $command = escapeshellcmd(command: 'python ./ai/03_face_recognition.py');
  exec($command, $output, $resultCode);
  $value = $output[0];
  if ($value === "Dzoan Thanh") {
    $email = 'dzoanthanh@gmail.com';
    $user = User::get_admin_by_email($email);

    session_start();
    if ($user) {
      $_SESSION['userID'] = $user[0]['ID'];
      $_SESSION['username'] = $user[0]["NAME"];
      $_SESSION['useremail'] = $user[0]["MAIL"];
      $_SESSION['userthumb'] = $user[0]['AVATAR'];
      header('Location: dashboard.php');
    }
  }
}

// Call
face_recognition();
