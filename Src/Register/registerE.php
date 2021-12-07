<?php
?>

<html>

<head>
    <link rel="stylesheet" href="../Styles/loginStyles.php" media="screen">
</head>

<form name="loginform" action="" method="post">
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
        <label class="label-phone">
            <input type="tel" id="phone" class="text" name="phone" placeholder="Phone Number" tabindex="2" required />
            <span class="required">Phone Number</span>
        </label>
    </div>
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