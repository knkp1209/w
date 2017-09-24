<?php
/**
 * 发送post请求
 * @param string $url 请求地址
 * @param array $post_data post键值对数据
 * @return string
 */

@$number = '15521175608';
function send_post($url, $post_data) {

  $postdata = http_build_query($post_data);
  $options = array(
    'http' => array(
      'method' => 'GET',
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
  'account' => 'BoQiECSH',
  'password' => '877831433',
  'mobile' => $number,
  'content' => '您的订单编码：888888。如需帮助请联系客服。'
);
echo send_post('http://sms.106jiekou.com/utf8/sms.aspx', $post_data);

?>