<?php
/**
 * 发送post请求
 * @param string $url 请求地址
 * @param array $post_data post键值对数据
 * @return string
 */
require_once('db_fns.php');
require_once('const.php');
@$rid = $_GET['rid'];
if(!$rid)
  exit;

$conn = db_connect();
$conn->query("set character set utf8");//读库
$conn->query("set names utf8");
$query = "SELECT * from tenant WHERE rid = $rid";
@$result = $conn->query($query);
if (!$result) {
    exit;
}
if (@$result->num_rows == 1) { 
  $row = $result->fetch_assoc();
  @$secret = $row['secret'];
  @$appid = $row['appID'];
  if(empty($secret) || empty($appid)){
    echo "appid 或密钥为空";
    exit;
  }
}else{
  exit;
}


@$js_code = $_GET['code'];
function send_post($url, $post_data) {

  $postdata = http_build_query($post_data);
  $options = array(
    'http' => array(
      'method' => 'POST',
      'header' => 'Content-type:application/x-www-form-urlencoded',
      'content' => $postdata,
      'timeout' => 15 * 60 // 超时时间（单位:s）
    )
  );
  $context = stream_context_create($options);
  $result = file_get_contents($url, false, $context);

  return $result;
}

//使用方法
$post_data = array(
  'appid' => $appid,
  'secret' => $secret,
  'js_code' => $js_code,
  'grant_type' => 'authorization_code'
);

$weixin = send_post('https://api.weixin.qq.com/sns/jscode2session', $post_data);

$weixin = json_decode($weixin);
  if(@$weixin->openid){
    $openid = $weixin->openid;
  }else{
    echo "openid获取失败";
    exit;
  }

  $query_select = "SELECT * from userinfo where openid = '$openid' and rid = $rid";
  @$result = $conn->query($query_select);
  if (!$result) {
      exit;
  }
  if (@$result->num_rows == 1) { 
    $row = $result->fetch_assoc();
    $userid = $row['userid'];
  }else if(@$result->num_rows == 0){
    $query_insert = "INSERT INTO userinfo values(null,'$openid',$rid)";
    $conn->query($query_insert);
    if($conn->affected_rows > 0){
        @$result = $conn->query($query_select);
        if (!$result) {
            exit;
        }
        if (@$result->num_rows == 1) {
          $row = $result->fetch_assoc();
          $userid = $row['userid'];
        }
    }
  }else{
    echo "世纪大BUG";
    exit;
  }

  echo $userid;

?>