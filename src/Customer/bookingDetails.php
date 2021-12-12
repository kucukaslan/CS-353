<?php
include("../session.php");
$cid = $_SESSION['id'];

$bookId = $_GET['bookId'];
echo "Booking with ID $bookId";

$sql = "SELECT hotel.name, hotel.city, hotel.address, hotel.rating, hotel.phone, room.price, room.type, booking.start_date, booking.end_date, booking.type AS bType
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
    <title>Customer Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../styles/navbar.php">
    <link rel="stylesheet" href="../styles/bookingDetails.php">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
<div style="border: 2px solid red; border-radius: 5px;" class="pill-nav">
        <a href="../customer">Home</a>
        <a href="reserveFlight.php">Reserve a Flight</a>
        <a href="pastTours.php">Past Tours</a>
        <a href="bookTour.php">Book a Tour</a>
        <a href="reserveHotel.php">Reserve a Hotel</a>
        <a href="profile.php">Profile</a>
        <form action="../logout.php">
            <input type="submit" name="logout" class="btn btn-danger" value="Logout" />
        </form>
    </div>
    <h3>Booking Details of Your Reservation <?php ?></h3>
    <div style="border: 2px solid red; border-radius: 5px;" class="container">
    <br>
  <p><b>Hotel Name:</b> <?php echo $row['name']?> </p>
  <p><b>Hotel Address:</b> <?php echo $row['address']. " / " . $row['city']?></p>
  <p><b>Hotel Phone Number: </b> <?php echo $row['phone']?></p>
  <p><b>Hotel Rating:</b> <?php echo $row['rating']. " stars"?></p>
  <p><b>Booking Start Date:</b> <?php echo $row['start_date']?> </p>
  <p><b>Booking End Date:</b> <?php echo $row['end_date']?></p>
  <p><b>Room Type:</b> <?php echo $row['type']?></p>
  <p><b>Room Price:</b> <?php echo $row['price']. "$"?></p>
  <p><b>Booking Done via:</b> <?php echo $row['bType']?></p>
  <br>
</div>
</body>


</html>