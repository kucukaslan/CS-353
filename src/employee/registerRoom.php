<?php
require_once("../session.php");
require_once(getRootDirectory()."/employee/navbar.php");
    
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $h_id = $_POST['hotel_id'];
    $room_price = $_POST['room_price'];
    $room_capacity = $_POST['room_capacity'];
    $room_type = $_POST['room_type'];

    $sql = "INSERT INTO `room` (`h_id`, `price`, `capacity`, `type`, `r_id`) VALUES ($h_id, $room_price, $room_capacity, '$room_type', NULL)";
    echo $sql;
    $result = $result = $db->query($sql);
}

$sql = "SELECT `h_id`, `name`, `city` FROM `hotel` ";
$result = $result = $db->query($sql);
?>



<!DOCTYPE html>
<html>
<head>
    <title>Register Room</title>
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

<h3>Register a room</h3>

<div style="border-radius: 5px;  background-color: #f2f2f2;  padding: 20px;">
  <form name="form" action="" method="post">
    <label for="fname">Hotel id</label>
    <select name="hotel_id" id="hotel_id">
    <?php
        while ($row = $result->fetch_assoc())
        {
            $h_id = $row['h_id'];
            $name = $row['name'];
            $city = $row['city'];
            echo "<option value=$h_id>$name / $city</option>";
        }   
    ?>
     
      </select>


    <label for="fname">price</label>
    <input type="number" id="room_price" name="room_price" placeholder="price.." required="true">

    <label for="fname">capacity</label>
    <input type="number" id="room_capacity" name="room_capacity" placeholder="capacity.." required="true">


    <label for="fname">type</label>
    <input type="text" id="room_type" name="room_type" placeholder="type.." required="true">

    
  
    <input type="submit" value="Submit">
  </form>
</div>


</body>
</html>