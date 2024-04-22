<?php
if(!defined('_CODE')){
    die('Access denied...');
}


$data = [
    'pageTitle' =>  'D-Force Forum | Forgot password'
];
layouts('header-login', $data);



if (isPost()) {
    $filterAll = filter();
    if(!empty($filterAll['email'])){
        $email = $filterAll['email'];
        $queryUser = getSingleRow("SELECT id FROM users WHERE email = '$email'");
        if(!empty($queryUser)){
            $userId = $queryUser['id'];
            // Tao forgotToken
            $forgotToken = sha1(uniqid());
            $dataUpdate =[
                'forgotToken' => $forgotToken
            ];
            $updateStatus = update('users', $dataUpdate, "id=$userId");
            if($updateStatus){
                // Tao link khoi phuc mk
                $linkReset = _WEB_HOST. '?module=auth&action=reset-password&token='.$forgotToken;
                // Gui mail cho nguoi dung
                $subject = 'Reset password request!';
                $content = 'Hi.</br>';
                $content .= 'Please click this link to reset your account password: </br>';
                $content .= $linkReset . '</br>';
                $content .= 'Best regard!';
                $sendEmail = sendMail($email, $subject, $content);
                if($sendEmail){
                    setFlashData('msg', 'Email has been sent, please check your inbox or spam section!');
                    setFlashData('msg_type', 'success');
                }else{
                    setFlashData('msg', 'Error! Please try again later.(email)');
                    setFlashData('msg_type', 'danger');
                }
            }else{
                setFlashData('msg', 'Error! Please try again later.');
                setFlashData('msg_type', 'danger');
            }
        }else{
            setFlashData('msg', 'Invalid email address!');
            setFlashData('msg_type', 'danger');
        }
    }else{
        setFlashData('msg', 'Please enter your email address!');
        setFlashData('msg_type', 'danger');
    }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');




?>

<body>
    <div class="wrapper">
        <h1>Don't remember your password? </h1>
        <?php
            if(!empty($msg)){
                getSmg($msg, $msg_type);
                die();
            }
            ?>
        <form action="" method="post">
            <input name="email" type="email" placeholder="Email">
            <button type="submit">Reset password</button>
            <div class="member">Remember your Password?</div><a href="?module=auth&action=login">Login Now</a></div>
        </form>
    </div>
</body>




<?php 
layouts('footer-login');
?>