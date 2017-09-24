<?php 
ob_start();
require_once('admin_include_fns.php');

$conn = db_connect();
$conn->query("set character set utf8");//读库
$conn->query("set names utf8");//写库
$upload_path = $imglogo;

if(@$_POST['submitted']){

    if (!empty($_FILES['logo']['tmp_name'])){
        $logo = uploadimage($_FILES['logo'], $upload_path);
    }else{
        $logo = '#';
    }

    if(@$_POST['mail'] && @$_POST['pwd']){
        $parameter = "null,'{$_POST['mail']}',sha1('{$_POST['pwd']}'),";
    }else{
        echo '添加失败，请填入邮箱和密码,1秒后跳转';
        $url = 'addApplet.php';
        header('Refresh: 1; url=' . $url);
        exit;
    }

    if(@$_POST['phone'])
        $parameter .= "'{$_POST['phone']}',";
    else
        $parameter .= "'18888123456',";

    if(@$_POST['appname'])
        $parameter .= "'{$_POST['appname']}',";
    else
        $parameter .= "'小程序名称',";

    if(@$_POST['appID'])
        $parameter .= "'{$_POST['appID']}',";
    else
        $parameter .= "'wx180000',";

    if($logo){
        $parameter .= "'$logo',";
    }

    if(@$_POST['introduce'])
        $parameter .= "'{$_POST['introduce']}',";
    else
        $parameter .= "'小程序简介',";


    if(@$_POST['secret'])
        $parameter .= "'{$_POST['secret']}'";
    else
        $parameter .= "'secret001'";


    $query = "INSERT INTO tenant VALUES  ($parameter)";
    $result = $conn->query($query);

    if(!$result)
        echo "系统错误62";


    if($conn->affected_rows > 0){
        echo '成功添加，请在小程序信息管理界面查看,1秒后跳转';
        $url = 'index.php';
        echo '<script type="text/javascript">
        function jumb() {
            top.location.href="index.php";
        }

        window.setTimeout(jumb,2000);
        </script>';
        exit;
    }else{
        echo '添加失败，请重新尝试或者联系管理员,1秒后跳转';
        $url = 'addApplet.php';
        header('Refresh: 1; url=' . $url);
        exit;
    }

}else{

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/my.css">
    <script src="js/my.js"></script>
    <script type="text/javascript">
    function btnAction(id) {
    document.getElementById(id).click();
    }
    </script>
</head>

<body>
    <div class="admin-main">
        <fieldset class="layui-elem-field">
            <legend>小程序信息管理</legend>
            <div class="layui-field-box">
                <div class="applet">
                <form method="post" action="addApplet.php" enctype="multipart/form-data">
                    <p>
                        <label for="mail">邮箱：</label>
                        <input id="mail" type="text" name="mail" placeholder="登录邮箱 必填" />
                    </p>
                    <p>
                        <label for="pwd">密码：</label>
                        <input id="pwd" type="text" name="pwd" placeholder="登录密码 必填" />
                    </p>
                    <p>
                        <label for="appname">小程序名称：</label>
                        <input id="appname" type="text" name="appname" placeholder="请输入小程序名称" />
                    </p>
                    <p>
                        <label for="appID">&nbsp;&nbsp; APPID：</label>
                        <input id="appID" type="text" name="appID" placeholder="请输入APPID 必填" />
                    </p>
                    <p>
                        <label for="secret">&nbsp;&nbsp; 小程序密钥：</label>
                        <input id="secret" type="text" name="secret" placeholder="请输入密钥 必填" />
                    </p>
                    <p>
                        <label for="logo">小程序LOGO：</label><input type="button" class="button logo"  value="选择图片" onclick="btnAction('logo')">
                        <input id="logo" type="file" class="file" name="logo"  onchange="readAsDataURL(this.files,'prelogo')"/>
                        <div id="prelogo" class="prelogo">
                            
                        </div>
                    </p>
                    <p>
                        <label for="introduce">小程序简介：</label>
                        <input id="introduce" type="text" name="introduce" placeholder="请输入小程序简介" />
                    </p>
                    <p>
                        <label for="phone">&nbsp;&nbsp;&nbsp;电话：</label>
                        <input id="phone" type="text" name="phone" placeholder="请输入手机号码" />
                    </p>
                    <p>
                        <input type="hidden" name="submitted" value="true" />
                        <input type="submit" class="button" value="添加" /></p>
                </form>
                </div>
            </div>
        </fieldset>
    </div>
</body>

</html>

<?php
}
ob_end_flush();
?>
