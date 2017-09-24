<?php

function cvrimg($imgs,$imggoods){

    $images = array();

    
    if(!empty($imgs)){
      $imgs = explode('#',$imgs);
        for($i = 0;  $i < count($imgs); $i++){
          $img = $imggoods.$imgs[$i];
          if (@file_exists($img)){
            $size = GetImageSize($img);
            if(($size[0] > 0) && ($size[1] > 0)) {
                $images[$i] = $img;
            }
          }
        }
    }
    if(!empty($images))
        return $images;
    else
        return null;

}

ob_start();
require_once('admin_include_fns.php');

$error = null;
$conn = db_connect();
$companys = array();

$rid = $_SESSION['customer']['rid'];
if (isset($_POST['goodsID']) && count($_POST['goodsID']) > 0) {
    $goodsID = $_POST['goodsID'];
    $parameter = implode(',', $goodsID);

    
    
    $query = "SELECT * FROM goods WHERE goodsID in ( $parameter )";
    $result = $conn->query($query);
    if(!$result){
    	echo "SB了";
    	exit;
    }else{
    	$result = db_result_to_array($result);
    	$imgfile = array();
    	for ($i = 0; $i < count($result); $i++) {
    		$imgfile[] = cvrimg($result[$i]['gdswpimg'],$imggoods);
	    	$imgfile[] = cvrimg($result[$i]['detailsimg'],$imggoods);	
    		// var_dump($gdswpimg); 
       	}


       	$conn->autocommit(FALSE);
		$query = "DELETE FROM goods WHERE goodsID in ( $parameter )";
		$conn->query($query);
		if($conn->affected_rows <= 0)
			echo "60";
		if(!empty($imgfile)){
			foreach ($imgfile as  $imgfilea) {
				if(empty($imgfilea))
					continue;
	       		foreach ($imgfilea as $value) {
					if (@file_exists($value)){
						if(!unlink($value))
							$error = 67;
					}else{
						echo '不存在';
					}
	       		}
	       	}
		}


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
    }


}else{
	echo "请勾择要删除的商品";
	$url = 'delgoods.php';
	header('Refresh: 1; url=' . $url);
	exit;
}


ob_end_flush();
?>
