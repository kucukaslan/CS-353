<?php
include("../session.php");
require_once(getRootDirectory()."/util/navbar.php");
$cid = $_SESSION['id'];

$bookId = $_GET['bookId'];

$sql = "SELECT hotel.name, hotel.city, hotel.address, hotel.rating, hotel.phone, room.price, room.type, booking.start_date, booking.bill, booking.end_date, booking.type AS bType
FROM booking, hotel, room
WHERE hotel.h_id = room.h_id AND
room.r_id = booking.r_id AND
booking.b_id = $bookId";
$result = $db -> query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Booking Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <?php
        echo getCustomerNav("./");
    ?>  
    <br>
    <br>
    <br>
    <div style="border: 2px solid red; border-radius: 5px;" class="container">
    <h3>Booking Details of Your Reservation</h3>
        
        <p><b>Hotel Name:</b> <?php echo $row['name']?> </p>
        <p><b>Hotel Address:</b> <?php echo $row['address']. " / " . $row['city']?></p>
        <p><b>Hotel Phone Number: </b> <?php echo $row['phone']?></p>
        <p><b>Hotel Rating:</b> <?php echo $row['rating']. " stars"?></p>
        <p><b>Booking Start Date:</b> <?php echo $row['start_date']?> </p>
        <p><b>Booking End Date:</b> <?php echo $row['end_date']?></p>
        <p><b>Number of Days: </b> <?php echo round( ( strtotime($row['end_date']) - strtotime($row['start_date']))/ (60 * 60 * 24)) ?></p>
        <p><b>Room Type:</b> <?php echo $row['type']?></p>
        <p><b>Room Price Per Night:</b> <?php echo $row['price']. "$"?></p>
        <p><b>Booking Done via:</b> <?php echo $row['bType']?></p>
        <p><b>Total Bill:</b> <?php echo $row['bill']?>$</p>
        <br>
    </div>
</body>


</html>