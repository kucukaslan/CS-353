<?php
   define('DB_SERVER', 'dijkstra.ug.bcc.bilkent.edu.tr');
   define('DB_USERNAME', 'ahmad.salman');
   define('DB_PASSWORD', 'ikHBfw98');
   define('DB_DATABASE', 'ahmad_salman');

   $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

   function getRootDirectory() : string {
      return dirname(__FILE__);
   }

   function getDatabaseConnection() : PDO {
      $conn = new PDO("mysql:host=dijkstra.ug.bcc.bilkent.edu.tr;dbname=".DB_DATABASE, DB_USERNAME, DB_PASSWORD);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
   }
?>