<?php 
// echo $_POST['datePicker'];

// echo $_POST['goodsid'];

// echo $_POST['name'];

// echo $_POST['number'];

// echo $_POST['phone'];

// echo $_POST['timePicker'];

// echo $_POST['userId'];

// echo $_POST['datePicker'];
// echo '<br />';
// 
function getRandOnlyId() {
    //新时间截定义,基于世界未日2012-12-21的时间戳。
    $endtime=1356019200;//2012-12-21时间戳
    $curtime=time();//当前时间戳
    $newtime=$curtime-$endtime;//新时间戳
    $rand=rand(0,99);//两位随机
    $all=$rand.$newtime;
    $onlyid=base_convert($all,10,36);//把10进制转为36进制的唯一ID
    return $onlyid;
}

$imggoods = 'data/goodsimg/';
$imgorder = 'data/orderimg/';
$orderid = null;
$msg = null;

function filled_out($form_vars) {
  // test that each variable has a value
  foreach ($form_vars as $key => $value) {
     if ((!isset($key)) || (trim($value) == '')) {
        return false;
     }
  }
  return true;
}

if(filled_out($_POST)){

	$rid = $_POST['rid'];
	$userid = $_POST['userId'];
	$customer = $_POST['name'];
	$phone = $_POST['phone'];
	$goodsid = $_POST['goodsid'];
	$number =  $_POST['number'];
	$form_date =  $_POST['datePicker'] . ' ' . $_POST['timePicker'];
	
	
	




	if(@$_POST['number'] <= 0){
		$msg =  "商品数量不能为0";
	}
	require_once('../db_fns.php');
	require_once('const.php');
	$conn = db_connect();
	$conn->query("set character set utf8");//读库
	$conn->query("set names utf8");//
	$query = "SELECT * FROM goods AS a,userinfo,goods_bar_img AS b WHERE a.goodsID = " . $goodsid. " AND a.gdnumber > 0 AND userid = " . $userid . " AND a.goodsID = b.goodsid LIMIT 0,1";


	$result = $conn->query($query);
	if($result->num_rows == 1){

		$row = $result->fetch_assoc();
		$repnum = $row['gdnumber'];
		$price = $row['price'];
		$goodsname = $row['gdname'];


		// 门店地址:
		$query = "SELECT address FROM shop where rid = $rid";
		$address = $conn->query($query);
		if(@$address && $address->num_rows == 1){
			$address = $address->fetch_assoc();
			$address = $address['address'];
		}else{
			$address = '商家暂未提供地址';
		}
		

		// 商品图片名字
		$img = $row['name'];
		// 订单图片名字
		$rname = getRandOnlyId().'.png';
		$amount = $number * $price;

		// $imgname = $row['gdswpimg'];


		if($number > $repnum ){
			$msg .=  "库存不足,";
		}

		
		date_default_timezone_set("PRC");  //设置时区
		if((strtotime($form_date) - strtotime(date("Y-m-d H:i:s"))) <= 0){
			$msg .=  "预约时间有误,";
		}





		$conn->autocommit(FALSE);
		$query = "INSERT INTO order_table VALUES(NULL,".$rid.",".$goodsid.",".$userid.",'".$customer."','".$phone."',NULL,".$number.",". $amount. "," ."'$form_date'". ",0," . "'$rname'". ",'$goodsname',".$price. ",'" .$address."')";



		$result = $conn->query($query);

		if (!$result || $conn->affected_rows <= 0) {
	       $msg .= "系统错误,";
		}



	    //insert_id if(自动ID)真：insert_id = 自动ID 假：insert_id = 0
	    $order_id = $conn->insert_id;
		if ($order_id != 0 && !($msg)) {
	    	$query = "SELECT * FROM order_table WHERE order_id = $order_id";
	    	$result = $conn->query($query);
			if($result->num_rows == 1){
				$orderid = $order_id;

				// 将商品图片移动到订单作为订单快照图片
				if(copy($imggoods.$img,$imgorder.$rname)){
					$conn->commit();
					$conn->autocommit(TRUE);
					$msg = "预约成功";
				}

			}
	    }else{
	    	$msg .= '预约失败,';
	    }
		
	}else{
		$msg .= "系统错误，请稍候再试。";
	}

}else{
	$msg .= "表单未填写完整,";
}

$result = array("result" => $orderid, "msg" => $msg );
echo json_encode($result);
?>
