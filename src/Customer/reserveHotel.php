<?php
include("../session.php");
$cid = $_SESSION['id'];

if (isset($_POST['Reserveroom'])) {
    $rid = $_POST['rooms'];
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    $today = date('Y-m-d');

    if (empty((int)$startdate) || empty((int)$enddate)) {
        echo "<script>alert('Starting Date and End Date Cannot Be Empty, Room Has Not Been Reserved')</script>";
    } else if ($startdate < $today || $enddate < $today) {
        echo "<script>alert('End Date and/or Start Date Cannot Be Earlier Than Today, Room Has Not Been Reserved')</script>";
    } else if ($startdate > $enddate) {
        echo "<script>alert('End Date Cannot Be Earlier Than Start Date, Room Has Not Been Reserved')</script>";
    } else {
        $sql = "INSERT INTO booking (c_id, r_id, e_id, start_date, end_date, type, status) VALUES ($cid, $rid, NULL, '$startdate', '$enddate', 'online', 'pending') ";
        $db->query($sql);
    }
}

$sql = "SELECT hotel.name, hotel.city, hotel.address, hotel.phone, hotel.rating, hotel.h_id, COUNT(room.r_id) as roomC
FROM hotel, room 
WHERE room.h_id = hotel.h_id
AND room.r_id NOT IN (SELECT r_id from booking WHERE status != 'rejected')
GROUP BY hotel.h_id";


$sql2 = "SELECT booking.b_id, booking.start_date, booking.end_date, room.type, hotel.name, hotel.city, hotel.address, hotel.phone
FROM booking, hotel, room
WHERE booking.r_id= room.r_id 
AND room.h_id = hotel.h_id 
AND c_id = $cid 
AND status = 'pending'";

if (isset($_POST['filterHotels'])) {
    $name = $_POST['name'];
    $sql .= "AND hotel.name LIKE '%$name%';";
    $sql2 .= "AND hotel.name LIKE '%$name%';";
}

if (isset($_POST['clearFilter'])) {
    $name = $_POST['name'];
    str_replace("AND hotel.name LIKE '%$name%';", "", $sql);
    str_replace("AND hotel.name LIKE '%$name%';", "", $sql2);
}

$availableHotels = $db->query($sql);
$pendingHotels = $db->query($sql2);

if (isset($_POST['BookDetails'])) {
    $bookId = $_POST['bookId'];
    header("location: bookingDetails.php?bookId=$bookId");
}

if (isset($_POST['CancelBook'])) 
{
    $b_id = $_POST['bookId'];
    $sql = "DELETE FROM booking WHERE b_id = $b_id";
    $db->query($sql);
    header("Refresh:0");
}




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
    <form method="post" action="reserveHotel.php">
        <label for="name">Hotel Name:</label>
        <input type="text" id="name" name="name">

        <button class="btn btn-primary" type="submit" name="filterHotels">Filter</button>
        <button class="btn btn-warning" type="submit" name="clearFilter">Clear Filter</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Hotel Name</th>
                <th scope="col">Room Type</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Options</th>
            </tr>
        </thead>
        <tbody>
            <h3> Pending Hotel Reservations </h3>
            <?php while ($row = $pendingHotels->fetch_assoc()) : ?>
            <tr id=<?php $row['b_id'] ?>>
                <td> <?php echo $row['name'] ?> </td>
                <td> <?php echo $row['type'] ?> </td>
                <td> <?php echo $row['start_date'] ?> </td>
                <td> <?php echo $row['end_date'] ?> </td>
                <td>
                    <form method="post" action="reserveHotel.php"> <button class="btn btn-primary" type="submit"
                            name="BookDetails">Details</button> <button
                            onclick="return  confirm('Are You Sure You Want To Delete This Booking Y/N')"
                            class="btn btn-warning" type="submit" name="CancelBook">Cancel
                            Booking</button> <input type="hidden" name="bookId" value="<?php echo $row['b_id']; ?>">
                    </form>
                </td>

            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Hotel Name</th>
                <th scope="col">City</th>
                <th scope="col">Address</th>
                <th scope="col">Phone</th>
                <th scope="col">Rating</th>
                <th scope="col"># of Available Rooms</th>
                <th scope="col">Room Number</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Options</th>
            </tr>
        </thead>
        <tbody>
            <h3> Available Hotels </h3>
            <?php while ($row = $availableHotels->fetch_assoc()) : ?>
                <tr id=<?php $row['h_id'] ?>>
                    <td> <?php echo $row['name'] ?> </td>
                    <td> <?php echo $row['city'] ?> </td>
                    <td> <?php echo $row['address'] ?> </td>
                    <td> <?php echo $row['phone'] ?> </td>
                    <td> <?php echo $row['rating'] ?> </td>
                    <td> <?php echo $row['roomC'] ?></td>
                    <form method="post" action="reserveHotel.php">
                        <td>
                            <?php
                            $hotelID = $row['h_id'];
                            $sql = "SELECT room.type, room.price, room.capacity, room.r_id FROM hotel, room WHERE room.h_id = hotel.h_id AND room.r_id NOT IN (SELECT r_id from booking WHERE status != 'rejected') AND hotel.h_id = $hotelID";
                            $resultRooms = $db->query($sql);
                            ?>
                            <select name="rooms" id="rooms">
                                <?php while ($roomRow = $resultRooms->fetch_assoc()) : ?>
                                    <option value=<?php echo $roomRow['r_id'] ?>><?php echo $roomRow['type']. " - " .$roomRow['capacity'] . " Person - ". $roomRow['price']. "$" ?></option>
                                <?php endwhile; ?>
                            </select>
                        </td>
                        <td>
                            <input type="date" id="startdate" name="startdate">
                        </td>
                        <td>
                            <input type="date" id="enddate" name="enddate">
                        </td>
                        <td>
                            <button onclick="return  confirm('Are You Sure You Want To Reserve This Room Y/N')" class="btn btn-primary" type="submit" name="Reserveroom">Reserve Room</button>

                            <input type="hidden" name="resId" value="<?php echo $rr[$i]['h_id']; ?>">

                        </td>
                    </form>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>

</html>