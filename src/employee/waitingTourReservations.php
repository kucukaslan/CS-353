<?php
include("../session.php");
require_once(getRootDirectory()."/employee/navbar.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    if (isset($_POST['accept']))
    {
        
        $res_id = $_POST['accept'];
        $sql = "UPDATE reservation SET status = 'approved' WHERE res_id = $res_id";
        $result = $db->query($sql);
    }
    else if (isset($_POST['decline']))
    {
        $res_id = $_POST['decline'];
        $sql = "UPDATE reservation SET status = 'rejected' WHERE res_id = $res_id";
        $result = $db->query($sql);

        $reason = $_POST['reason'];
        $sql = "UPDATE reservation SET reason = '$reason' WHERE res_id = $res_id";
        $result = $db->query($sql);

    }
    header("Refresh:0");
}


$sql = "SELECT tour.t_id, tour_section.ts_id, tour.type, thecustomer.c_id, thecustomer.name, reservation.number, reservation.res_id
FROM tour, tour_section, reservation, thecustomer
WHERE
tour_section.t_id = tour.t_id AND
tour_section.ts_id = reservation.ts_id AND
start_date > NOW() AND
thecustomer.c_id = reservation.c_id AND
status = 'pending'
";
$resultWaitingTourReservations = $db->query($sql);

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <title>waiting tour reservations</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../styles/navbar.php">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <?php
        //echo getCustomerNav("./");
    ?>
    <br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">tour id</th>
                <th scope="col">tour section id</th>
                <th scope="col">tour type</th>
                <th scope="col">thecustomer id</th>
                <th scope="col">thecustomer name</th>
                <th scope="col">reservation number</th>
            </tr>
        </thead>
        <tbody>
            <h3> waiting tour reservation </h3>
            <?php while ($row = $resultWaitingTourReservations->fetch_assoc()) : ?>
            <tr id=<?php $row['ts_id'] ?>>
                <td> <?php echo $row['t_id'] ?> </td>
                <td> <?php echo $row['ts_id'] ?> </td>
                <td> <?php echo $row['type'] ?> </td>
                <td> <?php echo $row['c_id']  ?> </td>
                <td> <?php echo $row['name']  ?> </td>
                <td> <?php echo $row['number']  ?> </td>
                
                <td><form action="" method="post" id="form1">
                    <button class="btn btn-primary" type="submit" name="accept">accept</button>                    
                    <input type="hidden" name="accept" value= "<?php echo $row['res_id']; ?>">
                    </form></td>

                <td> <form action="" method="post" id="form1">
                    <button class="btn btn-primary" type="submit" name="decline">decline</button>                    
                    <input type="hidden" name="decline" value= "<?php echo $row['res_id']; ?>">

                    <label for="fname">reason</label>
                    <input type="text" id="reason" name="reason" placeholder="reason.." required="true">
                    
                    </form></td>

                <td><form action="" method="post" id="form1">
                    <button class="btn btn-primary" type="submit" name="ResDetails">details</button>                    
                    <input type="hidden" name="ts_id" value="">
                    </form></td>

                   
                    
                
                
                   
                    
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <hr class="rounded">
</body>

</html>