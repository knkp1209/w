<?php


require_once('../db_fns.php');
require_once('const.php');

$conn = db_connect();
$conn->query("set character set utf8");//读库
$conn->query("set names utf8");//写库

// 获取小程序标识
$rid = @$_GET['rid'];

if(!$rid){
    exit;
}

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
		$shop->content = html_entity_decode($row['content']);

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
			$shop->img[] = 'https://'.$_SERVER['SERVER_NAME'].DIR.'/data/shop/'.$result[$i]['url'];
		}
	}
	// var_dump($shop);
	
}

	echo json_encode($shop);


?>

