<?php
include("../session.php");
$cid = $_SESSION['id'];

if (isset($_POST['TourDetails'])) {
    $tsId = $_POST['tsId'];
    header("location: tourDetails.php?tsId=$tsId");
}
if (isset($_POST['TGProfile'])) {
    $tgId = $_POST['tgId'];
    header("location: profile.php?tgId=$tgId");
}
if (isset($_POST['RateTour'])) {
    $tsId = $_POST['tsId'];
    $resId = $_POST['resId'];
    header("location: customerRating.php?tsId=$tsId&resId=$resId");
}

$sql = "SELECT reservation.res_id, tour.type, tour_section.start_date, tour_section.end_date, tour_guide.name, tour_guide.lastname, tour_guide.tg_id, tour_section.ts_id, reservation.isRated
FROM reservation, tour_section, guides, tour_guide, tour
WHERE tour.t_id = tour_section.t_id 
AND reservation.ts_id = tour_section.ts_id 
AND guides.tg_id = tour_guide.tg_id 
AND guides.ts_id = tour_section.ts_id 
AND guides.status = 'approved'
AND reservation.status = 'approved' 
AND tour_section.end_date < NOW()
AND reservation.c_id = $cid ";

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
        <a href="reserveFlight.php">Reserve a Flight</a>
        <a class="nav-link active" href="pastTours.php">Past Tours</a>
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
            <th scope="col">Tour Name</th>
            <th scope="col">Start Date</th>
            <th scope="col">End Date</th>
            <th scope="col">Tour Guide Name</th>
            <th scope="col">Options</th>
        </tr>
        </thead>
        <tbody>
        <h3> Your Past Tours </h3>
        <?php while ($row = $resultTour->fetch_assoc()) : ?>
            <tr id=<?php $row['res_id'] ?>>
                <td> <?php echo $row['type'] ?> </td>
                <td> <?php echo $row['start_date'] ?> </td>
                <td> <?php echo $row['end_date'] ?> </td>
                <td> <?php echo $row['name'] . " " . $row['lastname'] ?> </td>
                <td>
                    <form method="post" action="pastTours.php"> <button class="btn btn-primary" type="submit" name="TGProfile">Tour Guide Profile</button>
                        <button class="btn btn-primary" type="submit" name="TourDetails">Details</button>
                        <?php if ($row['isRated'] == 'no')
                        {
                            echo '<button class="btn btn-primary" type="submit" name="RateTour">Rate</button>';
                        }
                        ?>
                        <input type="hidden" name="resId" value="<?php echo $row['res_id']; ?>">
                        <input type="hidden" name="tgId" value="<?php echo $row['tg_id']; ?>">
                        <input type="hidden" name="tsId" value="<?php echo $row['ts_id']; ?>">
                    </form>
                </td>

            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>



</body>

</html>