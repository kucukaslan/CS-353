<?php
require_once(__DIR__ . "/../session.php");
require_once("../config.php");
require_once(getRootDirectory()."/util/navbar.php");
require_once(getRootDirectory()."/util/TourSection.php");
require_once(getRootDirectory()."/util/TourSectionActivity.php");

if( ! isset($_SESSION['id']) || strcmp("employee", $_SESSION['type'] ?  $_SESSION['type'] : "none") != 0) {
    header("location: ".getRootDirectory());
}
$conn = getDatabaseConnection();


if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
  if (isset($_POST['ts_id']))
  {
    $_SESSION['ts_id'] = $_POST['ts_id'];
    unset($_POST['ts_id']);
    header("refresh:0");
  }
}
 ?> 
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Tour Details</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../styles/navbar.php">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <?php
        require_once("navbar.php");

        $ts_id = $_SESSION['ts_id'];
        $ts = TourSection::makeTourSection($conn, $ts_id);
        $act = TourSectionActivity::getActivitiesOfTour($conn,$ts_id);


        // print the tour details big
        $ts->printTourDetails();

        // print the activities as a list
        echo "<h2>Activities</h2>";
        echo "<ul>";

        // get the activities with type "basic"
        $basics = array();
        $extras = array();
        foreach($act as $a) {
            if($a->getType() == "basic") {
                array_push($basics, $a);
            } else {
                array_push($extras, $a);
            }
        }

        // print the basic activities as a table
        echo "<h3>Basic Activities</h3>";
        echo "<table class='table table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Activity ID</th>";
        echo "<th>Activity Name</th>";
        echo "<th>Location </th>";
        echo "<th>Date</th>";
        echo "<th>Start Time</th>";
        echo "<th>End Time</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach($basics as $b) {
            echo "<tr>";
            echo "<td>".$b->getAId()."</td>";
            echo "<td>".$b->getName()."</td>";
            echo "<td>".$b->getLocation()."</td>";
            echo "<td>".$b->getDate()."</td>";
            echo "<td>".$b->getStartTime()."</td>";
            echo "<td>".$b->getEndTime()."</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";

        // print the extra activities as a table
        echo "<h3>Extra Activities</h3>";
        echo "<table class='table table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Activity ID</th>";
        echo "<th>Activity Name</th>";
        echo "<th>Location </th>";
        echo "<th>Date</th>";
        echo "<th>Start Time</th>";
        echo "<th>End Time</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach($extras as $b) {
            echo "<tr>";
            echo "<td>".$b->getAId()."</td>";
            echo "<td>".$b->getName()."</td>";
            echo "<td>".$b->getLocation()."</td>";
            echo "<td>".$b->getDate()."</td>";
            echo "<td>".$b->getStartTime()."</td>";
            echo "<td>".$b->getEndTime()."</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</ul>";

        
        // list the pending reservations
        echo "<h2>Pending Reservations</h2>";
        echo "<ul>";
        $pending = $ts->getReservations($conn,TourSection::STATUS_PENDING);
        // print the pending reservations as a table with approve/reject buttons
        // columns   res_id ts_id 	e_id 	number 	status 	isRated 	reason 	bill 	name 	lastname 	email
        echo "<table class='table table-striped'>";
        echo "<thead>";
        echo "<tr>";
        
        echo "<th>Customer Name</th>";
        echo "<th>Customer Lastname</th>";
        echo "<th>Customer Email</th>";
        echo "<th>Number of People</th>";
        echo "<th>Approve</th>";
        echo "<th>Reject</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach($pending as $p) {
            echo "<tr>";
            echo "<td>".$p['name']."</td>";
            echo "<td>".$p['lastname']."</td>";
            echo "<td>".$p['email']."</td>";
            echo "<td>".$p['number']."</td>";
            echo "<td><form action='manageReservation.php' method='post'><input type='hidden' name='res_id' value='".$p['res_id']."'><input type='hidden' name='status' value='".TourSection::STATUS_APPROVED."'><input type='hidden' name='number' value='".$p['number']."'><input type='submit' value='Approve'></form></td>";
            echo "<td><form action='manageReservation.php' method='post'><input type='hidden' name='res_id' value='".$p['res_id']."'><input type='hidden' name='status' value='".TourSection::STATUS_REJECTED."'><input type='hidden' name='number' value='".$p['number']."'>
                <input type='text' name='reason' placeholder='Reason if you reject'><input type='submit' value='Reject'></textarea></textarea>
                </form></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</ul>";



        // list the approved reservations
        echo "<h2>Approved Reservations</h2>";
        echo "<ul>";
        $approved = $ts->getReservations($conn,TourSection::STATUS_APPROVED);
        echo "<table class='table table-striped'>";
        echo "<thead>";
        echo "<tr>";
        
        echo "<th>Customer Name</th>";
        echo "<th>Customer Lastname</th>";
        echo "<th>Customer Email</th>";
        echo "<th>Number of People</th>";
        echo "<th>Employee id</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach($approved as $p) {
            echo "<tr>";
            echo "<td>".$p['name']."</td>";
            echo "<td>".$p['lastname']."</td>";
            echo "<td>".$p['email']."</td>";
            echo "<td>".$p['number']."</td>";
            echo "<td>".$p['e_id']."</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</ul>";

        // list the rejected reservations
        echo "<h2>Rejected Reservations</h2>";
        echo "<ul>";
        $rejected = $ts->getReservations($conn,TourSection::STATUS_REJECTED);
        echo "<table class='table table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Customer Name</th>";
        echo "<th>Customer Lastname</th>";
        echo "<th>Customer Email</th>";
        echo "<th>Number of People</th>";
        echo "<th>Employee id</th>";
        echo "<th>Reason</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach($rejected as $p) {
            echo "<tr>";
            echo "<td>".$p['name']."</td>";
            echo "<td>".$p['lastname']."</td>";
            echo "<td>".$p['email']."</td>";
            echo "<td>".$p['number']."</td>";
            echo "<td>".$p['e_id']."</td>";
            echo "<td>".$p['reason']."</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</ul>";       
    
    ?>

</body>

</html>