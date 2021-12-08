<?php
include("../config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $pass = $_POST['password'];
    $passwordHash = hash('sha256', $pass);

    $sql = "SELECT * FROM tour_guide WHERE email = '$email' AND password_hash = '$passwordHash' ";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($row === null) {
        echo '<script>alert("This user does not exist, please check Email and Password"); </script>';
    } else {
        $count = mysqli_num_rows($result);

        if ($count == 1) {
            $_SESSION['id'] = $row['tg_id'];
            $_SESSION['type'] = "tour_guide";
            header("location: ../Dashboard/dashboardT.php");
        }
    }
}
?>

<html>

<head>
    <link rel="stylesheet" href="../Styles/loginStyles.php" media="screen">
</head>
<form name="loginformT" action="" method="post">
    <h1 class="a11y-hidden">Login Form</h1>
    <h2>Tour Guide Login</h2>
    <div>
        <label class="label-email">
            <input type="email" id="userEmail" class="text" name="email" placeholder="Email" tabindex="1" required />
            <span class="required">Email</span>
        </label>
    </div>
    <div>
        <label class="label-password">
            <input type="text" id="userPass" class="text" name="password" placeholder="Password" tabindex="2"
                required />
            <span class="required">Password</span>
        </label>
    </div>
    <input type="submit" value="Log In" />
    <div class="email">
        <a href="../Register/registerC.php">Not a user? Sign up</a>
    </div>
    <div class="email">
        <a href="../Login/loginC.php">Are you a Customer? Sign in here</a>
    </div>
    <div class="email">
        <a href="../Login/loginE.php">Are you an Employee? Sign in here</a>
    </div>
    <figure aria-hidden="true">
        <div class="person-body"></div>
        <div class="neck skin"></div>
        <div class="head skin">
            <div class="eyes"></div>
            <div class="mouth"></div>
        </div>
        <div class="hair"></div>
        <div class="ears"></div>
        <div class="shirt-1"></div>
        <div class="shirt-2"></div>
    </figure>
</form>

</html>