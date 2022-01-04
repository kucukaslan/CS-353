<?php
include("../session.php");
require_once(getRootDirectory()."/employee/navbar.php");


$sql = "SELECT tour.type, tour_section.start_date, tour_section.end_date, tour_guide.name,tour_section.ts_id
FROM guides, tour_section, tour_guide, thecustomer,tour, reservation
WHERE guides.ts_id = tour_section.ts_id
AND   guides.tg_id = tour_guide.tg_id
AND   tour.t_id = tour_section.t_id
AND   tour_section.start_date > Now()
AND   thecustomer.c_id = reservation.c_id
AND   reservation.ts_id = tour_section.ts_id
AND   guides.status = 'pending'";
$resultPendingTours = $db->query($sql);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tours And Guides</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../styles/navbar.php">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>


    <?php

    // print table of tours without guides
    // add buttons to open details page
    // $result is the array of arrays with the keys "type", "start_date", "end_date", "name", "ts_id"

    $sql = "SELECT subquery.ts_id, tour.t_id, tour.place, tour.type, tour_section.start_date, tour_section.end_date
    FROM tour, tour_section, (SELECT tour_section.ts_id, tour_section.t_id 
    FROM tour_section
    WHERE tour_section.ts_id  NOT IN (
        SELECT tour_section.ts_id 
        FROM tour_section, guides 
        WHERE tour_section.ts_id = guides.ts_id AND
        (guides.status = 'approved' OR guides.status = 'pending')
    )) AS subquery
    WHERE tour.t_id = subquery.t_id AND
    tour_section.ts_id = subquery.ts_id";
    $result = $db->query($sql);

    echo '<div class="container">';
    echo '<h2>Tours without guides</h2>';

    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Tour Name</th>';
    echo '<th>Start Date</th>';
    echo '<th>End Date</th>';
  //  echo '<th>Tour Guide</th>';
    echo '<th>Details</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['type'] . '</td>';
        echo '<td>' . $row['start_date'] . '</td>';
       echo '<td>' . $row['end_date'] . '</td>';
      //  echo '<td>' . $row['name'] . '</td>';
        echo '<td>';
        echo '<form action="../employee/details.php" method="post">';
        echo '<input type="hidden" name="ts_id" value="' . $row['ts_id'] . '">';
        echo '<input type="submit" class="btn btn-primary" value="Details">';
        echo '</form>';
        echo '</td>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    
    ?>


    <br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Tour Name</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Tour Guide Name</th>
            </tr>
        </thead>
        <tbody>
            <h3> Pending tours </h3>
            <?php while ($row = $resultPendingTours->fetch_assoc()) : ?>
            <tr id=<?php $row['ts_id'] ?>>
                <td> <?php echo $row['type'] ?> </td>
                <td> <?php echo $row['start_date'] ?> </td>
                <td> <?php echo $row['end_date'] ?> </td>
                <td> <?php echo $row['name']  ?> </td>
                <td>
                    <form method="post" action="details.php">
                        <button class="btn btn-primary" type="submit" name="ResDetails">Details</button>
                        <input type="hidden" name="ts_id" value="<?php echo  $row['ts_id'] ?>">
                    </form>
                </td>

            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <hr class="rounded">
</body>

</html>