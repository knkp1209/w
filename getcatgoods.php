<?php 
	require_once('db_fns.php');
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
		$catsid = db_result_to_array($result);
	}

	$query = "SELECT * FROM goods WHERE rid = $rid";
	$result = @$conn->query($query);
	if(!$result)
		exit;
	if (@$result->num_rows > 0) {
		$result = db_result_to_array($result);
		for($i = 0; $i < count($result); $i++){
			$gdswpimg = explode('#',$result[$i]['gdswpimg']);
			$detailsimg = explode('#',$result[$i]['detailsimg']);
			for($j = 0; $j < count($gdswpimg); $j++){
				$gdswpimg[$j] = 'https://'.$_SERVER['SERVER_NAME'].DIR.'/data/goodsimg/'.$gdswpimg[$j];
			}
			for($j = 0; $j < count($detailsimg); $j++){
				$detailsimg[$j] = 'https://'.$_SERVER['SERVER_NAME'].DIR.'/data/goodsimg/'.$detailsimg[$j];
			}
			$result[$i]['gdswpimg'] = $gdswpimg;
			$result[$i]['detailsimg'] = $detailsimg;
			// $result[$i]['detailsimg'] = 'https://'.$_SERVER['SERVER_NAME'].'/data/goodsimg/'.$result[$i]['detailsimg'];

		}

		$goodscatsid = array();

		for($i = 0; $i < count($catsid); $i++){
            $goods = array();
            $cats = array();
            $cats = $catsid[$i];
			for($j = 0; $j < count($result); $j++){
				if($catsid[$i]['catalogID'] == $result[$j]['catalogID']){
					$goods[] = $result[$j];
				}
			}
            $cats['goods'] = $goods;
			$goodscatsid[] = $cats;
		}

	
		$result = array("result" => $goodscatsid);
		echo json_encode($result);
	}
 ?>
