<?php   
include_once "includes/config-session.php";
include_once "includes/signup-view.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<!-- Create a login system example with PHP and MySQL -->
<body>
    <h3>Login</h3>

    <form action="includes/login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" placeholder="username">
        <label for="password">Password:</label>
        <input type="password" name="pwd" placeholder="Password">
        <button>Login</button>
    </form>

    <h3>Signup</h3>
    <form action="includes/signup.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" placeholder="username">
        <label for="password">Password:</label>
        <input type="password" name="pwd" placeholder="Password">
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="email">
        <button>Signup</button>
    </form>
    <?php check_signup_errors(); ?>

    

</html>