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


        // is it post
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if(isset($_POST['option']))
            {
                $option = $_POST['option'];
                if($option == "cancel")
                {
                    $sql = "DELETE FROM guides WHERE ts_id = :ts_id and $tg_id = :tg_id and e_id = :e_id";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute(['ts_id' => $ts_id, 'tg_id' => $_POST['tg_id'], 'e_id' => $_SESSION['id']]);

                }
                else if($option == "offer")
                {
                    $sql = "INSERT INTO guides (ts_id, tg_id, e_id, status) VALUES (:ts_id, :tg_id, :e_id, 'pending') ON DUPLICATE KEY UPDATE status = 'pending'";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute(['ts_id' => $ts_id, 'tg_id' => $_POST['tg_id'], 'e_id' => $_SESSION['id']]);
                }
            }
        }

        // print the tour details big
        $ts->printTourDetails();
        $hasValidGuide = false;
        // 
        $t_guides = $ts->getTourGuide($conn, "approved");
        if( count( $t_guides)>0 )
        {
             // tg_id, ts_id, status, reason, name, lastname, email, birthday, registration
            echo '<h3>Tour Guides</h3>';
            echo '<table class="table table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Name</th>';
            echo '<th>Last Name</th>';
            echo '<th>Email</th>';
            echo '<th>Birthday</th>';
            echo '<th>Registration</th>';
            echo '<th>Status</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach($t_guides as $t_guide)
            {
                echo '<tr>';
                echo '<td>'.$t_guide['name'].'</td>';
                echo '<td>'.$t_guide['lastname'].'</td>';
                echo '<td>'.$t_guide['email'].'</td>';
                echo '<td>'.$t_guide['birthday'].'</td>';
                echo '<td>'.$t_guide['registration'].'</td>';
                echo '<td>'.$t_guide['status'].'</td>';
                echo '</tr>';
                if($t_guide['status'] == 'approved')
                {
                    $hasValidGuide = true;
                }
            }    
            
            echo '</tbody>';
            echo '</table>';      
        }
        else {
            $t_guides = $ts->getTourGuide($conn, "pending");
            if(count( $t_guides)>0)
            {
                // tg_id, ts_id, status, reason, name, lastname, email, birthday, registration
                echo '<h3>Pending Tour Guides</h3>';
                echo '<table class="table table-striped">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Name</th>';
                echo '<th>Last Name</th>';
                echo '<th>Email</th>';
                echo '<th>Birthday</th>';
                echo '<th>Registration</th>';
                echo '<th>Status</th>';
                echo '<th>Options</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                foreach($t_guides as $t_guide)
                {
                    echo '<tr>';
                    echo '<td>'.$t_guide['name'].'</td>';
                    echo '<td>'.$t_guide['lastname'].'</td>';
                    echo '<td>'.$t_guide['email'].'</td>';
                    echo '<td>'.$t_guide['birthday'].'</td>';
                    echo '<td>'.$t_guide['registration'].'</td>';
                    echo '<td>'.$t_guide['status'].'</td>';
                    echo '<td>';
                    echo '<form action="" method="post">';
                    echo '<input type="hidden" name="option" value="cancel">';
                    echo '<input type="hidden" name="tg_id" value="'.$t_guide['tg_id'].'">';
                    echo '<input type="hidden" name="ts_id" value="'.$ts_id.'">';
                    echo '<input type="submit" name="option" value="Cancel" class="btn btn-success">';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }   
                echo '</tbody>';
                echo '</table>';      
            }
            else {
                // drop down menu to choose a guide and offer
                // get all guides
                $sql = "SELECT * FROM tour_guide";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $t_guides = $stmt->fetchAll();
                if($t_guides > 0)
                {
                    echo '<h3>Offer a Tour Guide</h3>';
                    echo '<form action="" method="post">';
                    echo '<select name="tg_id">';
                    foreach($t_guides as $t_guide)
                    {
                        echo '<option value="'.$t_guide['tg_id'].'">'.$t_guide['name'].' '.$t_guide['lastname'].'</option>';
                    }
                    echo '</select>';
                    echo '<input type="hidden" name="ts_id" value="'.$ts_id.'">';
                    echo '<input type="submit" name="option" value="offer" class="btn btn-success">';
                    echo '</form>';
                }
                
            }
        }

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