<?php
if(!defined('_CODE')){
    die('Access denied...');
}


$data = [
    'pageTitle' =>  'D-Force Forum | Forgot password'
];
layouts('header-login', $data);



if (isPost()) {             // Kiem tra phuong thuc POST
    $filterAll = filter();                      // Lay du lieu tu form
    if(!empty($filterAll['email'])){                        // Kiem tra email co ton tai k
        $email = $filterAll['email'];                           // Lay email
        $queryUser = getSingleRow("SELECT id FROM users WHERE email = '$email'");           // Truy van lay thong tin user theo email
        if(!empty($queryUser)){                 // Kiem tra user co ton tai k
            $userId = $queryUser['id'];             // Lay id user
            // Tao forgotToken
            $forgotToken = sha1(uniqid());          // Tao token
            $dataUpdate =[              // Tao mang du lieu can update
                'forgotToken' => $forgotToken               // Cap nhat token vao bang users
            ];
            $updateStatus = update('users', $dataUpdate, "id=$userId");                 // Cap nhat token vao bang users
            if($updateStatus){                              // Kiem tra cap nhat thanh cong k
                // Tao link khoi phuc mk
                $linkReset = _WEB_HOST. '?module=auth&action=reset-password&token='.$forgotToken;
                // Gui mail cho nguoi dung
                $subject = 'Reset password request!';
                $content = 'Hi.</br>';
                $content .= 'Please click this link to reset your account password: </br>';
                $content .= $linkReset . '</br>';
                $content .= 'Best regard!';
                $sendEmail = sendMail($email, $subject, $content);          // Gui mail cho nguoi dung
                if($sendEmail){             // Kiem tra gui mail thanh cong k
                    setFlashData('msg', 'Email has been sent, please check your inbox or spam section!');                       // Thong bao gui mail thanh cong
                    setFlashData('msg_type', 'success');                    // Thong bao gui mail thanh cong
                }else{              // Gui mail that bai
                    setFlashData('msg', 'Error! Please try again later.(email)');                           // Thong bao gui mail that bai
                    setFlashData('msg_type', 'danger');                 // Thong bao gui mail that bai
                }
            }else{        // Cap nhat that bai
                setFlashData('msg', 'Error! Please try again later.');                          // Thong bao cap nhat that bai
                setFlashData('msg_type', 'danger');                 // Thong bao cap nhat that bai
            }
        }else{                  // Email khong ton tai
            setFlashData('msg', 'Invalid email address!');                              // Thong bao email khong ton tai
            setFlashData('msg_type', 'danger');                             // Thong bao email khong ton tai
        }
    }else{                      // Email rong
        setFlashData('msg', 'Please enter your email address!');                    // Thong bao nhap email
        setFlashData('msg_type', 'danger');                             // Thong bao nhap email
    }
}

$msg = getFlashData('msg');                     // Lay thong bao
$msgType = getFlashData('msg_type');                            // Lay loai thong bao




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