<?php
ob_start();
require_once('admin_include_fns.php');

$upload_path = $imglogo;
$conn = db_connect();
$conn->query("set character set utf8");//读库
$conn->query("set names utf8");//写库
$parameter = null;

$upload_path = $imglogo;
$tempfile = false;

// 判断是否上传了图片
if (!empty($_FILES['logo']['tmp_name'])){
    $logo = uploadimage($_FILES['logo'], $upload_path);
}else{
    $logo = false;
}

// 对要更新的字段进行拼接,字段为空则跳过
if(@$_POST['rid'])
    $rid = $_POST['rid'];
if(@$_POST['appname'])
    $parameter = "appname='{$_POST['appname']}',";
if(@$_POST['appID'])
    $parameter .= "appID='{$_POST['appID']}',";
if(@$_POST['logo'])
    $parameter .= "logo='{$_POST['logo']}',";
if(@$_POST['introduce'])
    $parameter .= "introduce='{$_POST['introduce']}',";
if(@$_POST['phone'])
    $parameter .= "phone='{$_POST['phone']}',";
if(@$_POST['secret'])
    $parameter .= "secret='{$_POST['secret']}',";
if($logo){
    $parameter .= "logo='$logo',";
}

// 把最后一个逗号去掉
$parameter = substr($parameter,0,-1);

// 没有要更新的字段，跳转回原来的页面
if(!$parameter){
    echo '小程序信息更改失败，请联系管理员';
    $url = 'appletIM.php';
    header('Refresh: 1; url=' . $url);
    exit;
}


// 有上传图片，先把原来的图片名保存到 $tempfile,后面通过 $tempfile 判断是否有上传图片
if($logo){
    $query = "SELECT logo FROM tenant WHERE rid = $rid";
    $result = $conn->query($query);
    if($result){
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $tempfile = $row['logo'];
        }
    }else{
        echo "系统错误-47";
    }
}


// 更新一行数据
$query = "UPDATE tenant SET $parameter WHERE rid = $rid";
$conn->query($query);

// 成功更新
if ($conn->affected_rows == 1) {
    // 有上传图片，把原有的删除
    if($tempfile){
        if (@file_exists($upload_path.$tempfile)){
            if(!unlink($upload_path.$tempfile))
                echo "BUG 请联系管理员";
        }
    }

    // 跳回原来的页面
    echo '小程序信息已成功更改';
    $url = 'appletIM.php';
    header('Refresh: 1; url=' . $url);
    exit;
} else{
    if($logo){
        if (@file_exists($upload_path.$logo)){
            if(!unlink($upload_path.$logo))
                echo "BUG 请联系管理员";
        }
    }
    // 跳回原来的页面
    echo '小程序信息更改失败，请联系管理员';
    $url = 'appletIM.php';
    header('Refresh: 1; url=' . $url);
    exit;
}
?>
