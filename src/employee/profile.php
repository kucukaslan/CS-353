<?php
include("../session.php");
require_once(getRootDirectory()."/employee/navbar.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    if (isset($_POST['email'])) 
    {
        $email = $_POST['email'];
        $id = $_SESSION['id'];
        $sql = "UPDATE employee 
                SET email = '$email' 
                WHERE e_id = $id";
    $result = $db->query($sql);
    
    }
    else if (isset($_POST['old_password']))
    {
        $id = $_SESSION['id'];
        $sql = "SELECT password_hash 
                FROM employee 
                WHERE employee.e_id = $id ";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $passwordHash_old_from_database = $row['password_hash'];




        $old_password = $_POST['old_password'];
        $new_password1 = $_POST['new_password1'];
        $new_password2 = $_POST['new_password2'];
        $passwordHash_old = hash('sha256', $old_password);
        $passwordHash_new = hash('sha256', $new_password1);


        if ( $new_password1 != $new_password2)
        {
            echo "new password and confirmed password do not match";
        }
        else if ($passwordHash_old != $passwordHash_old_from_database)
        {
            echo "old password entered wrong";
        }
        else
        {
            $sql = "UPDATE employee 
                SET password_hash = '$passwordHash_new' 
                WHERE e_id = $id";
            $result = $db->query($sql);
        }
    }


}


?>




<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../styles/navbar.php">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
</style>
<body>

<h3>Create a Tour <?php  $x ?> </h3>

<div>
  <form name="form" action="" method="post">
    <label for="fname">email</label>
    <input type="text" id="email" name="email" placeholder="Your name.." required="true">
    <input type="submit" value="update email">
   </form>
    
   <form name="form" action="" method="post">
    <label for="fname">old password</label>
    <input type="text" id="old_password" name="old_password" placeholder="Your name.." required="true">

    <label for="fname">new password</label>
    <input type="text" id="new_password1" name="new_password1" placeholder="Your name.." required="true">

    
   
    <label for="fname">confirm new password</label>
    <input type="text" id="new_password2" name="new_password2" placeholder="Your name.." required="true">
    <input type="submit" value="Submit">

   </form>

   
    

    
  
</div>


</body>
</html>
