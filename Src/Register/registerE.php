<?php
include("../config.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $birthDate = $_POST['date'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $passwordHash = hash('sha256', $pass);

    $sql = "INSERT INTO employee (name, lastname, email, password_hash, birthday, salary, position) VALUES ('$name', '$surname', '$email', '$passwordHash', '$birthDate', null, null)";
    if (!mysqli_query($db, $sql)) {
        echo '<script>alert("An Error Occured, Account already exists"); </script>';
    } else {
        header("location: ../Login/loginE.php");
    }
}
?>

<html>

<head>
    <link rel="stylesheet" href="../Styles/loginStyles.php" media="screen">
</head>

<form name="registerformE" action="" method="post">
    <h1 class="a11y-hidden">Sign up Form</h1>
    <h2>Employee Sign Up</h2>
    <div>
        <label class="label-name">
            <input type="text" id="name" class="text" name="name" placeholder="Name" tabindex="2" required />
            <span class="required">Name</span>
        </label>
    </div>
    <div>
        <label class="label-surname">
            <input type="text" id="surname" class="text" name="surname" placeholder="Surname" tabindex="2" required />
            <span class="required">Surname</span>
        </label>
    </div>
    <div>
        <label class="label-email">
            <input type="email" id="userEmail" class="text" name="email" placeholder="Email" tabindex="2" required />
            <span class="required">Email</span>
        </label>
    </div>
    <div>
        <label class="label-password">
            <input type="password" id="userPass" class="text" name="password" placeholder="Password" tabindex="2" required />
            <span class="required">Password</span>
        </label>
    </div>
    <div>
        <label class="label-date">
            <input type="date" id="date" class="text" name="date" placeholder="Birthday" tabindex="2" required />
            <span class="required">Birthday</span>
        </label>
    </div>


    <input type="submit" value="Sign up" />
    <div class="email">
        <a href="../login/loginC.php">Already registered? Sign in</a>

    </div>
    <div class="email">
        <a href="../Register/registerC.php">Want to be a Customer? Sign up here</a>
    </div>
    <div class="email">
        <a href="../Register/registerT.php">Want to be a Tour Guide? Sign up here</a>
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