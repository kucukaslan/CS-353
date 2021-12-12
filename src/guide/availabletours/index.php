<?php
include("../../config.php");
session_start();

if(!isset($_SESSION['id'])  ){
    header("location: ".getRootDirectory()."/login");
}
else if(strcmp("tour_guide", $_SESSION['type'] ?? "none") != 0) {
    header("location: ".getRootDirectory());
}
if($_SERVER['REQUEST_METHOD'] == "POST") {

}
 ?> 


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Available Tours</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../../styles/navbar.php">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <!-- Beginning of Navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#resNav">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href=".." class="navbar-brand">Company Logo</a>
        </div>
        <div class="collapse navbar-collapse" id="resNav">
            <ul class="nav navbar-nav navbar-right">
                    <form action="../../logout.php">
                            <input type="submit" name="logout" class="btn btn-danger" value="Logout" />
                        </form>
                </ul>    

            <ul class="nav navbar-nav navbar-right">
                <div>
                    <form action="../availabletours" method="post">
                        <input type="submit" name="availabletours" class="btn btn-primary" value="Available Tours" />
                    </form>
                </div>    
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <div>
                    <form action="../profile" method="post">
                         <input type="submit" name="profile" class="btn btn-secondary" value="Profile" />
                    </form>
                </div>
            </ul>
        </div>
    </nav>
    <!-- End of Navbar -->
    <!-- First four lines are invisible they're behind the navbar!-->
    <br>
    <br>
    <br>
    <br>

    <h2> Available Tours</h2>
</body>

</html>