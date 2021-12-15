<?php
session_start();
// Redirect user to appropriate place
$_SESSION['id'] ??     header("Location: login");
if( strcmp("tour_guide", $_SESSION['type'] ?  $_SESSION['type'] : "none") == 0) {
    header("Location: guide");
}
else if( strcmp("employee", $_SESSION['type'] ?  $_SESSION['type'] : "none") == 0) {
    header("Location: employee");
}
else if( strcmp("thecustomer", $_SESSION['type'] ?  $_SESSION['type'] : "none") == 0) {
    header("Location: customer/");
}
else
    header("Location: login");