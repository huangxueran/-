<?php
header("Content-type: text/html; charset=utf-8");//声明编码


include('auth_fn.php');
$appid = 'wxff630b0b0bd33a65';
$secret = 'a4467ffad3093fd2f4e6f948f2acfe3b';

// 保存 token 的文件
$auth_access_token_file = 'auth_access_token.php';
$refresh_token_file = 'refresh_token.php';


// 1.	构建授权网址
$redirect_url = 'http://www.tanzhouweb.com/wx/auth/php/index.php';//用户实际访问的网址
$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode($redirect_url).'
	&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect '; //授权网址

//echo $url,'<br>';
//print_r($_GET);    // 根据appid获取code
//exit();

if( isset($_GET['code']) ){
    // 从微信获取
    $data_a = get_weixin( $_GET['code'] );
    echo '<br>----0-----<br>';
    print_r($data_a);
    echo '<br>----0-----<br>';
    $userinfo = get_userinfo($data_a['access_token'],$data_a['openid']);
    print_r($userinfo);
    echo '<br>----1-----<br>';
}else{
    echo 'no code</<br>';
}

