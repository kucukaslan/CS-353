<?php
require_once(__DIR__ . "/../session.php");
if( !isset($_SESSION['id']) || strcmp("employee", $_SESSION['type'] ?  $_SESSION['type'] : "none") != 0) {
    header("location: ".getRootDirectory());
}
// include https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">';

// we are given a res_id, number, status, and reason
//  
if($_SERVER['REQUEST_METHOD'] == "POST") {
    if(isset($_POST['res_id'])) {
       
        $res_id = $_POST['res_id'];
        $status = $_POST['status'];
        $reason = $_POST['reason'] ?? "";
        $sql = "UPDATE `reservation` SET `status`= '$status', `reason`= '$reason' WHERE `res_id`= $res_id";

        try {
            mysqli_query($db, $sql);
            // print the success message
            echo "<div class='alert alert-success'>
                    <strong>Success!</strong> The reservation status has been updated to $status.
                  </div>";

        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>
                    <strong>Error!</strong> The reservation status could not be updated to $status.
                  </div>";
            //echo $sql;
            //var_export( $e);
        }        

        // click here to return to the main page
        echo "<a href='.' class='btn btn-primary'>Return to Manage Reservations</a>";
    }   
}