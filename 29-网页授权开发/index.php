<?php
header("Content-type: text/html; charset=utf-8");//声明编码
$appid = 'wxff630b0b0bd33a65';
$secret = 'a4467ffad3093fd2f4e6f948f2acfe3b';

// 1.	构建授权网址
$redirect_url = 'http://www.tanzhouweb.com/wx/auth/php/index.php';//用户实际访问的网址

$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode($redirect_url).'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect ';
//授权网址

echo '<br/>; - - - -换行操作- - - - <br/>';
echo $url,'<br>';
print_r($_GET);    // 根据appid获取code
echo '<br/>; - - - -换行操作- - - - <br/>';
?>

