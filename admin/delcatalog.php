<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
        <link rel="stylesheet" href="css/main.css" />
        <script src="js/my.js"></script>
        <link rel="stylesheet" href="css/my.css">
    </head>

    <body>
        <div class="admin-main">
            <fieldset class="layui-elem-field">
                <legend>删除分类</legend>
                <div class="layui-field-box">
<?php
require_once('admin_include_fns.php');

$conn = db_connect();
$conn->query("set character set utf8");
$conn->query("set names utf8");
?>
<?php

$rid = $_SESSION['customer']['rid'];
$query = "select * from catalog where rid = $rid";
$result = @$conn->query($query);
if (!$result) {
    exit;
}

$num = @$result->num_rows;
if ($num > 0) {
    echo '<form method="post"
        action="delcatdb.php" enctype="multipart/form-data">';
    echo '<div class="catparent">';
    $result = db_result_to_array($result);
    for ($i = 0; $i < count($result); $i++) {

        echo <<<caselayout
         <div class="catchildren"><img  src="$imgcat{$result[$i]['image']}"  alt=" " />
         <p>{$result[$i]['catname']}</p>
         <p><input type="checkbox" name="cats[]" value="{$result[$i]['catalogID']}" /></p>
     </div>

caselayout;

    }
    echo '</div>' . "<div style=\"text-align:center;\" ><input type=\"checkbox\" name=\"all\" onclick=\"check_all(this,'cats[]')\" /><p>全选/全不选</p><input class=\"button\" type=\"submit\" value=\"删除\" /></div>
     
    </form>";


} 

?>


<?php

$conn->close();
?>