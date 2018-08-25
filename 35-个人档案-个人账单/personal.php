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
		<title>个人中心</title>
		<link rel="stylesheet" href="css/weui.css">
	</head>
	<body>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
                    <img class='img' src="" style="width: 50px;display: block;">
                </div>
                <div class="weui-cell__bd">
                    <p class='nickname'>联系人名称</p>
                    <p style="font-size: 13px;color: #888888;">微信号不告诉你^_^</p>
                </div>
            </div>

            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd">
                    <span style="vertical-align: middle">国家</span>
                </div>
                <div class="country" >详细信息</div>
            </div>

			<div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd">
                    <span style="vertical-align: middle">城市</span>
                </div>
                <div class="province">详细信息</div>
            </div>

			<div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd">
                    <span style="vertical-align: middle">地区</span>
                </div>
                <div class="city">详细信息</div>
            </div>

			<div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd">
                    <span style="vertical-align: middle">性别</span>
                </div>
                <div class="sex">详细信息</div>
            </div>

			<div class="page__bd page__bd_spacing">
				<a href="javascript:;" class="weui-btn weui-btn_primary">哈哈，获取你的信息啦~~</a>
			</div>
			<div id='box'></div>
        </div>

		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
		<script src="js/swiper-3.4.1.min.js"></script>

		<script type="text/javascript">
			wx.config({
				
				appId: '<?php echo $signPackage["appId"];?>',
				timestamp: <?php echo $signPackage["timestamp"];?>,
				nonceStr: '<?php echo $signPackage["nonceStr"];?>',
				signature: '<?php echo $signPackage["signature"];?>',
				jsApiList: [
					// 所有要调用的 API 都要加到这个列表中
					
				]
			});

			
			$(document).ready(function(){
				var str = window.location.href;
				//$('#box').html(str);
				
				function getVal(name){
					return decodeURI(str.match(new RegExp(name+"="+"([^&]*)(&|$)"))[1]);
				}
				
				$('.country').html( getVal('country') );
				$('.province').html( getVal('province') );
				$('.city').html( getVal('city') );
				$('.nickname').html( getVal('nickname') );
				$('.sex').html( (getVal('sex')==='1')?'男':'女' );
				$('.img').attr('src',getVal('img') );
			});
		</script>
	</body>
</html>
