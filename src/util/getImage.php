<?php
include("../session.php");
    $cid = $_SESSION['id'];
  // do some validation here to ensure id is safe

  $sql = "SELECT profile_picture FROM thecustomer WHERE c_id=$id";
  $userInfo = $db->query($sql);
$userInfo = $userInfo->fetch_assoc();

  header("Content-type: image/jpeg");
  echo $userInfo['profile_picture'];
  echo "Picture of user $cid";
?>