<?php
class catgoods 
{  
    public $catalogID;
    public $catname;
    public $goodss = array(); 
}

class goods
{
	public $goodsID;
	public $catalogID;
	public $gdname;
	public $image;
} 
require_once('../db_fns.php');
require_once('const.php');

$rid = @$_GET['rid'];
if(!$rid)
	exit;
$conn = db_connect();
$conn->query("set character set utf8");//读库
$conn->query("set names utf8");//

$query = "SELECT catalogID,catname FROM catalog WHERE rid = $rid";
$result = @$conn->query($query);
if(!$result)
	exit;
if (@$result->num_rows > 0) {
	$cats = db_result_to_array($result);
}

$query = "SELECT goodsID,gdname,catalogID FROM goods WHERE rid = $rid";
$result = @$conn->query($query);
if(!$result)
	exit;
if (@$result->num_rows > 0) {
	$result = db_result_to_array($result);
	$allGoods = array();
	for($i = 0; $i < count($result); $i++){

		$goods = new goods();
		$id = $result[$i]['goodsID'];
		$catid = $result[$i]['catalogID'];
		$name = $result[$i]['gdname'];

		$goods->goodsID = $id;
		$goods->catalogID = $catid;
		$goods->gdname = $name;
		// 获取商品广告图
		$query = "SELECT name FROM goods_bar_img WHERE goodsid = $id LIMIT 0,1";
		$barImg = $conn->query($query);
		if(@$barImg && $barImg->num_rows == 1){
			$row = $barImg->fetch_assoc();
			$goods->image = 'https://'.$_SERVER['SERVER_NAME'].DIR.'/data/goodsimg/'.$row['name'];
		}else{
			echo "系统错误";
		}

		$allGoods[] = $goods;
	}


	$goodscatsid = array();

	for($i = 0; $i < count($cats); $i++){

		$arrCatgoods = new catgoods();
    	$arrCatgoods->catalogID = $cats[$i]['catalogID'];
    	$arrCatgoods->catname = $cats[$i]['catname'];
    	$arrCatgoods->goodss = array();
		for($j = 0; $j < count($allGoods); $j++){
			if($cats[$i]['catalogID'] == $allGoods[$j]->catalogID){
				$arrCatgoods->goodss[] = $allGoods[$j];
			}
		}
		$goodscatsid[] = $arrCatgoods;
	}

	
	$result = array("result" => $goodscatsid);
	echo json_encode($result);
}
 ?>
