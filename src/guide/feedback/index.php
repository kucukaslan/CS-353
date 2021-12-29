<?php
require_once(__DIR__."/../../session.php");
require_once("../../config.php");
require_once(getRootDirectory()."/util/navbar.php");
require_once(getRootDirectory()."/util/TourSection.php");

if(!isset($_SESSION['id']) || strcmp("tour_guide", $_SESSION['type'] ?  $_SESSION['type'] : "none") != 0) {
    header("location: ".getRootDirectory());
}
$tg_id = $_SESSION['id'];
$ts_id = $_SESSION['ts_id'];

 ?> 


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Feedback</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../../styles/navbar.php">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <!-- Beginning of Navbar -->
    <?php
        echo getGuideNavBar("../");
    ?>
    <!-- End of Navbar -->
    <!-- First four lines are invisible they're behind the navbar!-->
    <h2> Give Feedback</h2>
    <div class="container">
        <?php
        $tour = TourSection::makeTourSection(getDatabaseConnection(), $ts_id);
        //echo $_SERVER['REQUEST_METHOD'];

        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['comment'])) {
            $comment = $_POST['comment'];
            $ts_id = $_POST['ts_id'];
            $tg_id = $_POST['tg_id'];

            $sql = "INSERT INTO tour_guide_review (tour_comment, ts_id, tg_id) VALUES ('$comment', '".$tour->getTsId()."', '$tg_id')
                on duplicate key update tour_comment = '$comment'";
            $result = getDatabaseConnection()->query($sql);
            if($result) {
                echo "<div class='alert alert-success'>
                    <strong>Success!</strong> Your feedback has been submitted.
                </div>";
                echo $tour->getName() . " " . $tour->getStartDate()->format("D, F d, Y");
                echo "<br> Comment: " . $comment;
                echo "<br><a href='../' class='btn btn-primary'>Go Back</a>";
            } else {
                echo "<div class='alert alert-danger'>
                    <strong>Error!</strong> Your feedback could not be submitted.
                </div>";
            }
        }
        else {
            echo '<form action="" method="post">
                <input type="number" hidden="true"  id="tg_id" name="tg_id" value="' . $tg_id.'">
            <div class="form-group">
                <label for="ts_id">Tour:';

            echo $tour->getName() . " " . $tour->getStartDate()->format("D, F d, Y");
            echo '</label>
                    <input type="number" hidden="true" id="ts_id" name="ts_id" value="' . $ts_id . '" >
                </div>
                <div class="form-group">
                    <label for="comment">Comment:</label>
                    <textarea class="form-control" rows="5" id="comment" name="comment" required="true"></textarea>
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
                </form>';
        }
        ?>
    </div>
</body>

</html>