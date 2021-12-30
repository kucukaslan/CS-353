<?php
include("../session.php");
require_once(getRootDirectory()."/employee/navbar.php");

    

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

<h3>Create a Tour</h3>

<div>
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