<?php
ob_start();
require_once('admin_include_fns.php');

$conn = db_connect();
$conn->query("set character set utf8");//读库
$conn->query("set names utf8");//写库
$parameter = null;
$images = array();
$cat = array();
$upload_path = $imggoods;
$rid = $_SESSION['customer']['rid'];
$img = true;

if (!empty($_FILES['agsfile']['tmp_name'])){
    $imgags = uploadimage($_FILES['agsfile'], $upload_path);
}else{
    $img = false;
}

if (!empty($_FILES['agdfile']['tmp_name'])){
    $imgagd = uploadimage($_FILES['agdfile'], $upload_path);
}else{
    $img = false;
}

if (filled_out($_POST) && $img){
    $catalogID = $_POST['catalogID'];
    $gdname = $_POST['gdname'];
    $sprice = $_POST['sprice'];
    $price = $_POST['price'];
    $gdswpimg = implode("#",$imgags);
    $detailsimg = implode("#",$imgagd);
    $gdnumber = $_POST['gdnumber'];
    $unitname = $_POST['unitname'];
    $query = "INSERT INTO goods VALUES(null,$rid,$catalogID,'$gdname',$sprice,$price,'$gdswpimg','$detailsimg',$gdnumber,'$unitname')";
    $conn->query($query);
    if ($conn->affected_rows < 0) {
        echo '添加失败，系统错误!';
        $url = 'addgoods.php';
        header('Refresh: 1; url=' . $url);
        exit;
    } else if ($conn->affected_rows > 0) {
        echo '添加成功';
        $url = 'addgoods.php';
        header('Refresh: 1; url=' . $url);
        exit;
    }
}


ob_end_flush();
?>