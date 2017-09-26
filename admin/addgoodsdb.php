<?php
ob_start();

function uploadimg($file, $upload_path = "images/",$conn,$tb_name,$id)
{

    $name = $file['name'];      //得到文件名称，以数组的形式
    
    //当前位置
    if(is_array($name)){

        foreach ($name as $k => $names) {
            $type = strtolower(substr($names, strrpos($names, '.') + 1));//得到文件类型，并且都转化成小写
            $allow_type = array('jpg', 'jpeg', 'gif', 'png'); //定义允许上传的类型
            //把非法格式的图片去除
            if (!in_array($type, $allow_type)) {
                unset($name[$k]);
            }
        }

        $images = array();      // 上传图片的文件名数组
        foreach ($name as $k => $item) {
            $rname = getRandOnlyId() . $k .'.png';

            // 插入图片路径
            $query = "INSERT INTO $tb_name VALUES(NULL,$id,'$rname')";
            $result = $conn->query($query);

            if(!$result){
                return false;
            }

            // 插入失败则跳过 移动图片
            if($conn->affected_rows <= 0){
                continue;
            }


            $type = strtolower(substr($item, strrpos($item, '.') + 1));//得到文件类型，并且都转化成小写
            if (move_uploaded_file($file['tmp_name'][$k], $upload_path . $rname )) {
                $images[] = $rname;
            } else {
                return false;
            }
        }
    }

    return true;
}
require_once('admin_include_fns.php');

$conn = db_connect();
$conn->query("set character set utf8");//读库
$conn->query("set names utf8");//写库
$parameter = null;
$images = array();
$cat = array();
$imggoods;
$url = 'addgoods.php';
$rid = $_SESSION['customer']['rid'];
$img = false;



if (!empty($_FILES['agsfile']['tmp_name']) && !empty($_FILES['agdfile']['tmp_name'])){
    $img = true;
}

if (filled_out($_POST) && $img){
    
    // 查询该分类ID是否存在
    $catalogID = $_POST['catalogID'];
    $query = "SELECT * FROM catalog WHERE catalogID = $catalogID";
    $result = $conn->query($query);
    if(@!$result || $result->num_rows != 1){
        echo "系统错误，请稍候再试。（分类）";
        exit;
    }

    $gdname = $_POST['gdname'];
    $sprice = $_POST['sprice'];
    $price = $_POST['price'];
    $gdnumber = $_POST['gdnumber'];
    $unitname = $_POST['unitname'];
    

    $conn->autocommit(FALSE);
    // 插入商品信息
    $query = "INSERT INTO goods VALUES(null,$rid,$catalogID,'$gdname',$sprice,$price,$gdnumber,'$unitname')";
    $conn->query($query);

    $goodsid = $conn->insert_id;
    if($goodsid == 0 || $conn->affected_rows <= 0){
        echo '添加失败，商品!';
        header('Refresh: 1; url=' . $url);
        exit;
    }


    if(!uploadimg($_FILES['agsfile'],$imggoods,$conn,'goods_bar_img',$goodsid)){
        echo '添加失败，广告图片!';
        header('Refresh: 1; url=' . $url);
        exit;
    }

    if(!uploadimg($_FILES['agdfile'],$imggoods,$conn,'goods_dtl_img',$goodsid)){
        echo '添加失败，详情图片!';
        header('Refresh: 1; url=' . $url);
        exit;
    }

    $conn->commit();
    $conn->autocommit(TRUE);
    echo '添加成功！';
    header('Refresh: 1; url=' . $url);
    exit;
}


ob_end_flush();
?>