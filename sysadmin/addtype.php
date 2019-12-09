<?php

include("../includes/common.php");
$session = md5($conf['admin'].$conf['password'].$conf['domain']);
if(empty($_SESSION['adminlogin']) || $_SESSION['adminlogin'] != $session){
  	@header("Location: ./login.php");
  	exit;
}
if(!empty($_POST['name']) && !empty($_POST['type'])){
  	$name = daddslashes($_POST['name']);
  	$type = daddslashes($_POST['type']);
  	$DB->query("INSERT INTO `ytidc_type` (`name`, `type`, `status`) VALUES ('{$name}', '{$type}', '1')");
  	@header("Location: ./msg.php?msg=添加产品组成功！");
  	exit;
}
$title = "添加产品组";
include("./head.php");

?>

            <div class="container-fluid">
                <div class="side-body">
                    <div class="page-title">
                        <span class="title">添加产品组</span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">
                                        <div class="title">添加内容</div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="addtype.php">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">产品组名称</label>
                                            <input name="name" type="text" class="form-control" id="title" placeholder="分类名称">
                                        </div>
                                        <button type="submit" class="btn btn-default">添加</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php

include("./foot.php");

?>