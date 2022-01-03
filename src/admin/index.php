<!DOCTYPE html>
<html lang="en">
<?php
require_once(__DIR__."/../session.php");
require_once("../config.php");
require_once(getRootDirectory()."/util/navbar.php");
if( ! isset($_SESSION['id']) && strcmp("admin", $_SESSION['type'] ?  $_SESSION['type'] : "none") != 0) {
    header("location: ".getRootDirectory());
}
?>
<head>
  <title>Administrative Reports</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../styles/navbar.php">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<?php
    // print the first report table for approved
    // with columns sum_of_bills	employee_id	name	lastname	email	salary	position
    $sql = "CALL `sum_of_bill_endorsement`('approved');";
    $result = getDatabaseConnection()->query($sql); 
    printSumOfBillEndorsementTable($result, " Approved");

    // print the second report table for rejected
    // with columns sum_of_bills	employee_id	name	lastname	email	salary	position
    $sql = "CALL `sum_of_bill_endorsement`('rejected')";
    $result = getDatabaseConnection()->query($sql);
    printSumOfBillEndorsementTable($result, " Rejected");
    

    // CALL `tour_participant_depart_city`(); 
    // print the table with columns stats.city as `Flight Depart City`, number_of_participants_from_that_city,     stats.ts_id, t.place as `Tour Place`, t.type `Tour Name`, ts.start_date as `Tour Start Date`, ts.end_date as `Tour End Date`

    $sql = "CALL `tour_participant_depart_city`();";
    $result = getDatabaseConnection()->query($sql);
    printTourParticipantDepartCityTable($result);

    function printTourParticipantDepartCityTable($result, int $max = 25) {
        // print table with the columns city, number_of_participants_from_that_city, ts_id, t.place as `Tour Place`, t.type `Tour Name`, ts.start_date as `Tour Start Date`, ts.end_date as `Tour End Date`
        echo "<div class='container'>";
        echo "<h2>Tour Participant Depart City</h2>";
        echo "The report that shows the frequency of cities that participants of a particular tour_section bought a ticket to depart from that city. <br>";
        echo "<table class='table table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Flight Depart City</th>";
        echo "<th>Number of Participants</th>";
        echo "<th>Tour Place</th>";
        echo "<th>Tour Name</th>";
        echo "<th>Tour Start Date</th>";
        echo "<th>Tour End Date</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $i = 0;
        while($row = $result->fetch()) {
            if ($i > $max) {
                break;
            }
            echo "<tr>";
            //Flight Depart City	number_of_participants_from_that_city	ts_id	Tour Place	Tour Name	Tour Start Date	Tour End Date
            echo "<td>".$row['Flight Depart City']."</td>";
            echo "<td>".$row['number_of_participants_from_that_city']."</td>";
            echo "<td>".$row['Tour Place']."</td>";
            echo "<td>".$row['Tour Name']."</td>";
            echo "<td>".$row['Tour Start Date']."</td>";
            echo "<td>".$row['Tour End Date']."</td>";
            echo "</tr>";
            
            $i++;
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }

    function printSumOfBillEndorsementTable(PDOStatement $result, $tmp=" ", int $max = 25) {
    echo "<div class='container'>";
        echo "<h2>Sum of$tmp Bill Endorsements</h2>";
        echo "The report that shows the total endorsement (sum of the costs of every hotel booking and tour reservation) $tmp by the employees. <br>";
        echo "<table class='table table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Sum of Bills</th>";
        echo "<th>Employee ID</th>";
        echo "<th>Name</th>";
        echo "<th>Lastname</th>";
        echo "<th>Email</th>";
        echo "<th>Salary</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $i = 0;
    while($row = $result->fetch() ) {
        
        echo "<tr>";
        echo "<td>".$row['sum_of_bills']."</td>";
        echo "<td>".$row['employee_id']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['lastname']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['salary']."</td>";
        echo "</tr>";
        $i = $i + 1;
        if($i == $max) {
            break;
        }
    }
    
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
}

?>