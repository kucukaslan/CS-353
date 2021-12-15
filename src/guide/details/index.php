<?php
require_once(__DIR__."/../../session.php");
require_once("../../config.php");
require_once(getRootDirectory()."/util/navbar.php");

if(strcmp("tour_guide", $_SESSION['type'] ?  $_SESSION['type'] : "none") != 0) {
    header("location: ".getRootDirectory());
}

if($_SERVER['REQUEST_METHOD'] == "POST") {

}
 ?> 


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../../styles/navbar.php">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <!-- Beginning of Navbar -->
    <?php
        echo getGuideNavBar("../");
    ?>
    <!-- End of Navbar -->
    <!-- First four lines are invisible they're behind the navbar!-->
    <br>
    <br>
    <br>
    <br>

    <h2> Details of the Tour</h2>
</body>

</html>