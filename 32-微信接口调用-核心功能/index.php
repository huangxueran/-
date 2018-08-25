<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wxff630b0b0bd33a65", "a1d778c200f6b7bfdc77c6ddaa829d39");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width,user-scalable=no'/>
		<title>TZ-追梦-微信接口测试</title>
		<style type="text/css">
			*{margin:0;}
			body{
				text-align:center;
			}
		</style>	
	</head>
	<body>
		<input type="button" id='getNetworkType' value='获取网络状况'/><br />
		<input type="button" id='scanQRCode' value='微信扫一扫'/><br />
		<input type="button" id='getLocation' value='地图'/><br />
		<input type="button" id="startRecord" value="开始录音"><br />
		<input type="button" id="stopRecord" value="停止录音"><br />
		<input type="button" id="playVoice" value="播放音频"><br />
		<input type="button" id="pauseVoice" value="暂停播放音频"><br />
		<input type="button" id="stopVoice" value="停止播放音频"><br />
		<input type="button" id='chooseImage' value='图像接口'/>
		
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
		<script src='index.js'></script>
		<script>
			wx.config({
				debug: true,
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
				// 在这里调用 API
				
				$('#getNetworkType').click(function(){
					wx.getNetworkType({
						success: function (res) {
							var networkType = res.networkType; // 返回网络类型2g，3g，4g，wifi
						}
					});
				});
				
				$('#scanQRCode').click(function(){
					wx.scanQRCode({
						needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
						scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
						success: function (res) {
							var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
						}
					});
				});
				
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
                                address: '长沙市河西麓谷大道662号',
                                scale: 14,
                                infoUrl: 'http://weixin.<a href="http://www.it165.net/qq/" target="_blank" class="keylink">qq</a>.com'
                            });
                            alert(JSON.stringify(res));
                        },
                        cancel: function (res) {
                            alert('用户拒绝授权获取地理位置');
                        },
                        fail: function (res) {
                            alert(JSON.stringify(res));
                        }
                    });
				});
				
				// 4 音频接口
				 // 4.2 开始录音
				document.querySelector('#startRecord').onclick = function () {
					 wx.startRecord({
						cancel: function () {
							alert('用户拒绝授权录音');
						}
					 });
				 };

				 // 4.3 停止录音
				 document.querySelector('#stopRecord').onclick = function () {
					 wx.stopRecord({
						 success: function (res) {
							 voice.localId = res.localId;
						 },
						 fail: function (res) {
							 alert(JSON.stringify(res));
						 }
					 });
				 };

				 // 4.4 监听录音自动停止
				 wx.onVoiceRecordEnd({
					 complete: function (res) {
						 voice.localId = res.localId;
						 alert('录音时间已超过一分钟');
					 }
				 });

				 // 4.5 播放音频
				 document.querySelector('#playVoice').onclick = function () {
					 if (voice.localId == '') {
						 alert('请先使用 startRecord 接口录制一段声音');
						 return;
					 }
					 wx.playVoice({
						 localId: voice.localId
					 });
				 };

				 // 4.6 暂停播放音频
				 document.querySelector('#pauseVoice').onclick = function () {
					 wx.pauseVoice({
						 localId: voice.localId
					 });
				 };

				 // 4.7 停止播放音频
				 document.querySelector('#stopVoice').onclick = function () {
					 wx.stopVoice({
						 localId: voice.localId
					 });
				 };
				
				$('#chooseImage').click(function(){
					wx.chooseImage({
						count: 1, // 默认9
						sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
						sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
						success: function (res) {
							var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
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
