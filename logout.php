<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: main.php');
}
unset($_SESSION['username']);
unset($_SESSION['useremail']);
unset($_SESSION['userid']);
unset($_SESSION['userthumb']);
session_destroy();
header('Location: main.php');
