<?php
require_once('../db_fns.php');
	require_once('const.php');
	require_once('function.php');
	$userid = @$_GET['userid'];
	$orderid = @$_GET['orderid'];
	if(!$userid)
		exit;
	$conn = db_connect();
	$conn->query("set character set utf8");//读库
	$conn->query("set names utf8");//

	if(empty($orderid)){
		$query = "SELECT * FROM order_table WHERE order_userinfoid = $userid ORDER BY order_date DESC";
		$result = @$conn->query($query);
		if(!$result)
			exit;
		if (@$result->num_rows > 0) {
			$result = db_result_to_array($result);
			for($i = 0; $i < count($result); $i++){
				$result[$i]['image'][] = 'https://'.$_SERVER['SERVER_NAME'].DIR.'/data/orderimg/'.$result[$i]['img'];
			}


			$result = array("result" => $result);
			echo json_encode($result);
		}
	}else{
		$query = "SELECT * FROM order_table WHERE order_userinfoid = $userid and order_id = $orderid";
		$result = @$conn->query($query);
		if(!$result)
			exit;
		if (@$result->num_rows == 1) {
			$result = db_result_to_array($result);
			for($i = 0; $i < count($result); $i++){
				$result[$i]['image'][] = 'https://'.$_SERVER['SERVER_NAME'].DIR.'/data/orderimg/'.$result[$i]['img'];
			}
			$result = array("result" => $result[0]);
			echo json_encode($result);
		}
	}
 ?>

