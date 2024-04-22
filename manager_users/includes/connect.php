<?php
if(!defined('_CODE')){
    die('Access denied...');
}




try{
    $conn = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME . "", USER, PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($conn == true) {
        echo "<br>";
    } else {
        echo "error";
    }

} catch (PDOException $Exception) {
    echo '<div style="color:red; padding: 5px 15px; border: 1px solid red;">';
    echo $exception -> getMessage().'<br>';
    echo '</div>';
    die();
};