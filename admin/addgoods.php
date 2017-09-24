<?php  
    require_once('admin_include_fns.php');
    $rid = $_SESSION['customer']['rid'];
    $conn = db_connect();
    $conn->query("set character set utf8");//读库
    $conn->query("set names utf8");//写库
    $query = "SELECT * FROM catalog WHERE rid = $rid";
    $result = $conn->query($query);
    if(!$result){
        echo "请联系管理员 15521175608";
        exit;
    }
    if($result->num_rows <= 0){
        echo "分类为空，请填写分类---><a href=\"addcatalog.php\" >去填写分类</a>";
        exit;
    }
    $result = db_result_to_array($result);

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
</style>-->
	</head>
    <body>
        <div class="admin-main">

            <fieldset class="layui-elem-field">
                <legend>添加商品分类</legend>
                <div class="layui-field-box">
                <div class="goods">
    <form method="post" action="addgoodsdb.php" enctype="multipart/form-data" onsubmit="return getElements()">

    <p><label for="agn">商品名称：</label><input id="agn" type="text" name="gdname" /></p>
    <p><label for="agc">选择分类：</label><select name="catalogID">
    <?php
        for($i = 0; $i < count($result); $i++){
            if($i == 0){
                echo '<option selected="selected" value="'.$result[$i]['catalogID'].'">'.$result[$i]['catname'].'</option>';
            }else{
                echo '<option  value="'.$result[$i]['catalogID'].'">'.$result[$i]['catname'].'</option>';
            }
        }
    ?>

</select></p>
    <p><label for="ags">商品原价：</label><input id="ags" type="text" name="sprice" /></p>
    <p><label for="agp">商品现价：</label><input id="agp" type="text" name="price"></p>
    <p><label for="agsimg">展示图片(最多15张)</label><input type="button" class="button logo"  value="选择图片" onclick="btnAction('agsimg')"><input type="file" id="agsimg" name="agsfile[]" multiple="multiple" onchange="readAsDataURL(this.files,'preags')" /></p>
    <div id="preags" class="prediv"></div>
    <p><label for="agdimg">详情图片(最多15张)</label><input type="button" class="button logo"  value="选择图片" onclick="btnAction('agdimg')"><input type="file" id="agdimg" name="agdfile[]" multiple="true" onchange="readAsDataURL(this.files,'preagd')" /></p>
    <div id="preagd" class="prediv"></div>
    <p><label for="adnum">库存数量：</label><input id="adnum" type="text" name="gdnumber"/></p>
    <p><label for="adu">单位名称：</label><input id="adu" type="text" name="unitname"/></p>
    <p><input type="submit" class="button" value="添加商品" ></p>
    </form>
                </div>
    </div>
            </fieldset>
        </div>
    </body>
</html>
