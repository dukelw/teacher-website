<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: main.php');
}
session_destroy();
unset($_SESSION['username']);
unset($_SESSION['useremail']);
header('Location: main.php');
