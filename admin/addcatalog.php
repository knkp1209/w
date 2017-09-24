<?php
    session_start();
    require_once('admin_fns.php');
    if(!check_admin_user()){
      echo "你没有该权限";
      exit;
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/my.css" />
    <script src="js/my.js"></script>
</head>
<style>
/*#addcp p {
    text-align: left;
    padding-top: 2px;
    padding-bottom: 2px;
}

#addcp {
    width: 100%;
}

h1 {
    font-size: 1.5em;
    font-weight: bold;
    padding-bottom: 5px;
}

span {
    color: red;
}*/
</style>

<body>
    <div class="admin-main">
        <fieldset class="layui-elem-field">
            <legend>添加商品分类</legend>
            <div class="layui-field-box">
                <div style="width:40%; margin:0 auto; text-align: center">
                    <h1>添加商品分类</h1>
                    <span>图片要求尺寸（60 X 60）</span>
                    <form method="post" action="addcatdb.php" enctype="multipart/form-data" onsubmit="return getElements()" id="addcp">
                        <div id="catalog" class="divcat">
                            <p class="catlogo">
                                <label>分类图标：</label>
                                <input type="button" class="button btncat" value="选择图片" onclick="btnAction('catlogo')" />
                                <input id="catlogo" type="file" class="forminline" name="imagefile[]" onchange="readAsDataURL(this.files,'precat0')" />
                                <div id="precat0" class="precat"></div>
                            </p>
                            <p>
                                <label>分类名称：</label>
                                <input class="forminline btncatname" type="text" name="cat[]" />
                            </p>
                            <hr />
                            
                        </div>
                        <br />
                        <br />
                        <input id="addBtn" type="button" class="button btnaddcat" onclick="addcat()" value="继续添加商品分类" />
                        <input type="submit" class="button" value="提交" />
                   </div>
                <br />
                <br />
                </form>
            </div>
        </fieldset>
    </div>
</body>

</html>