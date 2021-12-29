<?php
include("../session.php");
require_once(getRootDirectory()."/util/navbar.php");
$cid = $_SESSION['id'];

$sql = "SELECT reservation.res_id, tour.type, tour_section.start_date, tour_section.end_date, tour_guide.name, tour_guide.lastname 
FROM tour_section, reservation, guides, tour, tour_guide 
WHERE tour.t_id = tour_section.t_id 
AND reservation.ts_id = tour_section.ts_id 
AND guides.tg_id = tour_guide.tg_id 
AND guides.ts_id = tour_section.ts_id
AND guides.status = 'approved'
AND reservation.status = 'approved' 
AND tour_section.end_date > NOW()
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
AND status = 'approved'";

$resultHotel = $db->query($sql);

$sql = "SELECT flight.f_id, flight.ticket_price, dept.city as dept_city, dept.name as dept_name, dest.city as dest_city, dest.name as dest_name, flight.dest_airport, flight.dept_date, flight.arrive_date, flight.capacity, flight_reservation.fr_id, flight_reservation.number_of_passengers
FROM flight, airport as dept, airport as dest, flight_reservation
WHERE flight.f_id = flight_reservation.f_id
AND flight.dept_airport = dept.airport_code
AND flight.dest_airport = dest.airport_code ORDER BY flight_reservation.fr_id";

$resultFlight = $db->query($sql);

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

if (isset($_POST['CancelFlight']))
{
    $frid = $_POST['flightresId'];
    $sql = "DELETE FROM flight_reservation WHERE fr_id = $frid";
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
</head>

<body>
    <?php
        echo getCustomerNav("./");
    ?>
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
                    <form method="post" action="index.php">
                        <button class="btn btn-primary" type="submit" name="ResDetails">Details</button>
                        <?php
                        $todayDate = date('Y-m-d');
                        if ($row['start_date'] > $todayDate)
                        {
                            echo '<button onclick="return  confirm(\'Are You Sure You Want To Delete This Reservation Y/N\')"
                            class="btn btn-warning" type="submit" name="CancelRes">Cancel Reservation</button>';
                        }
                         ?>
                        <input type="hidden" name="resId" value="<?php echo $row['res_id']; ?>">
                    </form>
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
                    <form method="post" action="index.php"> <button class="btn btn-primary" type="submit"
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

    <hr class="rounded">


    <table class="table">
        <thead>
        <tr>
            <th scope="col">Flight Reservation Number</th>
            <th scope="col">Depart Airport</th>
            <th scope="col">Depart Location</th>
            <th scope="col">Departs on</th>
            <th scope="col">Arrival Airport</th>
            <th scope="col">Arrival Location</th>
            <th scope="col">Arrives on</th>
            <th scope="col">Capacity</th>
            <th scope="col">Number of Passengers</th>
            <th scope="col">Options</th>
        </tr>
        </thead>
        <tbody>
        <h3> Your Flights </h3>
        <?php while ($row = $resultFlight->fetch_assoc()) : ?>
            <tr id=<?php $row['f_id'] ?>>
                <td> <?php echo $row['fr_id'] ?> </td>
                <td> <?php echo $row['dept_name'] ?> </td>
                <td> <?php echo $row['dept_city'] ?> </td>
                <td> <?php echo $row['dept_date'] ?> </td>
                <td> <?php echo $row['dest_name'] ?> </td>
                <td> <?php echo $row['dest_city'] ?> </td>
                <td> <?php echo $row['arrive_date'] ?> </td>
                <td> <?php echo $row['capacity'] ?> </td>
                <td> <?php echo $row['number_of_passengers'] ?> </td>
                <td>
                    <form method="post" action="index.php"> <button
                                onclick="return  confirm('Are You Sure You Want To Delete This Flight Y/N')"
                                class="btn btn-warning" type="submit" name="CancelFlight">Cancel
                            Flight</button> <input type="hidden" name="flightresId" value="<?php echo $row['fr_id']; ?>">
                    </form>
                </td>

            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

</body>

</html>