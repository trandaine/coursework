<?php
if(!defined('_CODE')){
    die('Access denied...');
}

$data = [
    'pageTitle' =>  'D-Force Forum | Profile'
];
layouts('header', $data);



if (isPost()) {             // Kiem tra phuong thuc POST
    $filterAll = filter();                      // Lay du lieu tu form
    if(!empty($filterAll['email'])){                        // Kiem tra email co ton tai k
        $email = $filterAll['email'];                           // Lay email
        $queryUser = getSingleRow("SELECT id FROM users WHERE email = '$email'");           // Truy van lay thong tin user theo email
        if(!empty($queryUser)){                 // Kiem tra user co ton tai k
            $userId = $queryUser['id'];             // Lay id user
            // Tao forgotToken
            $dataUpdate =[              // Tao mang du lieu can update
                'email' => $filterAll['new_email'],
                'fullname' => $filterAll['fullname']
            ];
            $updateStatus = update('users', $dataUpdate, "id=$userId");            // Cap nhat token vao bang users
            if($updateStatus){                              // Kiem tra cap nhat thanh cong k
                setFlashData('msg', 'Profile has been updated!');                       // Thong bao gui mail thanh cong
                setFlashData('msg_type', 'success');                    // Thong bao gui mail thanh cong
            }else{        // Cap nhat that bai
                setFlashData('msg', 'Error! Please try again later.');                          // Thong bao cap nhat that bai
                setFlashData('msg_type', 'danger');                 // Thong bao cap nhat that bai
            }
        }else{          // Email khong ton tai
            setFlashData('msg', 'Invalid email address!');
            setFlashData('msg_type', 'danger');
        }
    }else{              // Email rong
        setFlashData('msg', 'Please enter your email address!');
        setFlashData('msg_type', 'danger');
    }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');






?>



<body>
    <div class="wrapper">
        <h1>Edit Profile </h1>
        <form action="" method="post">
            <input name="email" type="email" placeholder="Email">
            <input name="new_email" type="email" placeholder="New Email">
            <input name="fullname" type="text" placeholder="Fullname">
            <?php
            if(!empty($msg)){
                getSmg($msg, $msg_type);
            }
            ?>
            <button type="submit">Confirm</button>
        </form>
    </div>
</body>







<?php 
layouts('footer');
?>