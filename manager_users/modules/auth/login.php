<?php
if(!defined('_CODE')){
    die('Access denied...');
}


$data = [
    'pageTitle' =>  'D-Force Forum | Login'
];
layouts('header', $data);
?>

<body>
    <div class="wrapper">
        <h1>Login </h1>
        <form action="#">
            <input type="text" placeholder="Email">
            <input type="password" placeholder="Password">
            <div class="recover">
                <a href="?module=auth&action=forgot">Forgot Password?</a>
            </div>
        </form>
        <button type="submit">Sign up</button>
        <div class="member">Not a member?<a href="?module=auth&action=register">Register Now</a></div>
    </div>
</body>




<?php 
layouts('footer');
?>