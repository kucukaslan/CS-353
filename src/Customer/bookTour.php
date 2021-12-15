<?php
include("../session.php");
require_once(getRootDirectory()."/util/navbar.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Book Tour</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <?php
        echo getCustomerNav("./");
    ?>
    <h1>welcome to Book a Tour</h1>
</body>

</html>