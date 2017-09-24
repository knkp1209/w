<?php
ob_start();

// 包含文件里面有检查用户设置
require_once('admin_include_fns.php');
const DIR = '/w/';
$conn = db_connect();
$conn->query("set character set utf8");//读库
$conn->query("set names utf8");//写库

// 获取小程序标识
$rid = $_SESSION['customer']['rid'];

// $shop=(object)array();

class Shop 
{  
    public $name;
    public $phone;
    public $runtime;
    public $address;
    public $Advertising;
    public $title;
    public $content;
    public $img = array();
  
    // public function getA()  
    // {  
    //      return $this->a;  
    // }  
} 


$shop = new Shop();
$query = "SELECT * FROM shop WHERE rid = $rid";
$result = @$conn->query($query);
if(!$result)
	exit;

if (@$result->num_rows == 1) {
	$row = $result->fetch_assoc();
	$shop->name = $row['name'];
	$shop->phone = $row['phone'];
	$shop->runtime = $row['runtime'];
	$shop->address = $row['address'];
	$shop->Advertising = $row['Advertising'];
	
	// echo '<br />';
	// echo $row['phone'];
	// echo '<br />';
	// echo $row['runtime'];
	// echo '<br />';
	// echo $row['address'];
	// echo '<br />';
	// echo $row['Advertising'];
	// echo '<br />';

	// 详情表关联的商家信息ID
	$shopid = $row['id'];

	// 根据商家信息ID查到属于该商家的简介
	$query = "SELECT * FROM shopdesc WHERE shopid = $shopid";
	$result = @$conn->query($query);
	if(!$result)
		exit;
	if (@$result->num_rows == 1) {
		$row = $result->fetch_assoc();
		$shop->title = $row['title'];
		$shop->content = $row['content'];

		// echo $row['title'];
		// echo '<br />';
		// echo $row['content'];
		// echo '<br />';
	}

	// 根据商家信息ID查到属于该商家的门店照片
	$query = "SELECT * FROM shopimg WHERE shopid = $shopid";
	$result = @$conn->query($query);
	
	if(!$result)
		exit;

	if (@$result->num_rows > 0) {
			$result = db_result_to_array($result);
		for($i = 0; $i < count($result); $i++){
			// $result[$i]['image'] = 'https://'.$_SERVER['SERVER_NAME'].DIR.'/data/shop/'.$result[$i]['url'];
			$shop->img[] = 'http://'.$_SERVER['SERVER_NAME'].DIR.'/data/shop/'.$result[$i]['url'];
		}
	}
	// var_dump($shop);
	
}
// if (@$result->num_rows > 0) {
// 	$result = db_result_to_array($result);
// 	for($i = 0; $i < count($result); $i++){
// 		$result[$i]['image'] = 'https://'.$_SERVER['SERVER_NAME'].DIR.'/data/swpimg/'.$result[$i]['image'];
		

// 	}


// 	$result = array("result" => $result);
	// echo json_encode($shop);
// }
//
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
                <legend>商家信息</legend>
                <div class="layui-field-box">
                <div class="goods">
    <form method="post" action="updateshopdb.php" enctype="multipart/form-data" onsubmit="return getElements()">

    <p><p><label for="name">商家名称：</label><input  type="text" id="name" name ="name" disabled= "true" value="<?php echo $shop->name ?>" /></p>
    <p><label for="phone">联系电话：</label><input type="text" id="phone" name="phone" disabled= "true" value="<?php echo $shop->phone ?>" /></p>
    <p><label for="runtime">营业时间：</label><input type="text" id="runtime" name="runtime" placeholder="8:00 - 18:00" disabled= "true" value="<?php echo $shop->runtime?>"/></p>
    <p><label for="address">门店地址：</label><input type="text" id="address" name="address" disabled= "true" value="<?php echo $shop->address ?>"/></p>
    <p><label for="adv">滚动广告：</label><input type="text" id="adv" name="adv" disabled= "true" value="<?php echo $shop->Advertising ?>"/></p>
    <p><label for="title">介绍标题：</label><input type="text" id="title" name="title" disabled= "true" value="<?php echo $shop->title ?>"/></p>
    <p><label for="content">介绍内容：</label><br /><textarea id="content" name="content" rows="10" cols="60" disabled= "true"><?php echo $shop->content ?></textarea></p>
<!--     <p><label for="img">展示图片(最多15张)</label><input type="button" class="button"  value="选择图片" onclick="btnAction('img')"><input type="file" id="img" name="img[]" multiple="multiple" onchange="readAsDataURL(this.files,'preags')" /></p> -->
	<p>门店照片：</p>
    <div id="preags" class="prediv">
    	<?php 
    		foreach ($shop->img as $value) {
    			echo "<img src=\"$value\" />";
    		}
    	?>
    </div>
    <!-- <p><input type="submit" class="button" value="更新信息" ></p> -->
    </form>
                </div>
    </div>
            </fieldset>
        </div>
    </body>
</html>
<?php
ob_end_flush();
?>

