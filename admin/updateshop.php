<?php  
    require_once('admin_include_fns.php');
    $rid = $_SESSION['customer']['rid'];
    $conn = db_connect();
    $conn->query("set character set utf8");//读库
    $conn->query("set names utf8");//写库
    

    // // 查询该小程序是否忆存在商家信息
    // $query = "SELECT * FROM shop WHERE rid = $rid";
    // $shopres = $conn->query($query);

    // if(!$shopres){
    //     echo "请联系管理员 15521175608";
    //     exit;
    // }

    // if($shopres->num_rows == 1){
    //     $row = $shopres->fetch_assoc();
    //     $shopid = $row['id'];
    //     $query = "SELECT * FROM shopdesc WHERE shopid = $shopid";
    //     $descres = $conn->query($query);
    //     if(!$descres){
    //         echo "请联系管理员 15521175608";
    //         exit;
    //     }
    //     $query = "SELECT * FROM shopdesc WHERE shopid = $shopid";
    //     $descres = $conn->query($query);
    // }

    // if($result->num_rows <= 0){
    //     echo "分类为空，请填写分类---><a href=\"addcatalog.php\" >去填写分类</a>";
    //     exit;
    // }
    // $result = db_result_to_array($result);

?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
        <link rel="stylesheet" href="css/main.css" />
        <script src="js/my.js"></script>
        <link rel="stylesheet" href="css/my.css" />
<!--<style>
    input[type=file]{
        display: none;
    }
    div img{
        margin: 2px 2px;
        height: 50px;
        width: 100px;
    }
    label img{
        height: 40px;
        width: 80px;
    }
    .prediv{
        background: #C4E1FF;
        height: 110px;
        width: 520px;
        margin-top: 10px;
        margin-bottom: 10px;
        border: 2px solid #009393;
    }
    form p{
        margin: 5px auto;
    }
    样式没改还用商品样式
</style>-->
    </head>
    <body>
        <div class="admin-main">

            <fieldset class="layui-elem-field">
                <legend>添加商家信息</legend>
                <div class="layui-field-box">
                <div class="goods">
    <form method="post" action="updateshopdb.php" enctype="multipart/form-data" onsubmit="return getElements()">

    <p><p><label for="name">商家名称：</label><input  type="text" id="name" name ="name"  /></p>
    <p><label for="phone">联系电话：</label><input type="text" id="phone" name="phone" /></p>
    <p><label for="runtime">营业时间：</label><input type="text" id="runtime" name="runtime" placeholder="8:00 - 18:00" /></p>
    <p><label for="address">门店地址：</label><input type="text" id="address" name="address" /></p>
    <p><label for="adv">滚动广告：</label><input type="text" id="adv" name="adv" /></p>
    <p><label for="title">介绍标题：</label><input type="text" id="title" name="title" /></p>
    <p><label for="content">介绍内容：</label><br /><textarea id="content" name="content" rows="10" cols="60"></textarea></p>
    <p><label for="img">展示图片(最多15张)</label><input type="button" class="button"  value="选择图片" onclick="btnAction('img')"><input type="file" id="img" name="img[]" multiple="multiple" onchange="readAsDataURL(this.files,'preags')" /></p>
    <div id="preags" class="prediv"></div>
    <p><input type="submit" class="button" value="更新信息" ></p>
    </form>
                </div>
    </div>
            </fieldset>
        </div>
    </body>
</html>
