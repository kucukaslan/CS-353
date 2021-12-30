<?php

    function getEmployeeNavBar(string $relative_path) : string {
        // a navbar for an employee
        // with the following links:
        //  <li><a href=index.php>employee dashboard</a></li>
        //        <li><a href=pendingHotelReservations.php>Pending Hotel Reservations</a></li>
        //        <li><a href=pendingTours.php>Pending Tours</a></li>
        //        <li><a href=createNewTour.php>Create New Tour</a></li>
        //        <li><a href=createNewExtraActivity.php>Create New activity</a></li>
        //        <li><a href=registerHotel.php>Register Hotel</a></li>
        //        <li><a href=registerRoom.php>Register Room</a></li>
        //        <li><a href=profile.php>Profile</a></li>
        //        <li><a href=../logout.php>Log Out</a></li>
        $navbar = '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#resNav">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="'.$relative_path.'" class="navbar-brand">Company Logo</a>
            </div>
            <div class="collapse navbar-collapse" id="resNav">';
        $navbar .=  '<ul class="nav navbar-nav navbar-right">
                        <form action="'.$relative_path.'../logout.php">
                                <input type="submit" name="logout" class="btn btn-danger" value="Logout" />
                        </form>
                    </ul>';
        $navbar .=  navbarItemUL("index.php","index",   "Employee Dashboard");
        $navbar .=  navbarItemUL("pendingHotelReservations.php","pendingHotelReservations",   "Pending Hotel Reservations");
        $navbar .=  navbarItemUL("pendingTours.php","pendingTours",   "Pending Tours");
        $navbar .=  navbarItemUL("createNewTour.php","createNewTour",   "Create New Tour");
        $navbar .=  navbarItemUL("createNewExtraActivity.php","createNewExtraActivity",   "Create New Extra Activity");
        $navbar .=  navbarItemUL("registerHotel.php","registerHotel",   "Register Hotel");
        $navbar .=  navbarItemUL("registerRoom.php","registerRoom",   "Register Room");
        $navbar .=  navbarItemUL("profile.php","profile",   "Profile");
        $navbar .=  '</div></nav>';

       return $navbar;
    }
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
    function navbarItemUL($path, $name, $text) : string {
        return '<ul class="nav navbar-nav navbar-right" >
                        <form action="'.$path.'" method="post">
                                <input type="submit" name="'.$name.'" class="btn" value="'.$text.'" />
                            </form>
                    </ul>';
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