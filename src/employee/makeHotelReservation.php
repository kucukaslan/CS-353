<?php
include("../session.php");
require_once(getRootDirectory()."/employee/navbar.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    if (isset($_POST['customer_id']))
    {
        
        $customer_id = $_POST['customer_id'];
        $room_id = $_POST['room_id'];
        $employee_id = $_SESSION['id'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $sql = "INSERT INTO `booking` 
        (`b_id`, `c_id`, `r_id`, `e_id`, `start_date`, `end_date`, `type`, `status`, `reason`, `bill`) 
        VALUES (NULL, $customer_id, $room_id, $employee_id, '$start_date', '$end_date', 'facetoface', 'approved', 'reservation was made by an employee', '0.00')";
        $result = $db->query($sql);
    }
}




$sql = "SELECT c_id FROM `thecustomer`";
$result_customer_list = $db->query($sql);

$sql = "SELECT r_id, capacity FROM `room`";
$result_room_list = $db->query($sql);


?>


<!DOCTYPE html>
<html>
<head>
    <title>Create a hotel reservation for a customer</title>
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
</style>
<body>

<h3>Create a hotel reservation for a customer <?php ?>  </h3>

<div style="border-radius: 5px;  background-color: #f2f2f2;  padding: 20px;">
  <form name="form" action="" method="post">


  <label for="type">customer id:</label>
    <select name="customer_id" id="customer_id">
    <?php while($row = $result_customer_list->fetch_assoc())
    {
        $x = $row["c_id"];
        echo "<option value=\"$x\">$x</option>";
    }
         ?>
        
    </select>


    <label for="type">room id:</label>
    <select name="room_id" id="room_id">
    <?php while($row = $result_room_list->fetch_assoc())
    {
        $x = $row["r_id"];
        $y = $row['capacity'];
        echo "<option value=\"$x\">room id: $x capacity: $y</option>";
    }
         ?>
    </select>



    <label for="Date">start Date:</label>
    <input type="date" id="start_date" name="start_date" required="true">

    <label for="Date">end Date:</label>
    <input type="date" id="end_date" name="end_date" required="true">
   

    

    <input type="submit" value="Submit">
  </form>
</div>


</body>
</html>