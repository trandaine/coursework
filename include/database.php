<!-- Connect to the login database -->
<?php
$host = 'localhost:3306';
$dbname = 'coursework';
$username = 'root';
$password = 'quangdainetr';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (  PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}