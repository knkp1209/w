<?php

ob_start();
require_once('admin_include_fns.php');

$error = null;
$conn = db_connect();
$companys = array();

$rid = $_SESSION['customer']['rid'];

    
    
    $query = "SELECT logo FROM tenant";
    $result = $conn->query($query);
    if(!$result){
    	echo "SB了";
    	exit;
    }else{
    	$result = db_result_to_array($result);
    	$imgfile = array();
    	for ($i = 0; $i < count($result); $i++) {
    		$imgfile[] = $result[$i]['logo'];
       	}

        $newFile = $imglogo . 'backup/' ;
        echo $newFile;
        mkdir($newFile);
        chmod($newFile,0777);  
        if(!empty($imgfile)){
            foreach ($imgfile as $value) {
                if(!$value)
                    continue;
                if (@file_exists($imglogo.$value)){
                    $a = $imglogo.$value;
                    $b = $newFile.$value;
                    copy($a,$b);
                }else{
                    echo '不存在';
                }
            }
        }
    }
