<?php

function cvrimg($imgs,$imggoods){

    $images = array();

    
    if(!empty($imgs)){
      $imgs = explode('#',$imgs);
        for($i = 0;  $i < count($imgs); $i++){
          if (@file_exists($imggoods.$imgs[$i])){
            $size = GetImageSize($imggoods.$imgs[$i]);
            if(($size[0] > 0) && ($size[1] > 0)) {
                $images[$i] = $imgs[$i];
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

    
    
    $query = "SELECT * FROM goods";
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

        $newFile = $imggoods . 'backup/' ;
        mkdir($newFile);
        chmod($newFile,0777);  
        if(!empty($imgfile)){
            foreach ($imgfile as  $imgfilea) {
                if(empty($imgfilea))
                    continue;
                foreach ($imgfilea as $value) {
                    if (@file_exists($imggoods.$value)){
                        $a = $imggoods.$value;
                        $b = $newFile . $value;
                        copy($a,$b);
                    }else{
                        echo '不存在';
                    }
                }
            }
        }
    }
