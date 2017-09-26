<?php 
	require_once('db_fns.php');
	require_once('const.php');
	$rid = @$_GET['rid'];
	if(!$rid)
		exit;
	$conn = db_connect();
	$conn->query("set character set utf8");//读库
	$conn->query("set names utf8");//

	$query = "SELECT * FROM goods WHERE rid = $rid ORDER BY goodsID desc;";
	$result = @$conn->query($query);
	if(!$result)
		exit;
	if (@$result->num_rows > 0) {
		$result = db_result_to_array($result);
		for($i = 0; $i < count($result); $i++){
			// $gdswpimg = explode('#',$result[$i]['gdswpimg']);
			// $detailsimg = explode('#',$result[$i]['detailsimg']);
			$gdswpimg = array();
			$detailsimg = array();
			$goodsid = $result[$i]['goodsID'];

			// 获取商品广告图
			$query = "SELECT name FROM goods_bar_img WHERE goodsid = $goodsid";
			$barImg = $conn->query($query);
			if(@!$barImg || $barImg->num_rows <= 0){
				echo "系统错误，请稍候再试。";
			}
			$barImg = db_result_to_array($barImg);

			for($j = 0; $j < count($barImg); $j++){
				$gdswpimg[$j] = 'https://'.$_SERVER['SERVER_NAME'].DIR.'/data/goodsimg/'.$barImg[$j]['name'];
			}

			// 获取详情图
			$query = "SELECT name FROM goods_dtl_img WHERE goodsid = $goodsid";
			$dtlImg = $conn->query($query);
			if(@!$dtlImg || $dtlImg->num_rows <= 0){
				echo "系统错误，请稍候再试。";
			}
			$dtlImg = db_result_to_array($dtlImg);

			for($j = 0; $j < count($dtlImg); $j++){
				$detailsimg[$j] = 'https://'.$_SERVER['SERVER_NAME'].DIR.'/data/goodsimg/'.$dtlImg[$j]['name'];
			}

			$result[$i]['gdswpimg'] = $gdswpimg;
			$result[$i]['detailsimg'] = $detailsimg;

		}


		$result = array("result" => $result);
		echo json_encode($result);
	}
 ?>
