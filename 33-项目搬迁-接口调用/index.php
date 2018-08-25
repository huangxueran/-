<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wxff630b0b0bd33a65", "65f55b1a909ce2aba7707db011326e18");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width,user-scalable=no'/>
		<title>TZ-追梦-微信接口测试2</title>
		<script>
			var html = document.querySelector('html');
			changeRem();
			window.addEventListener('resize',changeRem);
			function changeRem() {
				var width = html.getBoundingClientRect().width;
				html.style.fontSize = width/10+ 'px';
			}

		</script>	
		<title>微信实战</title>
		<link rel="stylesheet" href="css/index.css">
		<link rel="stylesheet" href="css/weui.css">
		<script src="js/swiper-3.4.1.min.js"></script>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
	</head>
	<body>

		<div id="banner" class="swiper-container">
			<ul class="swiper-wrapper">
				<li class='swiper-slide'><a href="javascript:;"><img src="img/banner/2.jpg" width="100%" height="100%" alt=""></a></li>
				<li class='swiper-slide'><a href="javascript:;"><img src="img/banner/1.jpg" width="100%" height="100%" alt=""></a></li>
				<li class='swiper-slide'><a href="javascript:;"><img src="img/banner/3.jpg" width="100%" height="100%" alt=""></a></li>
				<li class='swiper-slide'><a href="javascript:;"><img src="img/banner/4.jpg" width="100%" height="100%" alt=""></a></li>
			</ul>
			<div class="tab swiper-pagination"></div>
		</div>

		<div id="con">
			<div class="con-title">
				<div class="articeList on">文章列表</div>
				<div class="wx">微信应用</div>
			</div>
			<div class="contents">
				<div class="page newsList on" >
					<ul id="newSlist">
					</ul>
				</div>

				<div class="page wx-fn weui-grids">
					<a href="javascript:;" class="weui-grid">
						<div class="weui-grid__icon">
							<img src="img/icons/order.png" alt="">
						</div>
						<p class="weui-grid__label">个人档案</p>
					</a>
					<a href="javascript:;" class="weui-grid">
						<div class="weui-grid__icon">
							<img src="img/icons/picUpload.png" alt="">
						</div>
						<p class="weui-grid__label">图片拍照</p>
					</a>
					<a href="javascript:;" class="weui-grid">
						<div class="weui-grid__icon">
							<img src="img/icons/press.png" alt="">
						</div>
						<p class="weui-grid__label">我的帐单</p>
					</a>
					<a href="javascript:;" class="weui-grid" id='onMenuShareTimeline'>
						<div class="weui-grid__icon">
							<img src="img/icons/share.png" alt="">
						</div>
						<p class="weui-grid__label">精彩分享</p>
					</a>
					<a href="javascript:;" class="weui-grid" id='wxGame'>
						<div class="weui-grid__icon">
							<img src="img/icons/game.png" alt="">
						</div>
						<p class="weui-grid__label">娱乐游戏</p>
					</a>
					<a href="javascript:;" class="weui-grid">
						<div class="weui-grid__icon">
							<img src="img/icons/record.png" alt="">
						</div>
						<p class="weui-grid__label">录音翻译</p>
					</a>
					<a href="javascript:;" class="weui-grid" id='getLocation'>
						<div class="weui-grid__icon">
							<img src="img/icons/map.png" alt="">
						</div>
						<p class="weui-grid__label">实时地图</p>
					</a>
					<a href="javascript:;" class="weui-grid">
						<div class="weui-grid__icon">
							<img src="img/icons/check.png" alt="">
						</div>
						<p class="weui-grid__label">图片预览</p>
					</a>
					<a href="javascript:;" class="weui-grid" id='scanQRCode'>
						<div class="weui-grid__icon">
							<img src="img/icons/scan.png" alt="">
						</div>
						<p class="weui-grid__label">微信扫码</p>
					</a>
				</div>
			</div>
		</div>
		<div class="weui-tabbar">
			<a href="javascript:;" class="weui-tabbar__item weui-bar__item_on">
						<span style="display: inline-block;position: relative;">
							<img src="img/icons/weixin.png" alt="" class="weui-tabbar__icon">
							<span class="weui-badge" style="position: absolute;top: -2px;right: -13px;">8</span>
						</span>
				<p class="weui-tabbar__label">微信</p>
			</a>
			<a href="javascript:;" class="weui-tabbar__item">
				<img src="img/icons/addBook.png" alt="" class="weui-tabbar__icon">
				<p class="weui-tabbar__label">通讯录</p>
			</a>
			<a href="javascript:;" class="weui-tabbar__item" id="article">
						<span style="display: inline-block;position: relative;">
							<img src="img/icons/find.png" alt="" class="weui-tabbar__icon">
							<span class="weui-badge weui-badge_dot" style="position: absolute;top: 0;right: -6px;"></span>
						</span>
				<p class="weui-tabbar__label">发现</p>
			</a>
			<a href="javascript:;" class="weui-tabbar__item">
				<img src="img/icons/me.png" alt="" class="weui-tabbar__icon">
				<p class="weui-tabbar__label">我</p>
			</a>
		</div>

		<script>
			$newSlist = $('#newSlist');
			function formatterDateTime() {
				var date=new Date()
				var month=date.getMonth() + 1
				var datetime = date.getFullYear()
					+ ""// "年"
					+ (month >= 10 ? month : "0"+ month)
					+ ""// "月"
					+ (date.getDate() < 10 ? "0" + date.getDate() : date
						.getDate())
					+ ""
					+ (date.getHours() < 10 ? "0" + date.getHours() : date
						.getHours())
					+ ""
					+ (date.getMinutes() < 10 ? "0" + date.getMinutes() : date
						.getMinutes())
					+ ""
					+ (date.getSeconds() < 10 ? "0" + date.getSeconds() : date
						.getSeconds());
				return datetime;
			}
			$.ajax({
				type: 'post',
				url: 'https://route.showapi.com/181-1',
				dataType: 'jsonp',
				data: {
					"showapi_timestamp": formatterDateTime(),
					"showapi_appid": '37928', //这里需要改成自己的appid
					"showapi_sign": 'd0ca1605e19241c38849c3fb9a56b447',
					"num":20  //必须写    手机 邮箱 必须 验证

				},
				jsonp: 'jsonpcallback', //这个方法名很重要,不能改变
				error: function(XmlHttpRequest, textStatus, errorThrown) {
					alert("操作失败!");
				},
				success: function(data) {
					console.log(data);
					var aNews = data.showapi_res_body.newslist;
					var str = '';
					for( var i=0;i<aNews.length;i++ ){
						str +='<li>' +
						'<a href="'+aNews[i].url+'">' +
						'<div class="newImg">' +
						'<img src="'+aNews[i].picUrl+'" width="100%" height="100%" alt="">' +
						'</div>' +
						'<div class="newTitle">'+aNews[i].title+'</div>' +
						'<div class="newIcon"></div>' +
						'</a>' +
						'</li>';
					}

					$newSlist.html(str);
				}
			});
		</script>
		
		<script src='js/index.js'></script>
		<script>
			wx.config({
				appId: '<?php echo $signPackage["appId"];?>',
				timestamp: <?php echo $signPackage["timestamp"];?>,
				nonceStr: '<?php echo $signPackage["nonceStr"];?>',
				signature: '<?php echo $signPackage["signature"];?>',
				jsApiList: [
					// 所有要调用的 API 都要加到这个列表中
					'onMenuShareTimeline',
					'onMenuShareAppMessage',
					'onMenuShareQQ',
					'onMenuShareWeibo',
					'hideMenuItems',
					'showMenuItems',
					'hideAllNonBaseMenuItem',
					'showAllNonBaseMenuItem',
					'translateVoice',
					'startRecord',
					'stopRecord',
					'onRecordEnd',
					'playVoice',
					'pauseVoice',
					'stopVoice',
					'uploadVoice',
					'downloadVoice',
					'chooseImage',
					'previewImage',
					'uploadImage',
					'downloadImage',
					'getNetworkType',
					'openLocation',
					'getLocation',
					'hideOptionMenu',
					'showOptionMenu',
					'closeWindow',
					'scanQRCode',
					'chooseWXPay',
					'openProductSpecificView',
					'addCard',
					'chooseCard',
					'openCard'
				]
			});
			wx.ready(function () {
				
				// 微信扫码
				$('#scanQRCode').click(function(){
					wx.scanQRCode({
						needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
						scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
						success: function (res) {
							var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
						}
					});
				});

				
				// 地理位置
				$('#getLocation').click(function(){
					var lat,lon;
					wx.getLocation({
						success: function (res) {
						   var lat=res.latitude;
						   var lon=res.longitude;
							 wx.openLocation({
								latitude: lat,
								longitude: lon,
								name: '芯城科技园',
								address: '长沙市芯城科技园10栋',
								scale: 25,
								infoUrl: 'http://weixin.<a href="http://www.it165.net/qq/" target="_blank" class="keylink">qq</a>.com'
							});
							//alert(JSON.stringify(res));
						},
						cancel: function (res) {
							//alert('用户拒绝授权获取地理位置');
						},
						fail: function (res) { 
							//alert(JSON.stringify(res));
						}
					});
				});

				// 游戏	http://u.ali213.net/wxGame
				$('#wxGame').click(function(){
					window.location.href = 'http://u.ali213.net/games/sillyjump/index.html?game_code=937';
				});
				
				// 精彩分享
				//$().click(function(){});
				$('#onMenuShareTimeline').click(function(){
					wx.onMenuShareAppMessage({
						title: '追梦', // 分享标题
						link: 'www.tanzhouweb.com/wx/share.html', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
						imgUrl: 'http://y1.ifengimg.com/hdslide_newedtion/hdslide_logo_new.jpg', // 分享图标
						success: function () { 
							// 用户确认分享后执行的回调函数
							alert('哈哈~！自定义测试');
						}
					});
				});
			});
			

			wx.error(function(res){
				//alert( res );
			});
		</script>
	</body>
</html>
