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
	if(@$_POST['number'] <= 0){
		$msg =  "商品数量不能为0";
	}
	require_once('db_fns.php');
	require_once('const.php');
	$conn = db_connect();
	$conn->query("set character set utf8");//读库
	$conn->query("set names utf8");//
	$query = "SELECT * FROM goods,userinfo WHERE goodsID = " . $_POST['goodsid'] . " AND gdnumber > 0 AND userid = " . $_POST['userId'];


	$result = $conn->query($query);
	if($result->num_rows == 1){
		$row = $result->fetch_assoc();
		if($_POST['number'] > $row['gdnumber']){
			$msg .=  "库存不足,";
		}
		// if($_POST['timePicker'] $_POST['datePicker'])
		$form_date =  $_POST['datePicker'] . ' ' . $_POST['timePicker'];
		
		date_default_timezone_set("PRC");  //设置时区
		if((strtotime($form_date) - strtotime(date("Y-m-d H:i:s"))) <= 0){
			$msg .=  "预约时间有误,";
		}

		$amount = $_POST['number'] * $row['price'];
		$conn->autocommit(FALSE);
		$query = "INSERT INTO order_table VALUES(NULL,".$_POST['rid'].",".$_POST['goodsid'].",".$_POST['userId'].",'".$_POST['name']."','".$_POST['phone']."',NULL,".$_POST['number'].",$amount,'$form_date',0)";


		$result = $conn->query($query);

		if (!$result) {
	       $msg .= "系统错误,";
		}
	    //insert_id if(自动ID)真：insert_id = 自动ID 假：insert_id = 0
	    $order_id = $conn->insert_id;
		if ($order_id != 0 && !($msg)) {
	    	$query = "SELECT * FROM order_table WHERE order_id = $order_id";
	    	$result = $conn->query($query);
			if($result->num_rows == 1){
				$orderid = $order_id;
				$conn->commit();
				$conn->autocommit(TRUE);
				$msg = "预约成功";
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
