<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["pwd"];
    $email = $_POST["email"];

    try{
        require_once "database.php";
        require_once "signup-model.php";
        require_once "signup-controller.php";
        // Error handlers
        $errors = [];
        if (isInputEmpty($username, $password, $email)){
            $errors["empty_input"] = "Please fill in all fields";
        }
        if (isEmailValidated($email)){
            $errors["invalid_email"] = "Please enter a valid email";
        }
        if (isUsernameExists($pdo, $username)){
            $errors["username_exists"] = "Username already exists";
        }
        if (isEmailExists($pdo, $email)){
            $errors["email_exists"] = "Email already exists";
        }


        require_once "config-session.php";
        // Check if there are no errors
        if($errors){        // Check if there are errors
            $_SESSION["errors_signup"] = $errors;
            header("Location: ../index.php");
            die();
        }
        create_user($pdo, $username, $password, $email);
        header("Location: ../index.php?signup=success");
        $pdo = null;
        $stmt = null;
        die();
    }catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
    
}else {
    header("Location: ../index.php");
    die();
};