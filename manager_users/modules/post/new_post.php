<?php
if(!defined('_CODE')){
    die('Access denied...');
}

$data = ['pageTitle' =>  'D-Force Forum | New Post'];
layouts('header', $data);




if (isPost()) {
    $filterAll = filter();
    if (!empty(trim($filterAll['title'])) && !empty(trim($filterAll['content']))) {
        // Kiem tra dang nhap
        $title = $filterAll['title'];
        $content = $filterAll['content'];
        $token = getSession('tokenLogin');
        $image_url = $filterAll['image_url'];
        $questionQuery = getSingleRow("SELECT user_id FROM tokenLogin WHERE token = '$token'");
        if (!empty($questionQuery)) {
            $userId = $questionQuery['user_id'];
            $dataInsert =[
                'title' => $title,
                'content' => $content,
                'user_id' => $userId,
                'created_at' => date('Y-m-d H:i:s'),
                'image_url' => $image_url
            ];
            $insertStatus = insert('questions', $dataInsert);
            if($insertStatus){
                setFlashData('msg', 'Question has been posted!');
                setFlashData('msg_type', 'success');
            }else{
                setFlashData('msg', 'Error occur, Please try again!');
                setFlashData('msg_type', 'danger');
            }
        } else {
            setFlashData('msg', 'Error occur, Please try again!');
            setFlashData('msg_type', 'danger');
        }
    } else {
        setFlashData('msg', 'Please enter your title and content');
        setFlashData('msg_type', 'danger');
    }
    // redirect('?module=home&action=dashboard');
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');






?>



<body>
    <div class="wrapper2">
        <h1>Create new question</h1>
        <form action="" method="post">
            <input name="title" type="text" placeholder="Title">
            <input name="content" type="text" placeholder="Your Question?">
            <input name="image_url" type="text" placeholder="Your image link? (Googe Drive, OneDrive)">
            <button type="submit">Post</button>
            <div class = "member">Having trouble? <a href="#">Report Here</a>
            <?php
            if(!empty($msg)){
                getSmg($msg, $msg_type);
            }
            ?>
             <!-- * HTML code for a submit button to post a question.
             *
             * @var string $type The type of the input element (submit).
             * @var string $name The name attribute of the input element (post_question_btn).
             * @var string $value The value attribute of the input element (Post Question).
             * @var string $class The class attribute of the input element (btn btn-primary).
             *
             * @return string The HTML code for the submit button. -->
                  
        </form>
    </div>
</body>















<?php 
layouts('footer');
?>