<?php
ob_start();

// 包含文件里面有检查用户设置
require_once('admin_include_fns.php');

$conn = db_connect();
$conn->query("set character set utf8");//读库
$conn->query("set names utf8");//写库

// 获取小程序标识
$rid = $_SESSION['customer']['rid'];



function updateshopimg($file, $upload_path = "images/",$conn,$shopid)
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
            $query = "INSERT INTO shopimg VALUES(NULL,$shopid,'$rname')";
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

    return $images;
}
// $parameter = null;
// $images = array();
// $cat = array();
// $upload_path = $imggoods;


// // htmlentities
// $str =htmlentities($_POST['content']);
// // 空格替换成实体
// $str = str_replace(' ', "&nbsp;", $str);
// $str = nl2br($str);
// echo $str;

// var_dump($_POST);
// var_dump($_FILES);
// exit;
// $img = true;

// if (!empty($_FILES['agsfile']['tmp_name'])){
//     $imgags = uploadimage($_FILES['agsfile'], $upload_path);
// }else{
//     $img = false;
// }

// if (!empty($_FILES['agdfile']['tmp_name'])){
//     $imgagd = uploadimage($_FILES['agdfile'], $upload_path);
// }else{
//     $img = false;
// }


// 表单验证，为真通过
if (filled_out($_POST) && !empty($_FILES['img'])){

    // 查询该小程序是否忆存在商家信息
    $query = "SELECT id FROM shop WHERE rid = $rid";
    $result = $conn->query($query);


    if(!$result){
        echo '添加失败，系统错误!';
        $url = 'updateshop.php';
        header('Refresh: 1; url=' . $url);
        exit;
    }

    // 存在则更新
    if($result->num_rows == 1){

        // $query = "SELECT content FROM shopdesc where shopid = 21";
        // $result = $conn->query($query);
        // $row = $result->fetch_assoc();
        // echo $row['content'];
        
        // //updateshop($file, $upload_path = "images/");       
        // echo "有信息";
        // // $row = $result->fetch_assoc();
        //         if($shopid == 0 || $conn->affected_rows <= 0){
        echo '商家信息已填入，暂不支持修改';
        $url = 'updateshop.php';
        header('Refresh: 1; url=' . $url);
        exit;
    }
    else{

        $conn->autocommit(FALSE);
        // 插入商家信息
        $query = "INSERT INTO shop VALUES(NULL,$rid,'{$_POST['name']}','{$_POST['phone']}','{$_POST['runtime']}','{$_POST['address']}','{$_POST['adv']}')";
        $conn->query($query);

        $shopid = $conn->insert_id;
        if($shopid == 0 || $conn->affected_rows <= 0){
            echo '添加失败，商家!';
            $url = 'updateshop.php';
            header('Refresh: 1; url=' . $url);
            exit;
        }

        // 转换html代码
        $str =htmlentities($_POST['content']);
        // 空格替换成实体
        $str = str_replace(' ', "&nbsp;", $str);
        // \n 替换成 <br />
        $str = nl2br($str);

        $query = "INSERT INTO shopdesc VALUES(NULL,$shopid,'{$_POST['title']}','$str')";
        $conn->query($query);
        if($conn->insert_id == 0 || $conn->affected_rows <= 0){
            echo '添加失败，详情!';
            $url = 'updateshop.php';
            header('Refresh: 1; url=' . $url);
            exit;
        }

        if(!updateshopimg($_FILES['img'],$imgshop,$conn,$shopid)){
            echo '添加失败，图片!';
            $url = 'updateshop.php';
            header('Refresh: 1; url=' . $url);
            exit;
        }

    }
    $conn->commit();
    $conn->autocommit(TRUE);
    echo '添加成功！';
    $url = 'updateshop.php';
    header('Refresh: 1; url=' . $url);
    exit;
    
}

//     exit;
//     $catalogID = $_POST['catalogID'];
//     $gdname = $_POST['gdname'];
//     $sprice = $_POST['sprice'];
//     $price = $_POST['price'];
//     $gdswpimg = implode("#",$imgags);
//     $detailsimg = implode("#",$imgagd);
//     $gdnumber = $_POST['gdnumber'];
//     $unitname = $_POST['unitname'];
//     $query = "INSERT INTO goods VALUES(null,$rid,$catalogID,'$gdname',$sprice,$price,'$gdswpimg','$detailsimg',$gdnumber,'$unitname')";
//     $conn->query($query);
//     if ($conn->affected_rows < 0) {
//         echo '添加失败，系统错误!';
//         $url = 'addgoods.php';
//         header('Refresh: 1; url=' . $url);
//         exit;
//     } else if ($conn->affected_rows > 0) {
//         echo '添加成功';
//         $url = 'addgoods.php';
//         header('Refresh: 1; url=' . $url);
//         exit;
//     }
// }


ob_end_flush();
?>