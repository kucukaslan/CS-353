<?php
   include('config.php');
   session_start();   
   
   if(!isset($_SESSION['id'])){
      header("location: ../Login/loginC.php");
   } 
?>