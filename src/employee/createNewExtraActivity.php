<?php
include("../session.php");
require_once(getRootDirectory()."/employee/navbar.php");
//$_POST['tour_name']
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
  if (isset($_POST['ts_id']))
  {
    $_SESSION['ts_id'] = $_POST['ts_id'];
  }
  else
  {
    if (isset($_SESSION['ts_id']))
    {
        $type_of_activity = $_POST['type'];
        $ts_id = $_SESSION['ts_id'];
        $extra_activity_name = $_POST['extra_activity_name'];
    $extra_activity_location = $_POST['extra_activity_location'];
    $date = $_POST['date'];
    $time_beginning = $_POST['time_beginning'];
    $time_end = $_POST['time_end'];
    $eid = $_SESSION['id'];

    $sql = "INSERT INTO `activity` (`a_id`, `name`, `location`, `date`, `start_time`, `end_time`) VALUES (NULL, '$extra_activity_name', '$extra_activity_location', '$date', '$time_beginning', '$time_end')";
    $result = $db->query($sql);
    $last_Inserted_a_id = $db->insert_id;

    $sql = "INSERT INTO `tour_activity` (`ts_id`, `a_id`, `type`) VALUES ($ts_id , $last_Inserted_a_id , '$type_of_activity')";
    $result = $db->query($sql);
    }
  }
    


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

div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
</style>
<body>

<h3>Create a new extra activity for tour x</h3>

<div>
  <form name="form" action="" method="post">
    <label for="extra activity name">extra activity name</label>
    <input type="text" id="extra_activity_name" name="extra_activity_name" placeholder="Your name.." required="true">

    <label for="extra activity location">extra activity location</label>
    <input type="text" id="extra_activity_location" name="extra_activity_location" placeholder="Your name.." required="true">

    <label for="Date">Date:</label>
    <input type="date" id="date" name="date" required="true">

    <label for="time beginning">Select a time beginning:</label>
    <input type="time" id="time_beginning" name="time_beginning" required="true">
  
    <label for="time end">Select a time for the end:</label>
    <input type="time" id="time_end" name="time_end" required="true">

    <label for="type">type of the activity:</label>
    <select name="type" id="type">
        <option value="basic">basic</option>
        <option value="extra">extra</option>
    </select>

    <input type="submit" value="Submit">
  </form>
</div>


</body>
</html>