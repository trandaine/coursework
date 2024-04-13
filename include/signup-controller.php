<?php   

declare(strict_types=1);    // strict requirement

function isInputEmpty(string $username, string $password, string $email) {
    if (empty($username) || empty($password) || empty($email)) {
        return true;
    } else {
        return false;
    }
}

function isEmailValidated(string $email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
};

// Create a function to check if the username already exists in the database
function isUsernameExists(object $pdo, string $username){
    if (getUsername($pdo, $username)) {
        return true;
    } else {
        return false;
    }
};

function isEmailExists(object $pdo, string $email){
    if (getEmail($pdo, $email)) {
        return true;
    } else {
        return false;
    }
};


function createUser(object $pdo, string $username, string $password, string $email)
{
create_user($pdo, $username, $password, $email);
};