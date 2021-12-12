<?php
include("../session.php");
$cid = $_SESSION['id'];

$sql = "SELECT reservation.res_id, tour.type, tour_section.start_date, tour_section.end_date, tour_guide.name, tour_guide.lastname FROM tour_section, reservation, guides, tour, tour_guide WHERE tour.t_id = tour_section.t_id AND reservation.ts_id = tour_section.ts_id AND guides.tg_id = tour_guide.tg_id AND guides.ts_id = tour_section.ts_id AND reservation.status = 'approved' AND reservation.c_id = $cid ";
$result = $db -> query($sql);

if(isset($_POST['ResDetails']))
{
    $resId = $_POST['details'];
    echo "<h1>Reservation Details</h1>";
    // echo "location: reservationDetails.php?resId=$resId";
    header("location: reservationDetails.php?resId=$resId");
}

if(isset($_POST['CancelRes']))
{   
    echo "<h1>Cancel Reservation</h1>";
    echo $_POST['cancelRes'];
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
    <div class="pill-nav">
        <a href="./dashboardC.php">Home</a>
        <a href="CS-353/src/Customer/dashboardC.php">News</a>
        <a href="#contact">Contact</a>
        <a href="#about">About</a>
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
            </tr>
        </thead>
        <tbody>

            <?php while($row = $result->fetch_assoc()) : ?>
            <tr id=<?php $row['res_id']?>>
                <td> <?php echo $row['type'] ?> </td>
                <td> <?php echo $row['start_date'] ?> </td>
                <td> <?php echo $row['end_date'] ?> </td>
                <td> <?php echo $row['name'] . " " . $row['lastname'] ?> </td>
                <td>
                    <form method="post" action="dashboardC.php"> <button type="submit"
                            name="ResDetails">Details</button> <input type="hidden" name="details"
                            value="<?php echo $row['res_id']; ?>"> </form>
                </td>
                <td>
                    <form method="post" action="dashboardC.php"> <button type="submit" name="CancelRes">Cancel
                            Reservation</button> <input type="hidden" name="cancelRes"
                            value="<?php echo $row['res_id']; ?>"> </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>

</html>