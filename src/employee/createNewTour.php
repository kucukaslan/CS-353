<?php
include("../session.php");
require_once(getRootDirectory()."/employee/navbar.php");
//$_POST['tour_name']
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tour_name = $_POST['tour_name'];
    $depart_location = $_POST['depart_location'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $eid = $_SESSION['id'];

    $sql = "INSERT INTO tour (t_id, place, type) VALUES (NULL, '$depart_location', '$tour_name')";
    $result = $db->query($sql);
    $last_Inserted_Id = $db->insert_id;

    $sql = "INSERT INTO tour_section (ts_id, start_date, end_date, t_id) VALUES (NULL, '$start_date', '$end_date', $last_Inserted_Id)";
    $result = $db->query($sql);
    $last_Inserted_tour_section_id = $db->insert_id;

    //$sql = "INSERT INTO `guides` (`tg_id`, `ts_id`, `e_id`, `status`) VALUES (NULL,  $last_Inserted_tour_section_id, $eid, 'NULL')";
    //$result = $db->query($sql);

}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Create new Tour</title>
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

<h3>Create a Tour</h3>

<div style="border-radius: 5px;  background-color: #f2f2f2;  padding: 20px;">
  <form name="form" action="" method="post">
    <label for="fname">Tour Name</label>
    <input type="text" id="tour_name" name="tour_name" placeholder="Your name.." required="true">

    <label for="fname">Depart Location</label>
    <input type="text" id="depart_location" name="depart_location" placeholder="Your name.." required="true">

    <label for="birthday">Start Date:</label>
    <input type="date" id="start_date" name="start_date" required="true">

    <label for="birthday">End Date:</label>
    <input type="date" id="end_date" name="end_date" required="true">
  
    <input type="submit" value="Submit">
  </form>
</div>


</body>
</html>
