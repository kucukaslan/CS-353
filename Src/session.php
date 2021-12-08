<?php
   include('config.php');
   session_start();
   
   $user_check = $_SESSION['id'];
   
   $ses_sql = mysqli_query($db,"SELECT c_id FROM thecustomer WHERE cid = '$user_check' ");
   
//    $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
//    $login_session = $row['c_id'];
   
   if(!isset($_SESSION['id'])){
      header("location: Login/loginC.php");
   } 
?>