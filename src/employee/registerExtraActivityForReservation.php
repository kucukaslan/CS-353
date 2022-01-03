<?php
include("../session.php");
require_once(getRootDirectory()."/employee/navbar.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    if (isset($_POST['customer_id']))
    {
        
        $customer_id = $_POST['customer_id'];
        $tour_section_id = $_POST['tour_section_id'];
        $employee_id = $_SESSION['id'];
        $number = $_POST['number'];
        $sql = "INSERT INTO `reservation`
         (`res_id`, `c_id`, `ts_id`, `e_id`, `number`, `status`, `isRated`, `reason`, `bill`)
          VALUES (NULL, $customer_id, $tour_section_id, $employee_id, $number, 'approved', NULL, NULL, '0.00')";
        $result = $db->query($sql);
        
    }
}




$sql = "SELECT res_id FROM `reservation`";
$result_reservation_list = $db->query($sql);



?>


<!DOCTYPE html>
<html>
<head>
    <title>register extra activity for a reservation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../styles/navbar.php">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
</style>
<body>

<h3>register extra acitivty for a reservation. <?php ?>  </h3>

<div>
  <form name="form" action="registerExtraActivityForReservationBeingDirected.php" method="post">


  <label for="type">reservation id:</label>
    <select name="reservation_id" id="reservation_id">
    <?php while($row = $result_reservation_list->fetch_assoc())
    {
        $x = $row["res_id"];
        echo "<option value=\"$x\">$x</option>";
    }
         ?>
        
    </select>


    

    

    <input type="submit" value="Submit">
  </form>
</div>


</body>
</html>