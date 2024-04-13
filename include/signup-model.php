<?php   

declare(strict_types=1);    // strict requirement

function getUsername(object $pdo, string $username) {
    $query = "SELECT * FROM user WHERE username = :username";
    $stmt = $pdo->prepare($query);              // Prepare the query
    $stmt->bindParam(":username", $username);    // Bind the parameter
    $stmt->execute();                           // Execute the query

    $result = $stmt->fetch(PDO::FETCH_ASSOC);                   // Fetch the result
    return $result;                             // Return the result
};

function getEmail(object $pdo, string $email) {
    $query = "SELECT * FROM user WHERE email = :email"; 
    $stmt = $pdo->prepare($query);              // Prepare the query
    $stmt->bindParam(":email", $email);          // Bind the parameter
    $stmt->execute();                           // Execute the query

    $result = $stmt->fetch(PDO::FETCH_ASSOC);                   // Fetch the result
    return $result;                             // Return the result
};

function create_user(object $pdo, string $username, string $password, string $email){
    $query = "INSERT INTO user (username, pwd, email) VALUES (:username, :pwd, :email)";
    $stmt = $pdo->prepare($query);              // Prepare the query
    $options = ['cost' => 12];                  // Set the options
    $hashed_password = password_hash($password, PASSWORD_BCRYPT, $options);    // Hash the password
    $stmt->bindParam(":username", $username);    // Bind the parameter
    $stmt->bindParam(":pwd", $hashed_password);    // Bind the parameter
    $stmt->bindParam(":email", $email);          // Bind the parameter
    $stmt->execute();                           // Execute the query
}