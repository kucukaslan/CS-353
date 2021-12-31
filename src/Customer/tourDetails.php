<?php
include("../session.php");
require_once(getRootDirectory()."/util/navbar.php");
$cid = $_SESSION['id'];

$tsId = $_GET['tsId'];

$sql = "SELECT activity.a_id, activity.name, activity.location, activity.date, activity.start_time, activity.end_time, tour_activity.type
FROM tour_activity, activity, tour_section 
WHERE tour_activity.a_id = activity.a_id
AND tour_section.ts_id = $tsId
AND tour_section.ts_id = tour_activity.ts_id
ORDER BY type DESC";
$resultActivities = $db -> query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reservation Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
<?php
echo getCustomerNav("./");
?>
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
    </tr>
    </thead>
    <tbody>

    <?php while($row = $resultActivities->fetch_assoc()) : ?>
        <tr id=<?php $row['a_id']?>>
            <td> <?php echo $row['name'] ?> </td>
            <td> <?php echo $row['location'] ?> </td>
            <td> <?php echo $row['date'] ?> </td>
            <td> <?php echo $row['start_time']. " - " . $row['end_time'] ?> </td>
            <td> <?php echo $row['type'] ?> </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
</body>

</html>