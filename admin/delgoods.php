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
                <legend>删除商品</legend>
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

$rid = $_SESSION['customer']['rid'];
$query = "select * from goods where rid = $rid ORDER BY goodsID DESC";
$result = @$conn->query($query);
if (!$result) {
    exit;
}

$num = @$result->num_rows;
if ($num > 0) {

    echo '<form method="post"
        action="delgoodsdb.php" enctype="multipart/form-data">';
    $result = db_result_to_array($result);
    echo "<div id=\"tb\"><table width=\"100%\" ><tr class=\"tbtitle\">
        <td class=\"gdname\">商品名称</td>
        <td class=\"catname\">商品分类</td>
        <td class=\"simg\">展示图片</td>
        <td class=\"dimg\">详情图片</td>
        <td class=\"spr\">原价</td>
        <td class=\"pr\">现价</td>
        <td class=\"nb\">库存</td>
        <td class=\"del\">删除</td>
    </tr>";
    for ($i = 0; $i < count($result); $i++) {
        $catname = idcvrname($result[$i]['catalogID']);
        $gdswpimg = idcvrimg($result[$i]['gdswpimg'],2,$imggoods);
        if($gdswpimg)
            $gdswpimg = ssimg($gdswpimg,$stb,$std,$imggoods);

        $detailsimg = idcvrimg($result[$i]['detailsimg'],2,$imggoods);
        if($detailsimg)
            $detailsimg = ssimg($detailsimg,$stb,$std,$imggoods);
        if($i % 2 == 0)
            echo '<tr class="even">';
        else
            echo '<tr class="odd">';
        echo <<<php_table
        <td class="gdname">{$result[$i]['gdname']}</td>
        <td class="catname">$catname</td>
        <td class="simg">$gdswpimg</td>
        <td class="dimg">$detailsimg</td>
        <td class="spr">{$result[$i]['sprice']}</td>
        <td class="pr">{$result[$i]['price']}</td>
        <td class="nb">{$result[$i]['gdnumber']}</td>
        <td class="del"><input type="checkbox" name="goodsID[]" value="{$result[$i]['goodsID']}" /></td>
        </tr>
php_table;
    }

    echo "</table></div>";
    echo "<div class=\"delcenter\"><input type=\"checkbox\" name=\"all\" onclick=\"check_all(this,'goodsID[]')\" /><p>全选/全不选</p>
     <input type=\"submit\" value=\"删除\" class=\"button\" /></div>
    </form>";


} 

?>


<?php

$conn->close();
?>