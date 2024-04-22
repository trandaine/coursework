<?php
if(!defined('_CODE')){
    die('Access denied...');
}


$data = [
    'pageTitle' =>  'D-Force Forum | Login'
];
layouts('header-login', $data);

// if(isLogin()){
//     redirect('?module=home&action=dashboard');
// }



if (isPost()) {
    $filterAll = filter();
    if (!empty(trim($filterAll['email'])) && !empty(trim($filterAll['password']))) {
        // Kiem tra dang nhap
        $email = $filterAll['email'];
        $password = $filterAll['password'];
        // echo $email . '</br>';
        // echo $password. '</br>';
        // Truy van lay thong tin users theo email
        $userQuery = getSingleRow("SELECT password, id FROM users WHERE email = '$email'");
        if (!empty($userQuery)) {
            $passwordHash = $userQuery['password'];
            $userId = $userQuery['id'];
            if (password_verify($password, $passwordHash)) {
                // Tao token login 
                $tokenLogin = sha1(uniqid());
                // Insert vao bang tokenLogin
                $dataInsert =[
                    'user_id' => $userId,
                    'token' => $tokenLogin,
                    'create_at' => date('Y-m-d H:i:s')
                ];
                $insertStatus = insert('tokenLogin', $dataInsert);
                if($insertStatus){
                    // Insert thanh cong
                    setSession('tokenLogin', $tokenLogin);
                    redirect('?module=home&action=dashboard');

                }else{
                    setFlashData('msg', 'Error occur, Please try again!');
                    setFlashData('msg_type', 'danger');
                }
                
            } else {
                setFlashData('msg', 'Password incorrect');
                setFlashData('msg_type', 'danger');
            }
        } else {
            setFlashData('msg', 'Invalid email or password');
            setFlashData('msg_type', 'danger');
        }
    } else {
        setFlashData('msg', 'Please enter your email and password');
        setFlashData('msg_type', 'danger');
    }
    redirect('?module=auth&action=login');
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');




?>

<body>
    <div class="wrapper">
        <h1>Login </h1>
        <form action="" method="post">
            <input name="email" type="email" placeholder="Email">
            <input name="password" type="password" placeholder="Password">
            <div class="recover">
                <a href="?module=auth&action=forgot">Forgot Password?</a>
            </div>
            <?php
            if(!empty($msg)){
                getSmg($msg, $msg_type);
            }
            ?>
            <button type="submit">Sign up</button>
            <div class="member">Not a member?<a href="?module=auth&action=register">Register Now</a></div>
        </form>
    </div>
</body>




<?php 
layouts('footer-login');
?>