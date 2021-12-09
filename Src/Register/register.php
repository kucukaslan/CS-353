<?php
include("../config.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $birthDate = $_POST['date'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $userType = $_POST['users'];

    $passwordHash = hash('sha256', $pass);

    if ($userType == 'thecustomer') 
    {
        $sql = "INSERT INTO $userType (name, lastname, email, password_hash, birthday, profile_picture) VALUES ('$name', '$surname', '$email', '$passwordHash', '$birthDate', null)";
    } 
    else if ($userType == 'employee') 
    {
        $sql = "INSERT INTO $userType (name, lastname, email, password_hash, birthday, salary, position) VALUES ('$name', '$surname', '$email', '$passwordHash', '$birthDate', null, null)";
    } 
    else if ($userType == 'tour_guide') 
    {
        $sql = "INSERT INTO $userType (name, lastname, email, password_hash, birthday, profile_picture) VALUES ('$name', '$surname', '$email', '$passwordHash', '$birthDate', null)";
    }

    if (!mysqli_query($db, $sql)) {
        echo '<script>alert("An Error Occured, Account already exists"); </script>';
    } else {
        header("location: ../Login/login.php");
    }
}
?>

<html>

<head>
    <link rel="stylesheet" href="../Styles/loginStyles.php" media="screen">
</head>

<form name="registerform" action="" method="post">
    <h2>Sign Up Form</h2>

    <label for="users">Sign Up As:</label>
    <select name="users" id="users">
        <option value="thecustomer">Customer</option>
        <option value="employee">Employee</option>
        <option value="tour_guide">Tour Guide</option>
    </select>

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
        <a href="../login/login.php">Already registered? Sign in</a>
    </div>
</form>

</html>