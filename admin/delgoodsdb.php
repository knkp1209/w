<?php


ob_start();
require_once('admin_include_fns.php');

$error = null;
$conn = db_connect();
$companys = array();

$rid = $_SESSION['customer']['rid'];
if (isset($_POST['goodsID']) && count($_POST['goodsID']) > 0) {
    $goodsID = $_POST['goodsID'];
    $parameter = implode(',', $goodsID);


    // 只会拿到该小程序的商品ID
    $query = "SELECT goodsID FROM goods WHERE goodsID in ( $parameter ) and rid = $rid";
    $goodsID = $conn->query($query);
    if(@!$goodsID && $goodsID->num_rows <= 0){
        echo "没ID,不用查";
    }
    $goodsIDtemp = db_result_to_array($goodsID);
    $goodsID = array();
    for($i = 0; $i < count($goodsIDtemp); $i++){
        $goodsID[] = $goodsIDtemp[$i]['goodsID'];
    }
    $parameter = implode(',', $goodsID);
    


    // 删除商品
   	$conn->autocommit(FALSE);
	$query = "DELETE FROM goods WHERE goodsID in ( $parameter )";
	$res = $conn->query($query);
	if(@!$res || $conn->affected_rows <= 0){
        $error = 35;
        exit;
    }


    // 获取商品有关广告图的名字
    $query = "SELECT name FROM goods_bar_img WHERE goodsid in ($parameter)";
    $barImg = $conn->query($query);
    if(@$barImg && $barImg->num_rows > 0){

        $barImgtemp = db_result_to_array($barImg);

        // 删除商品有关广告图记录
        $query = "DELETE FROM goods_bar_img WHERE goodsid in ( $parameter )";
        @$res = $conn->query($query);
        if(@!$res || $conn->affected_rows <= 0){
            // 删除失败，回滚
            $error = 48;
        }

        // 删除商品有关广告图文件
        for($j = 0; $j < count($barImgtemp); $j++){
            if (@file_exists($imggoods.$barImgtemp[$j]['name'])){
                // 在文件已存在的情况下删除文件
                if(!unlink($imggoods.$barImgtemp[$j]['name'])){
                    //删除失败，回滚
                    $error = 56;
                }
            }
        }
    }


    // 获取商品有关详情图的名字
    $query = "SELECT name FROM goods_dtl_img WHERE goodsid in ($parameter)";
    $dtlImg = $conn->query($query);
    if(@$dtlImg && $dtlImg->num_rows > 0){

        $dtlImgtemp = db_result_to_array($dtlImg);

        // 删除商品有关详情图记录
        $query = "DELETE FROM goods_dtl_img WHERE goodsid in ( $parameter )";
        $res = $conn->query($query);
        if(@!$res || $conn->affected_rows <= 0){
            // 删除失败，回滚
            $error = 46;
        }

        // 删除商品有关详情图文件
        for($j = 0; $j < count($dtlImgtemp); $j++){
            if (@file_exists($imggoods.$dtlImgtemp[$j]['name'])){
                // 在文件已存在的情况下删除文件
                if(!unlink($imggoods.$dtlImgtemp[$j]['name'])){
                    // 删除失败，回滚
                    $error = 81;
                }
            }
        }
    }

    // $error 为真则不提交
	if($error){
		echo $error;
	}else{
		$conn->commit();
		$conn->autocommit(TRUE);
		echo "删除成功";
		$url = 'delgoods.php';
		header('Refresh: 1; url=' . $url);
		exit;
	}
}else{
	echo "请勾择要删除的商品";
	$url = 'delgoods.php';
	header('Refresh: 1; url=' . $url);
	exit;
}


ob_end_flush();
?>
