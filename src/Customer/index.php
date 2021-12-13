<?php
include("../session.php");
$cid = $_SESSION['id'];

$sql = "SELECT reservation.res_id, tour.type, tour_section.start_date, tour_section.end_date, tour_guide.name, tour_guide.lastname 
FROM tour_section, reservation, guides, tour, tour_guide 
WHERE tour.t_id = tour_section.t_id 
AND reservation.ts_id = tour_section.ts_id 
AND guides.tg_id = tour_guide.tg_id 
AND guides.ts_id = tour_section.ts_id 
AND reservation.status = 'approved' 
AND reservation.c_id = $cid ";

$resultTour = $db->query($sql);

if (isset($_POST['ResDetails'])) {
    $resId = $_POST['resId'];
    header("location: reservationDetails.php?resId=$resId");
}

if (isset($_POST['CancelRes'])) 
{
    $res_id = $_POST['resId'];
    $sql = "DELETE FROM reservation WHERE res_id = $res_id";
    $db->query($sql);
    header("Refresh:0");
}

$sql = "SELECT booking.b_id, booking.start_date, booking.end_date, room.type, hotel.name, hotel.city, hotel.address, hotel.phone
FROM booking, hotel, room
WHERE booking.r_id= room.r_id 
AND room.h_id = hotel.h_id 
AND c_id = $cid 
AND status = 'accepted'";

$resultHotel = $db->query($sql);

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
        <a class="nav-link active" href="../customer">Home</a>
        <a href="reserveFlight.php">Reserve a Flight</a>
        <a href="pastTours.php">Past Tours</a>
        <a href="bookTour.php">Book a Tour</a>
        <a href="reserveHotel.php">Reserve a Hotel</a>
        <a href="profile.php">Profile</a>
        <form action="../logout.php">
            <input type="submit" name="logout" class="btn btn-danger" value="Logout" />
        </form>
    </div>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Tour Name</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Tour Guide Name</th>
                <th scope="col">Options</th>
            </tr>
        </thead>
        <tbody>
            <h3> Your Tour Reservations </h3>
            <?php while ($row = $resultTour->fetch_assoc()) : ?>
                <tr id=<?php $row['res_id'] ?>>
                    <td> <?php echo $row['type'] ?> </td>
                    <td> <?php echo $row['start_date'] ?> </td>
                    <td> <?php echo $row['end_date'] ?> </td>
                    <td> <?php echo $row['name'] . " " . $row['lastname'] ?> </td>
                    <td>
                        <form method="post" action="index.php"> <button class="btn btn-primary" type="submit" name="ResDetails">Details</button> <button onclick="return  confirm('Are You Sure You Want To Delete This Reservation Y/N')" class="btn btn-warning" type="submit" name="CancelRes">Cancel
                                Reservation</button> <input type="hidden" name="resId" value="<?php echo $row['res_id']; ?>"> </form>
                    </td>

                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <hr class="rounded">

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
            <h3> Your Hotel Bookings </h3>
            <?php while ($row = $resultHotel->fetch_assoc()) : ?>
                <tr id=<?php $row['b_id'] ?>>
                    <td> <?php echo $row['name'] ?> </td>
                    <td> <?php echo $row['type'] ?> </td>
                    <td> <?php echo $row['start_date'] ?> </td>
                    <td> <?php echo $row['end_date'] ?> </td>
                    <td>
                        <form method="post" action="index.php"> <button class="btn btn-primary" type="submit" name="BookDetails">Details</button> <button onclick="return  confirm('Are You Sure You Want To Delete This Booking Y/N')" class="btn btn-warning" type="submit" name="CancelBook">Cancel
                                Booking</button> <input type="hidden" name="bookId" value="<?php echo $row['b_id']; ?>">
                        </form>
                    </td>

                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>

</html>