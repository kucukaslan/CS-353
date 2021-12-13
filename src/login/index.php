<?php
include("../config.php");
session_start();

if( isset($_SESSION['id'])){
    if( strcmp("tour_guide", $_SESSION['type'] ?? "none") == 0) {
        header("Location: ../guide");
    }
    else if( strcmp("employee", $_SESSION['type'] ?? "none") == 0) {
        header("Location: ../employee");
    }
    // TODO IT is up to you, Ahmad and Guven, to update or not to update the redirection
    /*
    else if( strcmp("thecustomer", $_SESSION['type'] ?? "none") == 0) {
        header("Location: ../customer/dashboardC");
    }
    */
    // else continue (do nothing)
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $pass = $_POST['password'];
    $passwordHash = hash('sha256', $pass);
    $userType = $_POST['users'];

    $sql = "SELECT * FROM $userType WHERE email = '$email' AND password_hash = '$passwordHash' ";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($row === null) {
        echo '<script>alert("This user does not exist, please check Email and Password"); </script>';
    } else {
        $count = mysqli_num_rows($result);

        if ($count == 1) {
            $_SESSION['name'] = $row['name'];
            $_SESSION['lastname'] = $row['lastname'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['birthday'] = $row['birthday'];
            if ($userType == 'thecustomer') 
            {
                $_SESSION['id'] = $row['c_id'];
                $_SESSION['type'] = "thecustomer";
                header("location: ../Customer/dashboardC.php");
            } else if ($userType == 'employee') 
            {
                $_SESSION['id'] = $row['e_id'];
                $_SESSION['type'] = "employee";
                header("location: ../dashboard/dashboardE.php");
            } else if ($userType == 'tour_guide') 
            {
                $_SESSION['id'] = $row['tg_id'];
                $_SESSION['type'] = "tour_guide";
                header("location: ../guide/");
            }
        }
    }
}
?>

<html>

<head>
    <link rel="stylesheet" href="../styles/loginstyles.php" media="screen">
</head>
<form name="loginform" action="" method="post">
    <h1 class="a11y-hidden">Login Form</h1>
    <h2>Login Form</h2>

    <label for="users">Login As:</label>
    <select name="users" id="users">
        <option value="thecustomer">Customer</option>
        <option value="employee">Employee</option>
        <option value="tour_guide">Tour Guide</option>
    </select>

    <div>
        <label class="label-email">
            <input type="email" id="userEmail" class="text" name="email" placeholder="Email" tabindex="1" required />
            <span class="required">Email</span>
        </label>
    </div>
    <div>
        <label class="label-password">
            <input type="password" id="userPass" class="text" name="password" placeholder="Password" tabindex="2"
                required />
            <span class="required">Password</span>
        </label>
    </div>
    <input type="submit" value="Log In" />
    <div class="email">
        <a href="../register/">Not a user? Sign up</a>
    </div>
</form>

</html>