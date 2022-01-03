<?php
   define('DB_SERVER', 'dijkstra.ug.bcc.bilkent.edu.tr');
   define('DB_USERNAME', 'ahmad.salman');
   define('DB_PASSWORD', 'ikHBfw98');
   define('DB_DATABASE', 'ahmad_salman');
   /*
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   define('DB_DATABASE', 'cs353');
   */
   $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
   mysqli_set_charset($db, "utf8mb4");

   function getRootDirectory() : string {
      return dirname(__FILE__);
   }

   function getDatabaseConnection() : PDO {
      $conn = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_DATABASE.";charset=utf8mb4", DB_USERNAME, DB_PASSWORD);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
   }
?>