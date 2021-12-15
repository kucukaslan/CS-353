<!DOCTYPE html>
<html lang="en">
<?php
require_once(__DIR__."/../session.php");
require_once("../config.php");
require_once(getRootDirectory()."/util/navbar.php");
if(strcmp("tour_guide", $_SESSION['type'] ?  $_SESSION['type'] : "none") != 0) {
    header("location: ".getRootDirectory());
}
?>
<head>
  <title>Tour Guide Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../styles/navbar.php">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>



<body>
    <?php
        echo getGuideNavBar("./");
    ?>
    <!-- First four lines are invisible they're behind the navbar!-->
    <br>
    <br>
    <br>
    <br>

    <h2>Hello guide <?php echo "${_SESSION['name']} ${_SESSION['lastname']} "?> </h2>
    <p> 
    <?php

    echo "sorry WIP!<br>";

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        var_dump($_POST);
    }
    else if ($_SERVER['REQUEST_METHOD'] == "GET") { 
        if (isset($_GET['op'])) {
            $op = $_GET['op'];
            if ($op == "details") {
                header("location: details", true, 301);
            }
            else if ($op == "feedback") {
                header("location: details", true, 301);
            }
        }
    }
        ?>    
</p>

    <h3>Your tours</h3>
    <?php
        $sql = "SELECT tour_section.ts_id, tour.type, start_date, end_date
        FROM tour_section  NATURAL JOIN tour NATURAL JOIN guides NATURAL JOIN tour_guide
        WHERE  end_date < NOW() 
        AND guides.tg_id = ${_SESSION['id']}";

        $result = mysqli_query($db, $sql);
    
        if(mysqli_num_rows($result) > 0) {
            // print table of tours
            echo "<table style=\"width:80%\" align='center'>";
            echo "<tr >"
                . "<th> Section Id" . "</th>"
                . "<th> Tour Name" . "</th>"
                . "<th> Tour Start Date" . "</th>"
                . "<th> Tour End Date" . "</th>"
                . "<th> </th>"
                . "<th> </th>"
                . "<th> </th>"
                . "</tr>";
            while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC)          ) {
                echo "<tr>"
                . "<td>" . $row['ts_id'] . "</td>"
                . "<td>" . $row['type'] . "</td>"
                . "<td>" . $row['start_date'] . "</td>"
                    . "<td>" . $row['end_date'] . "</td>"
                    . "<td></td>"
                    . "<td><form method=\"post\" action=\"index.php\"> 
                        <input type=\"hidden\" name=\"op\" value=\"details\">
                        <input type=\"hidden\" name=\"ts_id\" value=" . $row['ts_id'] . ">
                        <input type='submit' class='button_submit' value='Details'></form></td>"
                    ."<td>
                        <form method=\"post\" action=\"index.php\"> 
                        <input type=\"hidden\" name=\"op\" value=\"feedback\">
                        <input type=\"hidden\" name=\"ts_id\" value=" . $row['ts_id'] . ">
                        <input type='submit' class='button_submit' value='Give Feedback'></form></td>";

                echo "</tr>";
            }
             echo "</table>";
        }
        else {
            echo "No tours available!";
        }
    ?>

</body>

</html>