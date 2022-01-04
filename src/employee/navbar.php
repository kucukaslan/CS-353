<?php
 // ideally we should have replaced this with a
//require_once ('../util/navbar.php')
// echo getEmployeeNavBar("");
?>
<div style="border: 2px solid red; border-radius: 5px;" class="pill-nav">

        <a href=index.php>Dashboard</a>
        <a href=pendingTours.php>Tours And Guides</a>
        <a href=createNewTour.php>Create New Tour</a>
        <a href=registerHotel.php>Register Hotel</a>
        <a href=registerRoom.php>Register Room</a>
        <a href=makeHotelReservation.php>Make a Hotel Reservation</a>
        <a href=pendingHotelReservations.php>Pending Hotel Reservations</a>
        <a href=waitingTourReservations.php>Pending Tour reservations</a>     
        <a href=makeTourReservationForCustomer.php>Make Tour Reservation</a>
        <a href=registerExtraActivityForReservation.php>Extra activity to a Reservation</a>
        <a href=profile.php>Profile</a>
        <form action="../logout.php">
            <input type="submit" name="logout" class="btn btn-danger" value="Logout" />
        </form>
</div>