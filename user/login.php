<?php

include("../includes/common.php");

if(!empty($_POST['username']) && !empty($_POST['password'])){
    $username = daddslashes($_POST['username']);
    $password = daddslashes($_POST['password']);
    $result = $DB->query("SELECT * FROM `ytidc_user` WHERE `username`='{$username}' and `password`='{$password}'");
    if($result->num_rows != 1){
        exit('账号密码错误！<a href="./login.php">点我重新登陆</a>');
    }else{
        $_SESSION['ytidc_user'] = $username;
        $_SESSION['ytidc_adminkey'] = md5($_SERVER['HTTP_HOST'].$password);
        @header("Location: ./index.php");
        exit;
    }
}

$template_code = array(
	'site' => $site,
	'config' => $conf,
	'template_file_path' => '../templates/'.$conf['template'],
);
$template = file_get_contents("../templates/".$conf['template']."/user_login.template");
$template = template_code_replace($template, $template_code);
echo $template;

?>