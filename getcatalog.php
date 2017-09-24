<?php 
	require_once('db_fns.php');
	require_once('const.php');
	$rid = @$_GET['rid'];
	if(!$rid)
		exit;
	$conn = db_connect();
	$conn->query("set character set utf8");//读库
	$conn->query("set names utf8");//

	$query = "SELECT * FROM catalog WHERE rid = $rid";
	$result = @$conn->query($query);
	if(!$result)
		exit;
	if (@$result->num_rows > 0) {
		$result = db_result_to_array($result);
		for($i = 0; $i < count($result); $i++){
			$result[$i]['image'] = 'https://'.$_SERVER['SERVER_NAME'].DIR.'data/catimg/'.$result[$i]['image'];

		}


		$result = array("result" => $result);
		echo json_encode($result);
	}
 ?>
