<?php
include("../session.php");
require_once(getRootDirectory()."/employee/navbar.php");
    
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $h_id = $_POST['hotel_id'];
    $room_price = $_POST['room_price'];
    $room_capacity = $_POST['room_capacity'];
    $room_type = $_POST['room_type'];

    $sql = "INSERT INTO `room` (`h_id`, `price`, `capacity`, `type`, `r_id`) VALUES ($h_id, $room_price, $room_capacity, '$room_type', NULL)";
    $result = $result = $db->query($sql);
}

$sql = "SELECT `h_id` FROM `hotel` ";
$result = $result = $db->query($sql);
?>



<!DOCTYPE html>
<html>
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

<h3>Register a room</h3>

<div>
  <form name="form" action="" method="post">
    <label for="fname">Hotel id</label>
    <select name="hotel_id" id="hotel_id">
    <?php
        while ($row = $result->fetch_assoc())
        {
            $h_id = $row['h_id'];
            echo "<option value=$h_id>$h_id</option>";
        }   
    ?>
     
      </select>


    <label for="fname">price</label>
    <input type="text" id="room_price" name="room_price" placeholder="price.." required="true">

    <label for="fname">capacity</label>
    <input type="text" id="room_capacity" name="room_capacity" placeholder="capacity.." required="true">


    <label for="fname">type</label>
    <input type="text" id="room_type" name="room_type" placeholder="type.." required="true">

    
  
    <input type="submit" value="Submit">
  </form>
</div>


</body>
</html>