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
                <legend>查看预约</legend>
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

$rid = $_SESSION['customer']['rid'];
$query = "select * from order_table where rid = $rid";
$result = @$conn->query($query);
if (!$result) {
    exit;
}

$num = @$result->num_rows;
if ($num > 0) {

    $result = db_result_to_array($result);
    echo "<div id=\"tb\"><table width=\"100%\" ><tr class=\"tbtitle\">
        <td>订单编号</td>
        <td>商品名称</td>
        <td>顾客姓名</td>
        <td>手机号码</td>
        <td>预约时间</td>
        <td>商品单价</td>
        <td>预约数量</td>
        <td>总额</td>
        <td>状态</td>
        <td>操作</td>
    </tr>";
    for ($i = 0; $i < count($result); $i++) {
        if($i % 2 == 0)
            echo '<tr class="even">';
        else
            echo '<tr class="odd">';
        ?>
        <td><?php echo $result[$i]['order_id'] ?></td>
        <td><?php $goodsname = goodsidcvrname($result[$i]['order_goodsid']); echo  $goodsname ? $goodsname : '商品已删除' ?></td>
        <td><?php echo $result[$i]['customer_name'] ?></td>
        <td><?php echo $result[$i] ['customer_phone'] ?></td>
        <td><?php echo $result[$i]['appointment_datetime'] ?></td>
        <td><?php echo $result[$i]['order_amount'] / $result[$i]['order_number']?></td>
        <td><?php echo $result[$i]['order_number'] ?></td>
        <td><?php echo $result[$i]['order_amount'] ?></td>
        <td><?php 
        if($result[$i]['state'] == 0)
            echo "预约中";
        else if($result[$i]['state'] == 1)
            echo "预约成功";
        else
            echo "完成订单";
         ?></td>
        <td><?php 
        if($result[$i]['state'] == 0){
            echo "<a href=\"order.php?id={$result[$i]['order_id']}&state=1\" >确认预约</a>";
        }
        else if($result[$i]['state'] == 1)
            echo "<a href=\"order.php?id={$result[$i]['order_id']}&state=2\" >完成订单</a>";
        else
            echo "已完成";
         ?></td>
        </tr>
        <?php
        
    }

    echo "</table></div>";


}else{
    echo "预约为空";
} 

?>


<?php

$conn->close();
?>
