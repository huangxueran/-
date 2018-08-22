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
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width,user-scal
able=0'/>
    <title>Document</title>
    <style type="text/css">
        *{
            margin:0;
            padding:0;
        }
        li{
            list-style:none;
        }
        ul{
            width:300px;
            margin:auto;
            box-shadow:0 0 10px #000;
        }
    </style>
</head>
<body>
<ul>
    <li>国家：中国<?php echo $country?></li>
    <li>城市：上海<?php echo $province?></li>
    <li>地区：东哇<?php echo $city?></li>
    <li>昵称：快乐<?php echo $nickname?></li>
    <li id='sex'>性别:<?php echo $sex?></li>
    <li>头像：<img src="<?php echo $img?>" alt="" width='300'/></li>
    <li> ~哈哈测试成功~ </li>
</ul>
<script type="text/javascript">
    window.onload = function() {
            var oSex = document.getElementById('sex');
            var str = oSex.innerHTML;
            var arr = str.split(':');

        if( arr[1] == 1 ){
            oSex.innerHTML = arr[0]+':男';
        }else{
            oSex.innerHTML = arr[0]+':女';
        }

        }
        </script>
</body>
</html>

