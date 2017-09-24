<?php
ob_start();
require_once('admin_include_fns.php');

$conn = db_connect();
$conn->query("set character set utf8");//读库
$conn->query("set names utf8");//写库
$parameter = null;
$images = array();
$cat = array();
$upload_path = $imgcat;
$rid = $_SESSION['customer']['rid'];

if (!empty($_FILES['imagefile']))
    $images = uploadimage($_FILES['imagefile'], $upload_path);
if (isset($_POST['cat']) && count($_POST['cat']) > 0)
    $cat = $_POST['cat'];


if (count($images) > 0  && count($images) == count($cat)) {

    for ($i = 0; $i < count($images); $i++) {
        $parameter .= "('$rid','{$cat[$i]}','{$images[$i]}'),";
    }
    $parameter = substr($parameter, 0, -1);
    $query = 'INSERT INTO catalog (rid,catname,image) VALUES ' . $parameter;
    $result = $conn->query($query);
    if ($conn->affected_rows < 0) {
        echo '添加失败，系统错误!';
        $url = 'addcatalog.php';
        header('Refresh: 1; url=' . $url);
        exit;
    } else if ($conn->affected_rows > 0) {
        echo '添加成功';
        $url = 'addcatalog.php';
        header('Refresh: 1; url=' . $url);
        exit;
    }
}


ob_end_flush();
?>