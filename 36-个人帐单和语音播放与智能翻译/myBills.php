<?php
	require_once "jssdk.php";
	$jssdk = new JSSDK("wxff630b0b0bd33a65", "85f7ab7425f8947a50194083c817e4a7");
	$signPackage = $jssdk->GetSignPackage();
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width,user-scalable=no'/>
		<title>我的帐单</title>
		<link rel="stylesheet" href="css/weui.css">
	</head>
	<body>
		<div class="weui-cells weui-cells_form" style='margin:-1px !important'>
			<div class="weui-cell" style='background:#000;color:white !important;'>
                <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
                    <img class='img' src="" style="width: 50px;display: block;">
                </div>
                <div class="weui-cell__bd">
                    <p class='nickname'>联系人名称</p>
                </div>
            </div>
			
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">qq</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="number" pattern="[0-9]*" placeholder="请输入qq号">
                </div>
            </div>
            <div class="weui-cell weui-cell_vcode">
                <div class="weui-cell__hd">
                    <label class="weui-label">手机号</label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="tel" placeholder="请输入手机号">
                </div>
                <div class="weui-cell__ft">
                    <button class="weui-vcode-btn">获取验证码</button>
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label for="" class="weui-label">日期</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="date" value="">
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label for="" class="weui-label">时间</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="datetime-local" value="" placeholder="">
                </div>
            </div>
            <div class="weui-cell weui-cell_vcode">
                <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="number" placeholder="请输入验证码">
                </div>
            </div>

			<div class="page__bd page__bd_spacing">
				<a href="javascript:;" class="weui-btn weui-btn_primary">提交~~</a>
			</div>
			<div id='box'></div>
        </div>

		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
		<script src="js/swiper-3.4.1.min.js"></script>

		<script type="text/javascript">
			$(function(){
				var str = window.location.href;
				
				//$('#box').html(str);
				
				function getVal(name){
					return decodeURI(str.match(new RegExp(name+"="+"([^&]*)(&|$)"))[1]);
				}
				
				$('.img').attr('src',getVal('img'));
				$('.nickname').html( getVal('Name') );
				
				
			});
		</script>
	</body>
</html>
