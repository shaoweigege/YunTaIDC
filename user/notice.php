<?php
include("../includes/common.php");
if(empty($_SESSION['ytidc_user']) && empty($_SESSION['ytidc_pass'])){
  	@header("Location: ./login.php");
     exit;
}else{
  	$username = daddslashes($_SESSION['ytidc_user']);
  	$userkey = daddslashes($_SESSION['ytidc_adminkey']);
  	$user = $DB->query("SELECT * FROM `ytidc_user` WHERE `username`='{$username}'");
  	if($user->num_rows != 1){
      	@header("Location: ./login.php");
      	exit;
    }else{
    	$user = $user->fetch_assoc();
      	$userkey1 = md5($_SERVER['HTTP_HOST'].$user['password']);
      	if($userkey != $userkey1){
      		@header("Location: ./login.php");
      		exit;
      	}
    }
}
$result = $DB->query("SELECT * FROM `ytidc_notice`");
$notice_template = file_get_contents("../templates/".$conf['template']."/user_notice_list.template");
while($row = $result->fetch_assoc()){
	$notice_template_code = array(
		'id' => $row['id'],
		'title' => $row['title'],
	);
	$notice_template_new = $notice_template_new . template_code_replace($notice_template, $notice_template_code);
}
$template = file_get_contents("../templates/".$conf['template']."/user_header.template").file_get_contents("../templates/".$conf['template']."/user_notice.template").file_get_contents("../templates/".$conf['template']."/user_footer.template");
$template_code = array(
	'site' => $site,
	'config' => $conf,
	'template_file_path' => '../templates/'.$conf['template'],
	'user' => $user,
	'notice' => $notice_template_new,
);
$template = template_code_replace($template, $template_code);
echo $template;