<?php
if(!defined('_CODE')){
    die('Access denied...');
}
$data = [
    'pageTitle' =>  'D-Force Forum | Reset Password'
];
layouts('header-login', $data);

$token = filter()['token'];
if(!empty($token)){
    // truy van database kiem tra token
    $tokenQuery = getSingleRow("SELECT id, fullname, email FROM users WHERE forgotToken ='$token'");
    if(!empty($tokenQuery)){
        $userId = $tokenQuery['id'];
        if(isPost()){
            $filterAll = filter();
            $errors = [];       // Ham chuwa cac loi
            // Validate password: Required to type, more than 8 digits
            if (empty($filterAll['password'])) {
                $errors['password']['required'] = 'Password Required';
            } else {
                if (strlen($filterAll['password']) < 8) {
                    $errors['password']['min'] = 'Password at least 8 characters';
                }
            }

            // Validate password confirm
            if (empty($filterAll['re_password'])) {
                $errors['re_password']['required'] = 'Re-Enter Password Required';
            } else {
                if (($filterAll['password']) != $filterAll['re_password']) {
                    $errors['re_password']['match'] = 'Re-enter password is not match';
                }
            }

            if (empty($error)) {
                // Xu ly viec quen mk
                $passwordHash = password_hash($filterAll['password'], PASSWORD_DEFAULT);
                $dataUpdate = [
                    'password' => $passwordHash,
                    'forgotToken' => null,
                    'update_at' => date('Y-m-d H:i:s')
                ];
                $updateStatus = update('users', $dataUpdate, "id='$userId'");
                if($updateStatus){
                    setFlashData('msg', 'Change password successfully!');
                    setFlashData('msg_type', 'success');
                }else{
                    setFlashData('msg', 'Change password not successful!');
                    setFlashData('msg_type', 'danger');
                }
            } else {
                setFlashData('msg', 'Please re-validate your input data!');
                setFlashData('msg_type', 'danger');
                setFlashData('errors', $errors);
                redirect('?module=auth&action=reset-password&token='.$token);
            }


        }
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$errors = getFlashData('error');


        ?>
        <!-- Form dat lai mat khau -->
<body>
    <div class="wrapper">
        <h1>Password reset</h1>
        <form action="" method="post">
            <input name="password" type="password" placeholder="New Password" >
            <?php 
                echo form_error('password', '<span class="error">', '</span>', $errors);
            ?>
            <input name="re_password" type="password" placeholder="Re-Enter New Password" >
            <?php 
                echo form_error('re_password', '<span class="error">', '</span>', $errors);
            
            if(!empty($msg)){
                getSmg($msg, $msg_type);
            }
             ?>
             <input type="hidden" name="token" value="<?php echo $token; ?>">
            <button type="submit">Reset</button>
            <div class = "member">Remember your old password? <a href="?module=auth&action=login">Click here!</a>
        </form>
    </div>
</body>

        <?php
    }else{
        getSmg('Your reset link is invalid or expired ','danger');
    }
}else{
    getSmg('Your reset link is invalid or expired ','danger');
}


layouts('footer-login');
?>