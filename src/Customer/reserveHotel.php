<?php
include("../session.php");
$cid = $_SESSION['id'];

if (isset($_POST['Reserveroom'])) {
    $rid = $_POST['rooms'];
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];

    $sql = "INSERT INTO booking (c_id, r_id, e_id, start_date, end_date, type, status) VALUES ($cid, $rid, NULL, $startdate, $enddate, 'online', 'pending') ";
    $db->query($sql);
    //header("Refresh:0");
}

$sql = "SELECT hotel.name, hotel.city, hotel.address, hotel.phone, hotel.rating, hotel.h_id, COUNT(room.r_id) as roomC
FROM hotel, room 
WHERE room.h_id = hotel.h_id
GROUP BY hotel.h_id";


$resultTour = $db -> query($sql);

$sql = "SELECT room.type
FROM hotel, room
WHERE hotel.h_id = room.h_id;"; # !!! THE PROBLEM IN HERE WE ARE PRINTING EVERY ROOM IN EXISTANCE !!!

$resultTour2 = $db -> query($sql);

while ($row = $resultTour->fetch_assoc()) {
    $rr[] = $row;
}
while ($row2 = $resultTour2->fetch_assoc()) {
    $rr2[] = $row2;
}/*
$i2=0;
for ($i=0; $i < count($rr); $i++) {
    echo 'hi ';
    for (; $i2 < $rr[$i]['roomC']; $i2++) {
        echo $rr2[$i2]['type'];
    }
}*/

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Customer Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../styles/navbar.php">
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
    <a class="nav-link active" href="reserveHotel.php">Reserve a Hotel</a>
    <a href="profile.php">Profile</a>
    <form action="../logout.php">
        <input type="submit" name="logout" class="btn btn-danger" value="Logout" />
    </form>
</div>
<!-- End of Navbar -->
<br>
<table class="table">
    <thead>
    <tr>
        <th scope="col">Hotel Name</th>
        <th scope="col">City</th>
        <th scope="col">Address</th>
        <th scope="col">Phone</th>
        <th scope="col">Rating</th>
        <th scope="col">Number of Available Rooms</th>
        <th scope="col">Room Number</th>
        <th scope="col">Start Date</th>
        <th scope="col">End Date</th>
        <th scope="col">Options</th>
    </tr>
    </thead>
    <tbody>
    <h3> Available Hotels </h3>
    <?php $i2=0; $pk=0; for ($i=0; $i < count($rr); $i++) { ?>
        <tr id=<?php $rr[$i]['h_id'] ?>>
            <td> <?php echo $rr[$i]['name'] ?> </td>
            <td> <?php echo $rr[$i]['city'] ?> </td>
            <td> <?php echo $rr[$i]['address'] ?> </td>
            <td> <?php echo $rr[$i]['phone'] ?> </td>
            <td> <?php echo $rr[$i]['rating'] ?> </td>
            <td> Error </td>
            <td>
                <select name="rooms" id="rooms">
                    <?php for (; $i2 < $rr[$i]['roomC']+$pk; $i2++) { ?>
                        <option value="r1"><?php echo $rr2[$i2]['type'] ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <input type="date" id="startdate" name="startdate">
            </td>
            <td>
                <input type="date" id="enddate" name="enddate">
            </td>
            <td>
                <form method="post" action="reserveHotel.php"> <button onclick="return  confirm('Are You Sure You Want To Reserve This Room Y/N')"
                                                                       class="btn btn-primary" type="submit" name="Reserveroom">Reserve Room</button>

                    <input type="hidden" name="resId" value="<?php echo $rr[$i]['h_id']; ?>">
                </form>
            </td>

        </tr>
    <?php $pk=$i2; } ?>
    </tbody>
</table>



</body>

</html>