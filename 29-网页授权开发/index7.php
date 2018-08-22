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
    $access_a = get_php_file($auth_access_token_file);
    print_r($access_a);

    if( $access_a['expire'] < time() ){
        // 从微信获取
        $data_a = get_weixin( $_GET['code'] );
        //echo '<br>----0-----<br>';
        print_r($data_a);
        //echo '<br>----0-----<br>';
        $userinfo = get_userinfo($data_a['access_token'],$data_a['openid']);
        print_r($userinfo);
        //echo '<br>----1-----<br>';
    }else{
        // 用refresh获取
        $refresh_a = get_php_file($refresh_token_file);
        //echo '<br>----else-----<br>';
        print_r($refresh_a);
        //echo '<br>----else-----<br>';

        if( $refresh_a['expire'] < 0 ){
            $data_a = get_weixin( $_GET['code'] );
            $userinfo = get_userinfo($data_a['access_token'],$data_a['openid']);
            print_r($userinfo);
        }else{
            $data_a = get_refresh( $refresh_a['refresh_token'] );
            //echo '<br>----1111-----<br>';
            print_r($data_a);
            //echo '<br>----1111-----<br>';
            $userinfo = get_userinfo($data_a['access_token'],$data_a['openid']);
            //echo '<br>----2222-----<br>';
            print_r($userinfo);
            //echo '<br>----2222-----<br>';
            if( check_token($data_a['access_token'],$data_a['openid']) ){
                echo '<br/>access_token是在有效期内';
            }
        }
    }
}else{
    //echo 'no code<br/>';
    //echo '<br>',$_SERVER['HTTP_HOST'],'<br>';
    //echo '<br>',$_SERVER['PHP_SELF'],'<br>';

    // 1. 用户实际访问的网址

    $url = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
    //echo '<br>',$url,'<br>';

    // 2. 转换成授权网址
    $url = create_auth_url($url);
    //echo '<br>',$url,'<br>';

    // 3. 自动跳转授权网址
    header('location:'.$url);
}
?>
