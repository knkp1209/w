<?php
// This file contains functions used by the admin interface
// for the house-O-Rama shopping cart.
// 


function check_admin_user()
{
// see if somebody is logged in and notify them if not

    if (isset($_SESSION['customer'])) {
        return true;
    } else {
        return false;
    }
}

function filled_out($form_vars) {
  // test that each variable has a value
  foreach ($form_vars as $key => $value) {
     if ((!isset($key)) || ($value == '')) {
        return false;
     }
  }
  return true;
}



function uploadimage($file, $upload_path = "images/")
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
            $type = strtolower(substr($item, strrpos($item, '.') + 1));//得到文件类型，并且都转化成小写
            if (move_uploaded_file($file['tmp_name'][$k], $upload_path . $rname )) {
                $images[] = $rname;
            } else {
                return false;
            }
        }
    }else{

        $type = strtolower(substr($name,strrpos($name,'.')+1)); //得到文件类型，并且都转化成小写
        $allow_type = array('jpg','jpeg','gif','png'); //定义允许上传的类型
        //判断文件类型是否被允许上传
        if(!in_array($type, $allow_type)){
          return ;
        }
        if(!is_uploaded_file($file['tmp_name'])){
          //如果不是通过HTTP POST上传的
          return ;
        }
        //开始移动文件到相应的文件夹
        $images = array();      // 上传图片的文件名
        $rname = getRandOnlyId() . '.png';
        if(move_uploaded_file($file['tmp_name'],$upload_path.$rname)){
          $images = $rname;
        }else{
          return false;
        }
    }

    return $images;
}


function getRandOnlyId() {
    //新时间截定义,基于世界未日2012-12-21的时间戳。
    $endtime=1356019200;//2012-12-21时间戳
    $curtime=time();//当前时间戳
    $newtime=$curtime-$endtime;//新时间戳
    $rand=rand(0,99);//两位随机
    $all=$rand.$newtime;
    $onlyid=base_convert($all,10,36);//把10进制转为36进制的唯一ID
    return $onlyid;
}


function idcvrname($id){

    $conn = db_connect();
    $conn->query("set character set utf8");
    $conn->query("set names utf8");
    $query = "SELECT catname FROM catalog WHERE catalogID = $id";
    $result = $conn->query($query);
    $cat = $result->fetch_object();
    if(empty($cat->catname))
        exit;
    return $cat->catname;

}

function goodsidcvrname($id){

    $conn = db_connect();
    $conn->query("set character set utf8");
    $conn->query("set names utf8");
    $query = "SELECT gdname FROM goods WHERE goodsID = $id";
    $result = $conn->query($query);
    $goods = $result->fetch_object();
    if(empty($goods))
        return false;
    return $goods->gdname;

}

function idcvrimg($id,$num,$imggoods){

    $images = array();

    
    if(!empty($id)){
      $id = explode('#',$id);
        for($i = 0; $i < $num && $i < count($id); $i++){
          $img = $imggoods.$id[$i];
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

function ssimg($images,$stb,$std,$imgsrc){

    $showimg = "<table class=\"$stb\"><tr>";
    for($i = 0; $i < count($images); $i++){
        $showimg .= "<td class=\"$std\"><img src=\"{$images[$i]}\" height=\"60px\" width=\"120px\" ></td>";
    }
    $showimg .= '</tr></table>';

    return $showimg;
}

function dbselect($tbname,$field,$data){
    $conn = db_connect();
    $query = "SELECT * FROM $tbname WHERE $field = $data";
    $result = $conn->query($query);
    if (!$result) {
        return false;
    }
    $num = @$result->num_rows;
    if($num > 0)
        return true;
    else
        return false;
}
?>
