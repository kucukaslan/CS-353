<?php
include("../session.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Customer Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../styles/navbar.php">
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
                        <input type="submit" name="flight" class="btn btn-primary" value="Reserve a Flight" />
                        <input type="submit" name="pastTour" class="btn btn-secondary" value="Past Tours" />
                        <input type="submit" name="bookTour" class="btn btn-info" value="Book a Tour" />
                        <input type="submit" name="hotel" class="btn btn-warning" value="Reserve Hotel" />
                        <input type="submit" name="profile" class="btn btn-warning" value="Profile" />
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