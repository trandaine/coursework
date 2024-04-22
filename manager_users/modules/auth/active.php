<?php
if(!defined('_CODE')){
    die('Access denied...');
}

$data = [
    'pageTitle' =>  'D-Force Forum | Active'
];
layouts('header-login', $data);



$token =filter()['token'];
if(!empty($token)){
    $tokenQuery = getSingleRow("SELECT id FROM users WHERE activeToken = '$token' ");
    if(!empty($tokenQuery)){
        $userId = $tokenQuery['id'];
        $dataUpdate = [
            'status' => 1,
            'activeToken' => null
        ];
        $updateStatus = update('users', $dataUpdate, "id=$userId");
        if($updateStatus){
            setFlashData('msg', 'Active successful!');
            setFlashData('msg_type', 'success');
        }else{
            setFlashData('msg', 'Active not successfully, please contact admin!');
            setFlashData('msg_type', 'danger');
        }
        // redirect('?module=auth&action=login');
    }else{
        getSmg('Active link ran out of time!', 'danger');
    }
}

?>

<h1>Active your account successfully</h1>
<h2>You may close this window to login!</h2>



<?php 
layouts('footer-login');
?>