<?php
include("../session.php");
require_once(getRootDirectory()."/employee/navbar.php");
$eid = $_SESSION['id'];

$sql = "SELECT tour.type, tour.t_id, tour_section.ts_id, tour_section.start_date, tour_section.end_date, tour_guide.name, tour_guide.lastname
FROM tour, tour_section, guides, tour_guide
WHERE tour_section.start_date > NOW()
AND guides.tg_id = tour_guide.tg_id 

AND guides.ts_id = tour_section.ts_id

AND tour.t_id = tour_section.t_id
AND guides.ts_id = tour_section.ts_id";

$resultIncomingTours = $db->query($sql);
/*
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
*/

$sql = "SELECT hotel.name, booking.start_date, booking.end_date, room.r_id, b_id, room.type
FROM booking, room, hotel
WHERE room.r_id = booking.r_id
AND   hotel.h_id = room.h_id";

$resultAvailableHotels = $db->query($sql);

/*
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
*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Employee Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../styles/navbar.php">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script></head>

<body>
    <?php
        //echo getGuideNavBar("./");
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
            <h3> Incoming Tours </h3>
            <?php while ($row = $resultIncomingTours->fetch_assoc()) : ?>
            <tr id=<?php $row['ts_id'] ?>>
                <td> <?php echo $row['type'] ?> </td>
                <td> <?php echo $row['start_date'] ?> </td>
                <td> <?php echo $row['end_date'] ?> </td>
                <td> <?php echo $row['name'] . " " . $row['lastname'] ?> </td>
                <td>
                    <form method="post" action="details/index.php">
                        <button class="btn btn-primary" type="submit" name="ResDetails">Details</button>
                        <input type="hidden" name="ts_id" value="<?php echo $row['ts_id']; ?>">
                    </form>
                    <?php echo $row['ts_id']; ?>
                    
                    <form action="createNewExtraActivity.php" method="post" id="form1">
                    <button class="btn btn-primary" type="submit" name="ResDetails">Add Activity</button>                    
                    <input type="hidden" name="ts_id" value="<?php echo $row['ts_id']; ?>">
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
            <h3> Available Hotels </h3>
            <?php while ($row = $resultAvailableHotels->fetch_assoc()) : ?>
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
</body>

</html>
