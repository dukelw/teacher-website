<?php
include_once("./entities/comment.class.php");
include_once("./entities/user.class.php");

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SESSION['useremail']) && isset($_POST['content'])) {
  $articleID = $_POST["articleID"];
  $userID = intval($_SESSION['userID']);
  $username = $_SESSION["username"];
  $userthumb = $_SESSION["userthumb"];
  $parentName = '';
  $content = $_POST["content"];
  if (isset($_POST["parentID"])) {
    $parent_comment_id = $_POST["parentID"];
    $parentName = User::get_user_by_ID($userID)[0]["NAME"];
  } else {
    $parent_comment_id = -1;
  }
  $result = Comment::createComment($articleID, $userID, $username, $userthumb, $parentName, $content, $parent_comment_id);
  echo json_encode(['success' => $result]);
} else {
  echo json_encode(['success' => false]);
}
