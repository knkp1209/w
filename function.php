<?php 
function goodsidcvrname($id){

    $conn = db_connect();
    $conn->query("set character set utf8");
    $conn->query("set names utf8");
    $query = "SELECT * FROM goods WHERE goodsID = $id";
    $result = $conn->query($query);
    $goods = $result->fetch_object();
    if(empty($goods)){
        return false;
    }
    return $goods;

}
?>
