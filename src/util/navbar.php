<?php

    function getGuideNavBar(string $relative_path) : string {
        $navbar = '<!-- Beginning of Navbar -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#resNav">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="'.$relative_path.'" class="navbar-brand">Company Logo</a>
            </div>
            <div class="collapse navbar-collapse" id="resNav">
                <ul class="nav navbar-nav navbar-right">
                        <form action="'.$relative_path.'../logout.php">
                                <input type="submit" name="logout" class="btn btn-danger" value="Logout" />
                            </form>
                    </ul>    
    
                <ul class="nav navbar-nav navbar-right">
                    <div>
                        <form action="'.$relative_path.'availabletours" method="post">
                            <input type="submit" name="availabletours" class="btn btn-primary" value="Available Tours" />
                        </form>
                    </div>    
                </ul>
    
                <ul class="nav navbar-nav navbar-right">
                    <div>
                        <form action="'.$relative_path.'profile" method="post">
                             <input type="submit" name="profile" class="btn btn-secondary" value="Profile" />
                        </form>
                    </div>
                </ul>
                
    
            </div>
    
        </nav>
        <!-- End of Navbar -->';
        return $navbar;
    }
    function getCustomerNav () : string {
        $navbar = '<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../styles/navbar.php">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <div style="border: 2px solid red; border-radius: 5px;" class="pill-nav">
        <a href="../customer">Home</a>
        <a href="reserveFlight.php">Reserve a Flight</a>
        <a href="pastTours.php">Past Tours</a>
        <a href="bookTour.php">Book a Tour</a>
        <a href="reserveHotel.php">Reserve a Hotel</a>
        <a href="profile.php">Profile</a>
        <form action="../logout.php">
            <input type="submit" name="logout" class="btn btn-danger" value="Logout" />
        </form>
    </div>';
        return $navbar;
    }
?>