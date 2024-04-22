<?php
if(!defined('_CODE')){
    die('Access denied...');
}



$data = [
    'pageTitle' =>  'D-Force Forum | Register'
];
layouts('header-login', $data);

if(isPost()){
    $filterAll = filter();
    $error = [];        // Contain errors
    // Validated fullname: Required
    if(empty($filterAll['fullname'])){
        $error['fullname']['required'] = 'Fullname Required';
    }else{
        if(strlen($filterAll['fullname']) < 5){
            $error['fullname']['min'] = 'Fullname at least 5 characters';
        }
    }

    // Validated email: Required input, contain email format, checking the available email in sql
    if(empty($filterAll['email'])){
        $error['email']['required'] = 'Email Required';
    }else{
        $email = $filterAll['email'];
        $sql = "SELECT id FROM users WHERE email = '$email'";
        if(countRows($sql)>0){
            $error['email']['unique'] = 'Your email has been registered';
        }
    }

    // Validate password: Required to type, more than 8 digits
    if(empty($filterAll['password'])){
        $error['password']['required'] = 'Password Required';
    }else{
        if(strlen($filterAll['password']) < 8){
            $error['password']['min'] = 'Password at least 8 characters';
        }
    }

    // Validate password confirm
    if(empty($filterAll['re_password'])){
        $error['re_password']['required'] = 'Re-Enter Password Required';
    }else{
        if(($filterAll['password']) != $filterAll['re_password']){
            $error['re_password']['match'] = 'Re-enter password is not match';
        }
    }

    if(empty($error)){  
        $activeToken = sha1(uniqid());
        $dataInsert = [
            'fullname' => $filterAll['fullname'],
            'email' => $filterAll['email'],
            'password' => password_hash($filterAll['password'], PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            'create_at' => date('Y-m-d H:i:s')
        ];

        $insertStatus = insert('users', $dataInsert);
        if($insertStatus){
            
            // Tao link kich hoat
            $linkActive = _WEB_HOST . '?module=auth&action=active&token='. $activeToken;
            // Thiet lap ham gui mail
            $subject = $filterAll['fullname']. ' | Welkome to our community!!';
            $content = 'Hi, '.$filterAll['fullname'].'.</br>';
            $content .= 'Please click this link to activate your account: </br>';
            $content .= $linkActive. '</br>';
            $content .= 'Best regard!';
            // Gui mail
            $sendMail = sendMail($filterAll['email'], $subject, $content);
            if($sendMail){
                setFlashData('smg', 'Registration successful, please check your email');
                setFlashData('smg_type', 'success');
            }else{
                setFlashData('smg', 'Error! Please try again!');
                setFlashData('smg_type', 'danger');
            }
        }  else{
            setFlashData('smg', 'Registration not successful!');
            setFlashData('smg_type', 'danger');
        }
        redirect('?module=auth&action=login');
    }else{
        setFlashData('smg', 'Please re-validate your input data!');
        setFlashData('smg_type', 'danger');
        setFlashData('errors', $error);
        setFlashData('old', $filterAll);
        redirect('?module=auth&action=register');
    }
};

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$error = getFlashData('errors');
$old = getFlashData('old');


?>

<body>
    <div class="wrapper">
        <h1>Sign Up</h1>
        <form action="" method="post">
            <input name="email" type="email" placeholder="Email" value="<?php 
            echo old('email', $old);
            ?>">
            <?php 
                echo form_error('email', '<span class="error">', '</span>', $error);
            ?>
            <input name="fullname" type="text" placeholder="Full name" value="<?php echo old('fullname', $old); ?>">
            <?php 
                echo form_error('fullname', '<span class="error">', '</span>', $error);
            ?>
            <input name="password" type="password" placeholder="Password" >
            <?php 
                echo form_error('password', '<span class="error">', '</span>', $error);
            ?>
            <input name="re_password" type="password" placeholder="Re-Enter Password" >
            <?php 
                echo form_error('re_password', '<span class="error">', '</span>', $error);
            
            if(!empty($smg)){
                getSmg($smg, $smg_type);
            }
             ?>
            <button type="submit">Sign up</button>
            <div class = "member">Already a member? <a href="?module=auth&action=login">Login Here</a>
        </form>
    </div>
</body>




<?php 
layouts('footer-login');
?>