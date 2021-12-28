<?php
include("../session.php");
$cid = $_SESSION['id'];

if (isset($_POST['bookbutton'])) {
    $fid = $_POST['fid'];
    $numofpass = $_POST['numofpass'];
    $date = $_POST['date'];

    $sql = "INSERT INTO flight_reservation (f_id, c_id, number_of_passengers, date) VALUES ($fid, $cid, $numofpass, '$date') ";
    $db->query($sql);
}


$sql = "SELECT flight.f_id, flight.ticket_price, dept.city as dept_city, dept.name as dept_name, dest.city as dest_city, dest.name as dest_name, flight.dest_airport, flight.dept_date, flight.arrive_date, flight.capacity
FROM flight, airport as dept, airport as dest
WHERE flight.dept_airport = dept.airport_code
AND flight.dest_airport = dest.airport_code
;";

$resultTour = $db -> query($sql);
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
    <a class="nav-link active" href="reserveFlight.php">Reserve a Flight</a>
    <a href="pastTours.php">Past Tours</a>
    <a href="bookTour.php">Book a Tour</a>
    <a href="reserveHotel.php">Reserve a Hotel</a>
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
        <th scope="col">Flight Number</th>
        <th scope="col">Depart Airport</th>
        <th scope="col">Depart Location</th>
        <th scope="col">Departs on</th>
        <th scope="col">Arrival Airport</th>
        <th scope="col">Arrival Location</th>
        <th scope="col">Arrives on</th>
        <th scope="col">Price Per Person</th>
        <th scope="col">Capacity</th>
        <th scope="col">Number of Passengers</th>
        <th scope="col">Options</th>
    </tr>
    </thead>
    <tbody>
    <h3> Available Flights </h3>
    <?php while ($row = $resultTour->fetch_assoc()) : ?>
        <tr id=<?php $row['f_id'] ?>>
            <td> <?php echo $row['f_id'] ?> </td>
            <td> <?php echo $row['dept_name'] ?> </td>
            <td> <?php echo $row['dept_city'] ?> </td>
            <td> <?php echo $row['dept_date'] ?> </td>
            <td> <?php echo $row['dest_name'] ?> </td>
            <td> <?php echo $row['dest_city'] ?> </td>
            <td> <?php echo $row['arrive_date'] ?> </td>
            <td> <?php echo $row['ticket_price'] ?> </td>
            <td> <?php echo $row['capacity'] ?> </td>
            <form method="post" action="reserveFlight.php">
                <td>
                    <input type="text" id="numofpass" name="numofpass">
                </td>
                <td>
                    <button onclick="return  confirm('Are You Sure You Want To Reserve This Flight Y/N')"
                            class="btn btn-primary" type="submit" name="bookbutton">Book This Flight</button>

                    <input type="hidden" name="fid" value="<?php echo $row['f_id']; ?>">
                    <input type="hidden" name="date" value="<?php echo $row['dept_date']; ?>">
                </td>
            </form>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>



</body>

</html>