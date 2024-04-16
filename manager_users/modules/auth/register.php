<?php
if(!defined('_CODE')){
    die('Access denied...');
}

$data = [
    'fullname' => 'daitranquang',
    'email' => 'dai@gmail.com',
];
$result = update('users', $data, 'id = 1');
var_dump($result);

// $data = [
//     'pageTitle' =>  'D-Force Forum | Register'
// ];
layouts('header', $data);



?>

<body>
    <div class="wrapper">
        <h1>Sign Up</h1>
        <form action="#">
            <input type="text" placeholder="Email">
            <input type="text" placeholder="Full name">
            <input type="password" placeholder="Password">
            <input type="password" placeholder="Re-Enter Password">
        </form>
        <button type="submit">Sign up</button>
        <div class = "member">Already a member? <a href="?module=auth&action=login">Login Here</a>
    </div>
</body>




<?php 
layouts('footer');
?>