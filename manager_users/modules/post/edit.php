<?php
if(!defined('_CODE')){
    die('Access denied...');
}

$data = [
    'pageTitle' =>  'D-Force Forum | Edit post'
];
layouts('header', $data);



if (isPost()) {             // Kiem tra phuong thuc POST
    $filterAll = filter();                      // Lay du lieu tu form
    if(!empty($filterAll['title'])){                        // Kiem tra title co ton tai k
        $title = $filterAll['title'];                           // Lay email
        $queryQuestion = getSingleRow("SELECT question_id FROM questions WHERE title = '$title'");           // Truy van lay thong tin user theo email
        if(!empty($queryQuestion)){                 // Kiem tra user co ton tai k
            $questionId = $queryQuestion['question_id'];             // Lay id user
            // Tao forgotToken
            $dataUpdate =[              // Tao mang du lieu can update
                'title' => $filterAll['title'],
                'content' => $filterAll['content'],
                'image_url' => $filterAll['image_url']
            ];
            $updateStatus = update('questions', $dataUpdate, "question_id=$questionId");            // Cap nhat token vao bang users
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
    <div class="wrapper2">
        <h1>Edit your question</h1>
        <form action="" method="post">
            <input name="title" type="text" placeholder="Title">
            <input name="content" type="text" placeholder="Your Question?">
            <input name="image_url" type="text" placeholder="Your image link? (Googe Drive, OneDrive)">
            <button type="submit">Confirm</button>
            <div class = "member">Having trouble? <a href="#">Report Here</a>
            <?php
            if(!empty($msg)){
                getSmg($msg, $msg_type);
            }
            ?>
                  
        </form>
    </div>
</body>






<?php 
layouts('footer');
?>