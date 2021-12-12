<?php
include("../session.php");
$cid = $_SESSION['id'];


$resId = $_GET['resId'];
$sql = "SELECT activity.a_id, activity.name, activity.location, activity.date, activity.start_time, activity.end_time, activity.type FROM reservation_activity, activity
WHERE reservation_activity.a_id = activity.a_id AND
res_id = $resId AND activity.type = 'basic'";
$resultBasic = $db -> query($sql);

$sql = "SELECT activity.a_id, activity.name, activity.location, activity.date, activity.start_time, activity.end_time, activity.type FROM reservation_activity, activity
WHERE reservation_activity.a_id = activity.a_id AND
res_id = $resId AND activity.type = 'extra'";
$resultExtra = $db -> query($sql);

// echo "<h1>Welcome to Reservation Details with ID of $resId</h1>";
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
        <a href="../customer">Home</a>
        <a href="CS-353/src/Customer/dashboardC.php">News</a>
        <a href="#contact">Contact</a>
        <a href="#about">About</a>
        <form action="../logout.php">
            <input type="submit" name="logout" class="btn btn-danger" value="Logout" />
        </form>
    </div>
    <br>
    <h3>The Activities For Current Tour</h3>
    <table class="table">
        <thead>

            <tr>
                <th scope="col">Activity Name</th>
                <th scope="col">Location</th>
                <th scope="col">Date</th>
                <th scope="col">Time</th>
                <th scope="col">Type</th>
                <th scope="col">Options</th>
            </tr>
        </thead>
        <tbody>

            <?php while($row = $resultExtra->fetch_assoc()) : ?>
            <tr id=<?php $row['a_id']?>>
                <td> <?php echo $row['name'] ?> </td>
                <td> <?php echo $row['location'] ?> </td>
                <td> <?php echo $row['date'] ?> </td>
                <td> <?php echo $row['start_time']. " - " . $row['end_time'] ?> </td>
                <td> <?php echo $row['type'] ?> </td>
                <td>
                    <form method="post" action="index.php"> <button class="btn btn-warning" type="submit" name="ResDetails">Cancel Extra
                            Event</button> <input type="hidden" name="details" value="<?php echo $row['a_id']; ?>">
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>

            <?php while($row = $resultBasic->fetch_assoc()) : ?>
            <tr id=<?php $row['a_id']?>>
                <td> <?php echo $row['name'] ?> </td>
                <td> <?php echo $row['location'] ?> </td>
                <td> <?php echo $row['date'] ?> </td>
                <td> <?php echo $row['start_time']. " - " . $row['end_time'] ?> </td>
                <td> <?php echo $row['type'] ?> </td>
                <td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>

</html>