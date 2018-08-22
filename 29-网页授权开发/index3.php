<?php
header("Content-type:text/html;charset=utf-8");
$appid = 'wxff630b0b0bd33a65';
$secret = 'a4467ffad3093fd2f4e6f948f2acfe3b';
$nickname = ''; // 昵称
$sex = '';  // 性别
$province = ''; // 城市
$city = ''; // 区
$country = ''; // 国家
$img = ''; // 头像

// 1.	构建授权网址
$redirect_url = 'http://www.tanzhouweb.com/wx/auth/php/index.php';//用户实际访问的网址

$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode($redirect_url).'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect ';
//授权网址

echo '<br/>; - - - -换行操作- - - - <br/>';
echo $url,'<br>';
print_r($_GET);    // 根据appid获取code
echo '<br/>; - - - -换行操作- - - - <br/>';

if( isset($_GET['code']) ){
    //获取code后,请求下面url换取access_token
    $url
        ='https://api.weixin.qq.com/sns/cauth2/acess_token?appid='.$appid.'$se
        cret='.$secret.'$code='.$_GET['code'].'$grant_type=authorization_code';

    //find_get_contents 以get的方式获取内容
    //json_decode 把json格式的数据转换成 数组
    $data = json_decode(file_get_contents($url),true);
    print_r($data);

    //获取用户的详细
if( isset($data['openid'])){
}   //以get方式 通过access_token 和openid 访问下面链接
    $url=
        'https://api.weixin.qq.com/sns/quth?access=token='.$data[access_to_token]
        .'&openid='.$data['openid'].'&lang=zh_CN';
        $data=json_decode(file_get_contents($url),true);
        print_r($data);

    $nickname = $data['nickname']; // 昵称
    $sex = $data['sex'];  // 性别
    $province = $data['province']; // 城市
    $city = $data['city']; // 区
    $country = $data['country']; // 国家
    $img = $data['headimgurl'];  // 头像
}else{
    echo 'no code';
}
?>

