<?php 
ob_start();
require_once('admin_include_fns.php');

$conn = db_connect();
$conn->query("set character set utf8");//读库
$conn->query("set names utf8");//写库
@$rid = empty($_GET['rid']) ? $_PSOT['rid'] : $_GET['rid'];

if(@$_GET['rid']){
    $rid = $_GET['rid'];
}
else if(@$_POST['rid']){
    $rid = $_POST['rid'];
}
else{
    echo '小程序信息更改失败，请联系管理员';
    $url = 'order.php';
    header('Refresh: 1; url=' . $url);
    exit;
}

if($rid){

        if(!empty($_POST['pwd'])){
            $query = "UPDATE tenant SET pwd = sha1('{$_POST['pwd']}') WHERE rid = $rid";
            $conn->query($query);
            if ($conn->affected_rows == 1) {
                echo '小程序信息已成功更改';
                $url = 'appletIM.php';
                header('Refresh: 1; url=' . $url);
                exit;
            } else{
                echo '小程序信息更改失败，请联系管理员';
                $url = 'appletIM.php';
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
    </head>

    <body>
        <div class="admin-main">
            <fieldset class="layui-elem-field">
                <legend></legend>
                <div class="layui-field-box">
                    <div class="applet">
                    <form method="post" action="changepwd.php" enctype="multipart/form-data">
                        <p>
                            <label for="apppwd">新密码：</label>
                            <input id="apppwd" type="text" name="pwd" placeholder="新密码" />
                        </p>
                        <p>
                            <input type="hidden" name="rid" value="<?php echo $rid ?>" />
                            <input type="submit" class="button" value="更改" />
                            <a href="appletIM.php"><input type="button" class="button" value="返回" /></a></p>
                    </form>
                    </div>
                </div>
            </fieldset>
        </div>
    </body>

    </html>

    <?php
    }
}

?>

<?php
ob_end_flush();
?>