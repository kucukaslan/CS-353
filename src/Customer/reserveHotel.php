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
GROUP BY hotel.h_id";

$resultTour = $db->query($sql);
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
            <?php while ($row = $resultTour->fetch_assoc()) : ?>
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
                            $sql = "SELECT room.type, room.r_id FROM hotel, room WHERE room.h_id = hotel.h_id AND hotel.h_id = $hotelID";
                            $resultRooms = $db->query($sql);
                            ?>
                            <select name="rooms" id="rooms">
                                <?php while ($roomRow = $resultRooms->fetch_assoc()) : ?>
                                    <option value=<?php echo $roomRow['r_id'] ?>><?php echo $roomRow['type'] ?></option>
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