<?php
require_once("../session.php");
require_once(getRootDirectory()."/employee/navbar.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    /*
    $x = $_POST['hotel_phone'];
    $y = $_POST['hotel_stars'];
    echo $x;
    echo $y;
    
    echo "\n";
    echo " evet" .is_string($x);
    echo " hayir" .is_int($y);
    */
    if (isset($_POST['hotel_name'])) //create hotel
    {
        $hotel_name = $_POST['hotel_name'];
        $hotel_phone = $_POST['hotel_phone'];
        $hotel_city = $_POST['hotel_city'];
        $hotel_address = $_POST['hotel_address'];
        $hotel_stars= $_POST['hotel_stars'];


        $sql = "INSERT INTO `hotel` (`h_id`, `phone`, `name`, `city`, `address`, `rating`)
         VALUES (NULL, $hotel_phone, '$hotel_name', '$hotel_city', '$hotel_address', $hotel_stars)";
    
        $result = $db->query($sql);
    }
    else //direct user to the adding a new room page
    {

    }
}

?>




<!DOCTYPE html>
<html>
<head>
    <title>Register Hotel</title>
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

<h3>Register a hotel</h3>

<div style="border-radius: 5px;  background-color: #f2f2f2;  padding: 20px;">
  <form name="form" action="" method="post">
    <label for="fname">Hotel name</label>
    <input type="text" id="hotel_name" name="hotel_name" placeholder="Your name.." required="true">

    <label for="fname">Hotel phone</label>
    <input type="text" id="hotel_phone" name="hotel_phone" placeholder="Your name.." required="true">

    <label for="fname">Hotel city</label>
    <input type="text" id="hotel_city" name="hotel_city" placeholder="Your name.." required="true">


    <label for="fname">Hotel address</label>
    <input type="text" id="hotel_address" name="hotel_address" placeholder="Your name.." required="true">

    <label for="fname">Hotel stars</label>
    <select name="hotel_stars" id="hotel_stars">
        <option value=0>0</option>
        <option value=1>1</option>
        <option value=2>2</option>
        <option value=3>3</option>
        <option value=4>4</option>
        <option value=5>5</option>
      </select>
  
    <input type="submit" value="Submit">
  </form>
</div>


</body>
</html>
