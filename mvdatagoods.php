<?php 
	require_once('db_fns.php');
	require_once('const.php');
	$rid = @$_GET['rid'];
	if(!$rid)
		exit;
	$conn = db_connect();
	$conn->query("set character set utf8");//读库
	$conn->query("set names utf8");//


	$query = "SELECT * FROM goods WHERE rid = $rid";
	$result = @$conn->query($query);
	if(!$result)
		exit;
	if (@$result->num_rows > 0) {
		$result = db_result_to_array($result);
		for($i = 0; $i < count($result); $i++){
			$goodsid = $result[$i]['goodsID'];
			$gdswpimg = explode('#',$result[$i]['gdswpimg']);
			$detailsimg = explode('#',$result[$i]['detailsimg']);
			foreach ($gdswpimg as  $value) {
				$query = "INSERT INTO goods_bar_img VALUES(NULL,$goodsid,'$value')";
				$conn ->query($query);
			}

			foreach ($detailsimg as  $value) {
				$query = "INSERT INTO goods_dtl_img VALUES(NULL,$goodsid,'$value')";
				$conn ->query($query);
			}
		}
		//var_dump($gdswpimg);

		//var_dump($detailsimg);
	}

?>