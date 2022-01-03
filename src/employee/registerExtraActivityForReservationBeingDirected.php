<?php
include("../session.php");
require_once(getRootDirectory()."/employee/navbar.php");


$sql;
$result_activity_list;
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    
    if (isset ($_SESSION['res_id']) && isset ($_POST['activity_id']))
    {
        $res_id = $_SESSION['res_id'];
        $activity_id = $_POST['activity_id'];
        //$sql_get_customer_id = "SELECT c_id FROM reservation WHERE res_id = $res_id";
        //$result_customer = $db->query($sql_get_customer_id);
        //$row = $result_activity_list->fetch_assoc();

        //$customer_id = $row['c_id'];
        $sqlInsert = "INSERT INTO `reservation_activity` (`res_id`, `a_id`) VALUES ($res_id, $activity_id)";
        $my_result = $db->query($sqlInsert);
    }
    if (isset($_POST['reservation_id']))
    {
        echo "evet";
        $_SESSION['res_id'] = $_POST['reservation_id'];
        $res_id = $_SESSION['res_id'];
        $sql = "SELECT activity.a_id, activity.name 
        FROM `activity`, tour_section, tour_activity, reservation
        WHERE reservation.res_id = $res_id AND
        reservation.ts_id = tour_section.ts_id AND
        tour_section.ts_id = tour_activity.ts_id AND
        activity.a_id = tour_activity.a_id AND
        tour_activity.type = 'extra'
        ";
        $result_activity_list = $db->query($sql);
        
    }
    
}



$sql_customer = "SELECT c_id FROM `thecustomer`";
$result_customer_list = $db->query($sql_customer);





?>


<!DOCTYPE html>
<html>
<head>
    <title>add extra activity for specified reservation</title>
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

<h3>add extra activity for specified reservation <?php ?>  </h3>

<div>
  <form name="form" action="" method="post">




    <label for="type">activity id:</label>
    <select name="activity_id" id="activity_id">
    <?php while($row = $result_activity_list->fetch_assoc())
    {
        $x = $row["a_id"];
        $y = $row["name"];
        echo "<option value=\"$x\">activity id: $x activity name: $y</option>";
    }
         ?>
    </select>


    

    <input type="submit" value="Submit">
  </form>
</div>


</body>
</html>