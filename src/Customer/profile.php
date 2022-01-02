<?php
include("../session.php");
require_once(getRootDirectory() . "/util/navbar.php");
$cid = $_SESSION['id'];

$sql = "SELECT * FROM thecustomer WHERE c_id = $cid";
$userInfo = $db->query($sql);
$userInfo = $userInfo->fetch_assoc();

if (isset($_POST['addMoney'])) {
    $moneyAmount = $_POST['moneyAmount'];
    if ($moneyAmount < 0) {
        echo '<script>alert("Added Money cannot Be Negative")</script>';
    } else {
        $sql = "UPDATE thecustomer SET wallet=wallet + $moneyAmount WHERE c_id=$cid";
        $db->query($sql);
        header("Refresh:0");
    }
}

if (isset($_POST['changeEmail'])) {
    $newEmail = $_POST['email'];
    $sql = "UPDATE thecustomer SET email='$newEmail' WHERE c_id=$cid";
    $db->query($sql);
    echo '<script>alert("Email Updated Successfully")</script>';
    header("Refresh:0");
}

if (isset($_POST['changePassword'])) {
    $newPassword = $_POST['password'];
    $hashedPassword = hash('sha256', $newPassword);
    $sql = "UPDATE thecustomer SET password_hash='$hashedPassword' WHERE c_id=$cid";
    $db->query($sql);
    echo '<script>alert("Password Updated Successfully")</script>';
    header("Refresh:0");
}

// The following segment is to get the Tour Guide's information
if ($_GET['tgId'] ?? null)
{
    // Gets name, DOJ, and Profile Picture
    $tgId = $_GET['tgId'];
    $sql = "SELECT * FROM tour_guide WHERE tg_id = $tgId";
    $tgInfo = $db->query($sql);
    $tgInfo = $tgInfo->fetch_assoc();

    // Gets average rating
    $sql = "SELECT AVG(customer_review.guide_rate) AS avg, COUNT(customer_review.guide_rate) as cnt
    FROM customer_review, guides
    WHERE customer_review.ts_id = guides.ts_id
    AND guides.status = 'approved'
    AND guides.tg_id = $tgId";
    $avgRating = $db->query($sql);
    $avgRating = $avgRating->fetch_assoc();

    // Gets number of tours the Tour Guide has managed
    $sql = "SELECT COUNT(ts_id) AS cnt FROM guides
    WHERE guides.status = 'approved'
    AND tg_id = $tgId";
    $numOfTours = $db->query($sql);
    $numOfTours = $numOfTours->fetch_assoc();

    // Gets all the comments about the tour guide
    $sql = "SELECT customer_review.guide_comment AS cmnt, thecustomer.name, thecustomer.lastname
    FROM customer_review, guides, thecustomer
    WHERE customer_review.ts_id = guides.ts_id
    AND guides.status = 'approved'
    AND customer_review.c_id = thecustomer.c_id
    AND guides.tg_id = $tgId;";
    $comments = $db->query($sql);
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <?php
    echo getCustomerNav("./");
    ?>
    <!-- End of Navbar -->
    <?php if ($_GET['tgId'] ?? null): ?>
    <br>
    <br>
    <br>
    <div style="border: 2px solid red; border-radius: 5px;" class="container">
    <h3>Details of Tour Guide <b><?php echo $tgInfo['name']. " ". $tgInfo['lastname'] ?></b> </h3>
    <img src="data:image/jpeg;base64,<?php echo base64_encode($tgInfo['profile_picture']); ?>" width="100" class="rounded-circle">
        <p><b>Date of Joining:</b> <?php echo date("Y-m-d",strtotime($tgInfo['registration']));?> </p>
        <p><b>Average Rating:</b> <?php echo round($avgRating['avg'], 2). " / 5. Rated By " . $avgRating['cnt'] . " Person(s)"?></p>
        <p><b>Number of Tours Guided: </b> <?php echo $numOfTours['cnt']?></p>
        <p><b>Customer Comments:</b></p>
        <?php while ($row = $comments->fetch_assoc()) : ?>
        <ul>- <?php echo $row['cmnt']. "   -   " ?> <b><?php echo $row['name'] . " ". $row['lastname'] ?> </b></ul>
        <?php endwhile; ?>
    </div>
    <?php else: ?>
    <br>
    <br>
    <br>
    <br>
        <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-7">
                <div class="card p-3 py-4">
                    <div class="text-center"> <img src="data:image/jpeg;base64,<?php echo base64_encode($userInfo['profile_picture']); ?>" width="100" class="rounded-circle"> </div>

                    <h3>
                        <div class="text-center mt-3"> <span class="bg-secondary px-4 rounded text-white">Wallet:
                                <?php echo $userInfo['wallet'] ?>$</span>
                    </h3>
                    <h3>
                        <div class="text-center mt-3"> <span class="bg-secondary p-1 px-4 rounded text-white">Name:
                                <?php echo $userInfo['name'] . " " . $userInfo['lastname'] ?></span>
                    </h3>

                    <h4>
                        <div class="text-center mt-3"> <span class="bg-secondary p-1 px-4 rounded text-white">Email:
                                <?php echo $userInfo['email'] ?></span>
                    </h4>
                    <h4>
                        <div class="text-center mt-3"> <span class="bg-secondary p-1 px-4 rounded text-white">Birthday:
                                <?php echo $userInfo['birthday'] ?></span>
                    </h4>
                    <form method="post" action="profile.php">
                        <h4>
                            <div class="text-center mt-3"> <span class="bg-secondary p-1 px-4 rounded text-white"><input type="number" id="money" name="moneyAmount" placeholder="Enter Amount of Money" required /> <button type="submit" name="addMoney" class="btn btn-warning px-4">Add Money</button></span>
                        </h4>
                    </form>
                    <form method="post" action="profile.php">
                        <h4>
                            <div class="text-center mt-3"> <span class="bg-secondary p-1 px-4 rounded text-white"><input type="email" id="email" name="email" placeholder="Enter Your Email" required /> <button type="submit" name="changeEmail" class="btn btn-primary px-4">Update Email</button></span>
                        </h4>
                    </form>
                    <form method="post" action="profile.php">
                        <h4>
                            <div class="text-center mt-3"> <span class="bg-secondary p-1 px-4 rounded text-white"><input type="password" id="password" name="password" placeholder="Enter Your Password" required /> <button type="submit" name="changePassword" class="btn btn-info px-4">Update
                                        Password</button></span>
                        </h4>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif ?>
</body>

</html>

<style>
    body {
        background: #eee;
        border-style: solid;
        border: #8E24AA;
    }

    .card {
        border: #8E24AA;
        border-style: solid;
        border-width: thin;
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        cursor: pointer
    }

    .card:before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background-color: #E1BEE7;
        transform: scaleY(1);
        transition: all 0.5s;
        transform-origin: bottom
    }

    .card:after {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background-color: #8E24AA;
        transform: scaleY(0);
        transition: all 0.5s;
        transform-origin: bottom
    }

    .card:hover::after {
        transform: scaleY(1)
    }

    .fonts {
        font-size: 11px
    }

    .social-list {
        display: flex;
        list-style: none;
        justify-content: center;
        padding: 0
    }

    .social-list li {
        padding: 10px;
        color: #8E24AA;
        font-size: 19px
    }

    .buttons button:nth-child(1) {
        border: 1px solid #8E24AA !important;
        color: #8E24AA;
        height: 40px
    }

    .buttons button:nth-child(1):hover {
        border: 1px solid #8E24AA !important;
        color: #fff;
        height: 40px;
        background-color: #8E24AA
    }

    .buttons button:nth-child(2) {
        border: 1px solid #8E24AA !important;
        background-color: #8E24AA;
        color: #fff;
        height: 40px
    }
</style>