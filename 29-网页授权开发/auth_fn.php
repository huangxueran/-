<?php
    //网页授权函数


/*		把内容写入到文件
 */

function set_php_file($filename, $content) {
    $fp = fopen($filename, "w");	//fopen函数是在当前目录下打开一个文件 fopen（文件名,使用文件方式）
    fwrite($fp, "<?php exit();?>" . $content);
    fclose($fp);
}

/*      从文件中获取json内容
         param     $code   string      文件路径
 *         return      array()
  */
function get_php_file($filename) {
    return json_decode(trim(substr(file_get_contents($filename), 15)), true);
}

/*
 *      从微信获取 access token, refresh token, openid等信息
 *        param     $code   string      code
 *         return      array()             从微信获取到的信息
 */
function get_weixin($code) {
        global $auth_access_token_file;
        global $refresh_token_file;
        global $appid;
		global $secret;
		$url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
	
		$rs_a = json_decode(file_get_contents($url),true);
		
		//return $rs_a;
		//exit();
        // 保存 access tonken 
        $access_a = array();
        $access_a['access_token'] = $rs_a['access_token'];
        $access_a['expire'] = time() + 7000;            // access token有效时间7000秒
        $access_content = json_encode($access_a,JSON_FORCE_OBJECT);
        set_php_file($auth_access_token_file, $access_content);

        // 保存 refresh token
        $refresh_a = array();
        $refresh_a['refresh_token'] = $rs_a['refresh_token'];
        $refresh_a['expire'] = time() + 86400 * 7;      // refresh token有效时间7天
        $refresh__content = json_encode($refresh_a,JSON_FORCE_OBJECT);
        set_php_file($refresh_token_file, $refresh__content);

        return $rs_a;
}

/*
 *      通过 refresh 获取 access token 和 openid
 */
function get_refresh($refresh) {
	global $appid;
	$url='https://api.weixin.qq.com/sns/oauth2/refresh_token?appid='.$appid.'&grant_type=refresh_token&refresh_token='.$refresh;
	$rs_a = json_decode(file_get_contents($url),true);
    return $rs_a;
}

/*          return      array()             用户信息*/
//	获取用户信息
function get_userinfo($access_token, $openid) {
    $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
	$user_a = json_decode(file_get_contents($url),true);
	return $user_a;
}



function get_url_params($urlObj)
{
	$buff = "";
	foreach ($urlObj as $k => $v)
	{
			$buff .= $k . "=" . $v . "&";
	}
	$buff = trim($buff, "&");

	return $buff;
}

function create_auth_url($redirectUrl)
{
	global $appid;
	$urlObj["appid"] = $appid;
	$urlObj["redirect_uri"] = $redirectUrl;
	$urlObj["response_type"] = "code";
	$urlObj["scope"] = "snsapi_base";
	$urlObj["state"] = "STATE"."#wechat_redirect";
	$bizString = get_url_params($urlObj);
	return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
}


function check_token( $access_token,$openid ){
	//http：GET（请使用https协议） 
	$url = 'https://api.weixin.qq.com/sns/auth?access_token='.$access_token.'&openid='.$openid;
	$rs_a = json_decode(file_get_contents($url),true);
	if( 0 == $rs_a['errcode'] ){
		return true;
	}else{
		return false;
	}
}