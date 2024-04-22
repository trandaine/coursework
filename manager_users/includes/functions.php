<?php
if(!defined('_CODE')){
    die('Access denied...');
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function layouts($layoutName='header', $data = []){
    if(file_exists(_WEB_PATH_TEMPLATES . '/layout/'.$layoutName.'.php')){
        require_once _WEB_PATH_TEMPLATES . '/layout/'.$layoutName.'.php';
    }
};

// Ham gui mail
function sendMail($to, $subject, $content){
$mail = new PHPMailer(true);        //Create an instance; passing `true` enables exceptions

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'tranquangdai.binhduong@gmail.com';                     //SMTP username
    $mail->Password   = 'nsiyjvdikkxzlpgk';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('trangquangdai03072004@gmail.com', 'Dainetr');
    $mail->addAddress($to);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $content;

    $mail->send();
    // echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}

// Kiem tra phuong thuc GET
function isGET(){
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        return true;
    }
    return false;
}


// Kiem tra phuong thuc POST
function isPost(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        return true;
    }
    return false;
}

// Ham filter loc du lieu
function filter(){
    $fileterArr = [];
    if(isGet()){
        // Xu li cai du lieu trc khi no hien thi ra
        // return $_GET;
        if(!empty($_GET)){
            foreach($_GET as $key => $value){
                $key = strip_tags($key);
                if(is_array($value)){
                    $fileterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                }else{
                    $fileterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
                
            }
        }
    }

    if(isPost()){
        if(!empty($_POST)){
            foreach($_POST as $key => $value){
                $key = strip_tags($key);
                if(is_array($value)){
                    $fileterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                }else{
                    $fileterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
    }
    return $fileterArr;
}


// Kiem tra du lieu dau vao co phai email k
function isEmail($email){
    $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    return $checkEmail;
}

// Kiem tra dau vao la so nguyen
function isNumberInt($number){
    $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
    return $checkNumber;
}

// Kiem tra dau vao la so thuc
function isNumberFloat($number){
    $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT);
    return $checkNumber;
}

// Thong bao looi
function getSmg($smg, $type = 'success'){
    echo '<div class ="alert alert-'.$type.'">';
    echo $smg;
    echo '</div>';
}

// Ham chuyen huong
function redirect($path='index.php'){
    header("Location: $path");
    exit;
}

// Ham thong bao loi
function form_error($fileName, $beforeHTML='', $afterHTML='', $error){
    return (!empty($error[$fileName])) ? '<span class="error">'.reset($error[$fileName]).'</span>' : null;
}
// Ham hien thi du lieu cu
function old($fileName, $oldData, $default = null){
    echo(!empty($oldData[$fileName])) ? $oldData[$fileName] : $default;
}

// ham kiem tra trang thai dang nhap
function isLogin(){
    $checkLogin = false;
if(getSession('tokenLogin')){
    $tokenLogin = getSession('tokenLogin');
    $queryToken = getSingleRow("SELECT user_id FROM tokenLogin WHERE token = '$tokenLogin' ");
    if(!empty($queryToken)){
        $checkLogin = true;
    }else{
        removeSession('tokenLogin');
    }
};
if(!$checkLogin){
    redirect('?module=home&action=dashboard');
}
return $checkLogin;
}

function display_succeed()
{
    global $succeed;
    if ($succeed) {
        echo '<div class="success">';
        echo $succeed . '<br>';
        echo '</div>';
    }
    $success = "";
}
function display_error()
{
    global $errors;

    if (count($errors) > 0) {
        echo '<div class="error">';
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        echo '</div>';
    }
}
function display_success()
{
    global $success;
    if ($success) {
        echo '<div class="success">';
        echo $success . '<br>';
        echo '</div>';
    }
    $success = "";
}








