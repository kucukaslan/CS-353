<?php
require_once(__DIR__."/../../session.php");
require_once("../../config.php");
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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <?php
        echo getEmployeeNavBar("../");
    ?>
    <?php
        $ts_id = $_SESSION['ts_id'];
        
        $ts = TourSection::makeTourSection($conn, $ts_id);

        $act = TourSectionActivity::getActivitiesOfTour($conn,$ts_id);


        // print the tour details big
        echo "<h2>Tour Details</h2>";
        echo "<ul>";
        echo "<li>Tour ID: ".$ts->getTId()."</li>";
        echo "<li>Tour Section ID: ".$ts->getTsId()."</li>";
        echo "<li>Place: ".$ts->getPlace()."</li>";
        echo "<li>Type: ".$ts->getType()."</li>";
        echo "<li>Start Date: ".$ts->getStartDate()->format('Y-m-d')."</li>";
        echo "<li>End Date: ".$ts->getEndDate()->format('Y-m-d')."</li>";
        echo "</ul>";

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


    ?>

</body>

</html>