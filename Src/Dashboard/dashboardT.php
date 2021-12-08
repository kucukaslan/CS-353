<?php
include("../session.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Tour Guide Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../Styles/navbar.php">
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
            <a href="#" class="navbar-brand">Company Logo</a>
        </div>
        <div class="collapse navbar-collapse" id="resNav">
            <ul class="nav navbar-nav navbar-right">
                <div>

                    <form action="post">

                        <input type="submit" name="button1" class="btn btn-primary" value="Button1" />

                        <input type="submit" name="button2" class="btn btn-secondary" value="Button2" />

                        <input type="submit" name="button3" class="btn btn-info" value="Button3" />

                        <input type="submit" name="button2" class="btn btn-warning" value="Button4" />
                    </form>
                    <form action="../logout.php">
                        <input type="submit" name="logout" class="btn btn-danger" value="Logout" />
                    </form>
                </div>
            </ul>

        </div>

    </nav>
    <!-- End of Navbar -->
</body>

</html>