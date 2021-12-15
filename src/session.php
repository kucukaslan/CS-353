<?php
   require_once('config.php');
   session_start();   
   
   if(!isset($_SESSION['id'])){
      header("location: ../login");
   } 
?>