<?php
require_once(__DIR__."/../../session.php");
require_once("../../config.php");
require_once(getRootDirectory()."/util/navbar.php");
if(isset($_SESSION['id']) && strcmp("tour_guide", $_SESSION['type'] ?  $_SESSION['type'] : "none") != 0) {
    header("location: ".getRootDirectory());
}
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $_SESSION['op'] = $_POST['op'];
    $_SESSION['ts_id'] = $_POST['ts_id'];
    $_SESSION['reason'] = $_POST['reason'] ?? "";
    // clear the request
    unset($_POST);
    header("Location: "); 
}
else if ($_SERVER['REQUEST_METHOD'] == "GET") { 
    if (isset($_SESSION['op'])) {
        $op = $_SESSION['op'];
        $reason = $_SESSION['reason'];
        unset($_SESSION['op']);
        unset($_SESSION['reason']);

        if ($op == "details") {
            header("location: ../details", true, 301);
        }
        else if ($op == "accept") {
            updateTourSectionStatus($db,"approved");
            header("location: ", true, 301);
        }
        else if ($op == "reject") {
            updateTourSectionStatus($db, "rejected", $reason);

            header("location: ", true, 301);
        }
    }
}

function updateTourSectionStatus($db, string $status, $reason = "no reason is stated") {
    $sql = 'UPDATE `guides` SET `status`= \''.$status.'\', `reason`=\''.$reason.'\' WHERE `tg_id`= '.$_SESSION['id'] .' AND `ts_id`= '. $_SESSION['ts_id'];
    echo $sql;
    try { 
        mysqli_query($db, $sql);
        
    } catch (Exception $e) {
       /* echo $e;
        echo "<br>";
        echo $sql;
        */
        header("location: ", true, 500);
    }
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
    <?php
        echo getGuideNavBar("../");
    ?>
    <!-- End of Navbar -->
    <h2>Hello guide <?php echo "${_SESSION['name']} ${_SESSION['lastname']} "?> </h2>
    <p>
</p>
    <h2>Current Tour Offers</h2>
    <?php
        $sql = "SELECT  tour_section.ts_id,
        tour.type, start_date, end_date FROM tour_section NATURAL JOIN tour NATURAL JOIN guides NATURAL JOIN tour_guide 
    WHERE start_date > NOW() AND guides.tg_id = ${_SESSION['id']}  AND guides.status = \"pending\"";

        $result = mysqli_query($db, $sql);
    
        if(mysqli_num_rows($result) > 0) {
            printAvailableTourTable($result, true);
        }
        else {
            echo "No tours available!";
        }

        echo '<h2>Rejected Tour Offers</h2> ';
        $sql = "SELECT  tour_section.ts_id,
        tour.type, start_date, end_date, reason FROM tour_section NATURAL JOIN tour NATURAL JOIN guides NATURAL JOIN tour_guide 
    WHERE start_date > NOW() AND guides.tg_id = ${_SESSION['id']}  AND guides.status = 'rejected'";

        $result = mysqli_query($db, $sql);
    
        if(mysqli_num_rows($result) > 0) {
            printAvailableTourTable($result, false);
        }
        else {
            echo "No tours available!";
        }


        function printAvailableTourTable($result, bool $status=true) {
 // print table of tours
 echo "<table style=\"width:80%\" class=\"table\" align='center'>";
 echo "<tr >"
     . "<th> Section Id" . "</th>"
     . "<th> Tour Name" . "</th>"
     . "<th> Tour Start Date" . "</th>"
     . "<th> Tour End Date" . "</th>"
     . (mysqli_num_rows($result)>0 ? "<th> Reason" . "</th>" : "")
     ."<th></th>"
          .($status ?  "<th></th> <th></th> <th></th> " :"")
     . "</tr>";
 while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC)          ) {
     echo "<tr>"
     . "<td>" . $row['ts_id'] . "</td>"
     . "<td>" . $row['type'] . "</td>"
     . "<td>" . $row['start_date'] . "</td>"
         . "<td>" . $row['end_date'] . "</td>"
         . (isset($row['reason']) ? "<td>" . $row['reason'] . "</td>" : "")
         . "<td></td>".
          "<td><form method=\"post\" action=''> 
             <input type=\"hidden\" name=\"op\" value=\"details\">
             <input type=\"hidden\" name=\"ts_id\" value=" . $row['ts_id'] . ">
             <input type='submit' class='button_submit' value='Details'></form></td>"
         .
         ($status ?
         "<td>
             <form method=\"post\" action=''> 
             <input type=\"hidden\" name=\"op\" value=\"accept\">
             <input type=\"hidden\" name=\"ts_id\" value=" . $row['ts_id'] . ">
             <input type='submit' class='button_submit' value='Accept'></form></td>"
         ."<td>
             <form method=\"post\" action=''> 
             <input type='text' name='reason' placeholder='Reason if you reject'></textarea></textarea>
             <input type=\"hidden\" name=\"op\" value=\"reject\">
             <input type=\"hidden\" name=\"ts_id\" value=" . $row['ts_id'] . ">
             <input type='submit' class='button_submit' value='Reject'></form></td>"
            :"");

     echo "</tr>";
 }
  echo "</table>";
        }
        ?>
</body>

</html>