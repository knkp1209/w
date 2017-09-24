<?php
ob_start();
require_once('admin_include_fns.php');

$conn = db_connect();
$conn->query("set character set utf8");//读库
$conn->query("set names utf8");//写库
$oldimages = array();  // 原来数据库图片文件名数组
$images = array();  // 图片文件名数组
$successful = false;

$rid = $_SESSION['customer']['rid'];


if (isset($_POST['oldimg'])) {
    for ($i = 0; $i < count($_POST['oldimg']); $i++)
        $oldimages[] = $_POST['oldimg'][$i];

    $query = '';
    foreach ($oldimages as $value) {
        $query .= " image = '" . $value . "' OR";
    }
    $query = substr($query, 0, strlen($query) - 3);



    $query = "DELETE FROM swpimg WHERE swpimgID not in (
		SELECT * FROM (
		SELECT swpimgID FROM swpimg WHERE " . $query .
        ") AS temp) AND rid = " . $rid;


    $result = $conn->query($query);
    if ($conn->affected_rows < 0)
        exit;
    else if ($conn->affected_rows > 0)
        $successful = true;
    else
        $successful = false;
} else {
    $query = "DELETE FROM swpimg WHERE rid = " . $rid;
    $result = $conn->query($query);
    if ($conn->affected_rows < 0)
        exit;
    else if ($conn->affected_rows > 0)
        $successful = true;
    else
        $successful = false;
}

if (!empty($_FILES['imagefile']))
    $images = uploadimage($_FILES['imagefile'], $imgindex);

$images = array_unique($images);   //去掉重复上传的图片
$images = array_diff($images, $oldimages);  //在上传图片数组中去掉数据库原有的图片
if (count($images) > 0) {
    $query = "INSERT INTO swpimg (rid,image) VALUES";
    foreach ($images as $value)
        $query .= "(".$rid.",'$value'),";

    $query = substr($query, 0, strlen($query) - 1);
    $result = $conn->query($query);
    if ($conn->affected_rows < 0)
        exit;
    else if ($conn->affected_rows > 0)
        $successful = true;
    else
        $successful = false;
}
if ($successful)
    echo "修改成功";
else
    echo "修改无效,图片已存在或者没改动";


header('Refresh: 1; url=swpimg.php');
exit;
ob_end_flush();
?>