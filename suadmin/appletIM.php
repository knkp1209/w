<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
        <link rel="stylesheet" href="css/main.css" />
        <link rel="stylesheet" href="css/my.css">
        <script src="js/my.js"></script>
    </head>
    <style type="text/css">
    </style>
    <body>
        <div class="admin-main">
            <fieldset class="layui-elem-field">
                <legend>小程序信息管理</legend>
                <div class="layui-field-box">
<?php
require_once('admin_include_fns.php');


$stb = "stb";
$std = "std";
$conn = db_connect();
$conn->query("set character set utf8");
$conn->query("set names utf8");
?>
<?php

@$orderid = $_GET['id'];
@$state = $_GET['state'];

if($orderid && $state){


    
    $query = "UPDATE order_table SET state = '$state' WHERE order_id = $orderid";

    $conn->query($query);
    // if($conn->affected_rows > 0){
    //     echo "";
    // }
}

$query = "select * from tenant";
$result = @$conn->query($query);
if (!$result) {
    exit;
}

$num = @$result->num_rows;
if ($num > 0) {

    $result = db_result_to_array($result);
    echo "<div id=\"tb\"><table width=\"100%\" ><tr class=\"tbtitle\">
        <td>小程序ID</td>
        <td>小程序名称</td>
        <td>邮箱</td>
        <td>手机号码</td>
        <td>操作</td>
    </tr>";
    for ($i = 0; $i < count($result); $i++) {
        if($i % 2 == 0)
            echo '<tr class="even">';
        else
            echo '<tr class="odd">';
        ?>
        <td><?php echo $result[$i]['rid'] ?></td>
        <td><?php echo $result[$i]['appname'] ?></td>
        <td><?php echo $result[$i]['lgmail'] ?></td>
        <td><?php echo $result[$i] ['phone'] ?></td>
        <td><a href="changepwd.php?rid=<?php echo $result[$i]['rid'] ?>" >修改密码</a>&nbsp;&nbsp;&nbsp;<a href="detailIM.php?rid=<?php echo $result[$i]['rid'] ?>" >查看详细</a></td>
        
        </tr>
        <?php
        
    }

    echo "</table></div>";


}else{
    echo "暂无小程序";
} 

?>


<?php

$conn->close();
?>