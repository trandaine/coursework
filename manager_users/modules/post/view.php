<?php
if (!defined('_CODE')) {
    die('Access denied...');
}


$data = [
    'pageTitle' =>  'D-Force Forum | Manage posts'
];
layouts('header', $data);


// Access database
$listQuestions = getRaw("SELECT * FROM questions ORDER BY created_at");



?>

<div class="container">
    <hr>
    <h2>Post manager</h2>
    <p>
        <a href="?module=post&action=new_post" class="btn btn-success btn-sm">Add a question<i class="fa-solid fa-plus"></i></a>
    </p>
    <table class="table table-borderless">
        <thead>
            <th>QuestionID</th>
            <th>UID</th>
            <th>Title</th>
            <th>Content</th>
            <th width="5%">Edit</th>
            <th width="5%">Delete</th>
        </thead>
        <tbody>
            <?php
            if (!empty($listQuestions)) :
                $count = 0;
                foreach ($listQuestions as $question) :
                    $count++;
            ?>
                    <tr>
                        <td><?php echo $question['question_id'];   ?></td>
                        <td><?php echo $question['user_id'];   ?></td>
                        <td><?php echo $question['title'];   ?></td>
                        <td><?php echo $question['content'];   ?></td>
                        <td><a href="<?php echo _WEB_HOST;?>?module=post&action=edit&id=<?php echo $question['question_id']; ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a></td>
                        <td><a href="" onclick="return confirm('Are you sure about that?')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a></td>
                    </tr>
            <?php
                endforeach;
            endif;
            ?>
        </tbody>
    </table>
</div>






<?php
layouts('footer');
?>