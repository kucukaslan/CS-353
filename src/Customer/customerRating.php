<?php
include("../session.php");
$cid = $_SESSION['id'];
$resId = $_GET['resId'];
//echo $cid;
//echo $tsId;

if (isset($_POST['submitrate'])) {
    //$resId2 = $_POST['resId'];
    $tourrating = $_POST['tourrating'];
    $tgrating = $_POST['tgrating'];
    $tourcommentarea = $_POST['tourcommentarea'];
    $tgreviewarea = $_POST['tgreviewarea'];
    $tsId = $_POST['tsId'];

    $sql = "INSERT INTO customer_review (tour_rate, tour_comment, guide_rate, guide_comment, c_id, ts_id) VALUES ($tourrating, '$tourcommentarea', $tgrating, '$tgreviewarea', $cid, $tsId) ";
    $db->query($sql);

    header("location: pastTours.php?tsId=$tsId&resId=$resId");
}

$sql = "SELECT reservation.res_id, tour.type, tour_section.start_date, tour_section.end_date, tour_guide.name, tour_guide.lastname, tour_guide.tg_id, tour_section.ts_id
FROM reservation, tour_section, guides, tour_guide, tour
WHERE tour.t_id = tour_section.t_id 
AND reservation.ts_id = tour_section.ts_id 
AND guides.tg_id = tour_guide.tg_id 
AND guides.ts_id = tour_section.ts_id 
AND reservation.status = 'approved' 
AND tour_section.end_date < NOW()
AND reservation.c_id = $cid
AND reservation.res_id = $resId ";

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
    <?php while ($row = $resultTour->fetch_assoc()) : ?>
        <h3>You Are Rating Tour <u><?php echo $row['type']; ?></u> , with Tour Guide <u><?php echo $row['name']; ?> <?php echo $row['lastname']; ?></u> </h3>
        <br>
        <form method="post" action="customerRating.php">
            <div>
                <label>Tour Rating:</label>
                <select name="tourrating" id="tourrating">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <br>
            <div>
                <label>Tour Guide Rating: </label>
                <select name="tgrating" id="tgrating">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <br>

            <div>
                <label>Tour Comment: </label>
                <br>
                <textarea id="tourcommentarea" name="tourcommentarea" rows="4" cols="50"></textarea>
            </div>
            <br>
            <div>
                <label>Tour Guide review: </label>
                <br>
                <textarea id="tgreviewarea" name="tgreviewarea" rows="4" cols="50"></textarea>
            </div>
            <br>

            <button class="btn btn-primary" type="submit" name="submitrate">Submit</button>
            <input type="hidden" name="resId" value="<?php echo $row['res_id']; ?>">
            <input type="hidden" name="tgId" value="<?php echo $row['tg_id']; ?>">
            <input type="hidden" name="tsId" value="<?php echo $row['ts_id']; ?>">
        </form>

    <?php endwhile; ?>
</body>

</html>
