<?php

include("../includes/common.php");
if(!empty($_GET['code'])){
  	$code = daddslashes($_GET['code']);
  	$result = $DB->query("SELECT * FROM `ytidc_user` WHERE `id`='{$code}'");
  	if($result->num_rows == 1){
      	$_SESSION['invite'] = $code;
    }
}else{
	$_SESSION['invite'] = $site['user'];
}
if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email'])){
    $username = daddslashes($_POST['username']);
    $password = daddslashes($_POST['password']);
  	$email = daddslashes($_POST['email']);
    $invite = $_SESSION['invite'];
  	$domain = $_SERVER['HTTP_HOST'];
  	$site = $DB->query("SELECT * FROM `ytidc_fenzhan` WHERE `domain`='{$domain}'")->fetch_assoc();
  	$site = $site['id'];
  	$DB->query("INSERT INTO `ytidc_user` (`username`, `password`, `email`, `money`, `grade`, `invite`, `site`, `status`) VALUE ('{$username}', '{$password}', '{$email}', '0.00', '{$conf['defaultgrade']}', '{$invite}', '{$site}', '1')");
  	//@header("Location: ./login.php");
  	exit($DB->error);
}

$template_code = array(
	'site' => $site,
	'config' => $conf,
	'template_file_path' => '../templates/'.$conf['template'],
);
$template = file_get_contents("../templates/".$conf['template']."/user_register.template");
$template = template_code_replace($template, $template_code);
echo $template;

?>
