<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wxff630b0b0bd33a65", "85f7ab7425f8947a50194083c817e4a7");
$signPackage = $jssdk->GetSignPackage();
?>
<! DOCTYPE HTML>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
	<script>
		var html = document.querySelector('html');
		changeRem();
		window.addEventListener('resize',changeRem);
		function changeRem() {
			var width = html.getBoundingClientRect().width;
			html.style.fontSize = width/10+ 'px';
		}
		
	</script>	
    <title>录音播放</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">

    <link rel="stylesheet" href="http://demo.open.weixin.qq.com/jssdk/css/style.css?ts=1420774989">
    <link rel="stylesheet" href="css/weui.css"/>
    <style>

        * { margin: 0; padding: 0; list-style: none;}

        body{
               background-color: #f1f0f6;
        }

        .container-record {
        }

        .loadingToast, .weui-toast {
            font-size: 0.4rem;
        }

        .container-record .content {
            padding-bottom:2rem;
        }

        .send-box {
            width: 94%;
            height: 2rem;
            padding:0.5rem 0px 0px 0px;
            position: relative;
            color: #666;
        }
        .send-box .timing{
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            margin:auto;
            padding:auto;
            text-align: center;
            font-size: 0.3rem;
        }
        .send-box .avatar {
            float: right;
            width: 1rem;
            height: 1rem;
            overflow: hidden;
            margin:0.5rem 0;
            border-radius: 0.1rem;
            box-shadow: 0 0 1px #000000;
            vertical-align: middle;
        }

        .send-box .avatar img {
            display: block;
            width: 1rem;
            height: 1rem;
            border-radius: 0.1rem;
        }

        .send {
            position: relative;
            float: right;
            margin: 0.6rem;
            width: 3rem;
            height: 0.9rem;
            background: #9eea6a;
            border-radius: 5px; /* 圆角 */
            vertical-align: middle;
        }
        .send .duration{
            position: absolute;
            left:-0.4rem;
            bottom:0.1rem;
            font-size:0.3rem
        }
        .send .message {
            padding: 0 0.3rem;
            height:0.9rem;
            text-indent: 0.2rem;
            display:flex;
            justify-content: flex-end;
            align-items: center;
        }
        .send .message img{
            width: 0.6rem;
            height: 0.6rem;
            padding:0 .1rem;
        }
        .send .arrow {
            position: absolute;
            top: 5px;
            right: -16px; /* 圆角的位置需要细心调试哦 */
            width: 0;
            height: 0;
            font-size: 0;
            border: solid 8px;
            border-color: transparent transparent transparent #9eea6a;
        }

        .recording {
            position: fixed;
            bottom: 0;
            z-index: 999;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 2rem;
            width: 100%;
            background-color: #f1f0f6;
        }

        .recording img {
            width: 2rem;
            height: 2rem;
        }
        .text-node{
            width: 100%;
            margin-top:0.2rem;
            padding:0.2rem 0;
            line-height:0.5rem;
            position: relative;
            color: #666;
            font-size:0.5rem;
            text-align:center;
            background:#434343;
        }

    </style>
</head>
<body>
	<div class="container-record">
		<section class="content">
		
		</section>
	</div>
	<div id="loadingToast" style="opacity: 0; display: none;">
		<div class="weui-mask_transparent"></div>
		<div class="weui-toast">
			<i class="weui-loading weui-icon_toast"></i>
			<p class="weui-toast__content"></p>
		</div>
	</div>
	<footer class="recording">
		<div class="record-button" id='record'><img src="img/icons/recording.png" alt=""></div>
	</footer>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script>
		
		$(document).ready(function () {
			
			var user = {};
			var str = window.location.href;
			if ((/url=(\S*)/).test(str)) {
			   // var name = str.match(/name=(\S*)/)[1];
				user.url = str.match(/url=(\S*)/)[1];
				//alert(user.url)
			}
    
			wx.config({
				appId: '<?php echo $signPackage["appId"];?>',
				timestamp: <?php echo $signPackage["timestamp"];?>,
				nonceStr: '<?php echo $signPackage["nonceStr"];?>',
				signature: '<?php echo $signPackage["signature"];?>',
				jsApiList: [
					'checkJsApi',        //检测客户端是否支持jssdk接口
					'startRecord',       //开始录音接口
					'stopRecord',         //停止录音接口
					'onVoiceRecordEnd',     //监听录音自动停止接口
					'playVoice',           //语音播放接口
					'pauseVoice',         //暂停播放接口
					'stopVoice',          //停止播放接口
					'onVoicePlayEnd',      //监听语音播放完毕接口
					'uploadVoice',       //上传语音接口
					'uploadVoice',       //下载语音接口
					'translateVoice',        //智能识别接口
					'showAllNonBaseMenuItem'    //显示所有功能性接口
				]
			});
			var record = document.querySelector('#record');
			var recordIco = record.querySelector('img')
			var content = document.querySelector('.content');
			var sendBox;
			var nowTime = 0;
			var soundWidth = 1;
			var nowIndex = 0;
			var voice = {
				localIds: [],
				time: [],
				duration: [],
				endlocalId: 0
			};
			
			wx.ready(function () {
				var str = window.location.href;
				function getVal(name){
					return decodeURI(str.match(new RegExp(name+"="+"([^&]*)(&|$)"))[1]);
				}
				// 1。 手指按下去
				record.addEventListener('touchstart',recording,false);
				// 2。 手指抬起来
				record.addEventListener('touchend',recording,false);
				
				function recording(e){
					e = e||event;
					e.stopImmediatePropagation();
					e.preventDefault();

					switch( e.type ){
						case 'touchstart':
							recordIco.src = 'img/icons/rocording.png';
							nowTime = Date.now();
							wx.startRecord(); // 开始录音接口
							break;
						case 'touchend':
							if( Date.now() - nowTime > 300 ){
								var startTime = Date.now();
								//停止录音接口
								wx.stopRecord({
									success: function (res) {
										// 语音存放到数组里
										voice.localIds.push(res.localId); 
										voice.time.push( new Date().getHours() + ':' + new Date().getMinutes() );
										voice.duration.push( parseInt((startTime-nowTime)/1000)%60 );
										var sendBoxs = document.createElement('div');
										sendBoxs.className = 'send-box';	
										sendBoxs.innerHTML = '<div class="timing">'+voice.time[voice.time.length-1]+'</div>' +
											'<div class="avatar"><img src="'+getVal("img")+'" alt=""></div>' +
											'<div class="send" style="width:'+Math.min(((voice.duration[voice.duration.length-1])*1+1.5),5)+'rem">' +
											'<div class="duration">'+voice.duration[voice.duration.length-1]+'</div>' +
											'<div class="message"><img src="img/icons/leftvoice.png" alt=""></div>' +
											'<div class="arrow"></div></div>';
										content.appendChild(sendBoxs);
										recordIco.src = 'img/icons/recording.png';
										var sendBox = document.getElementsByClassName('send');
										for( var i=0;i<sendBox.length;i++ ){
											(function(i){
												sendBox[i].index = i;
												sendBox[i].addEventListener('touchstart',play,false);
												sendBox[i].addEventListener('touchmove',play,false);
												sendBox[i].addEventListener('touchend',play,false);
											})(i);
										}
			
									}
								});
							}else{
								recordIco.src = 'img/icons/recording.png';
								wx.stopRecord();
								alert( '是男人就不要太短了' );
							}
							break;
					}
				}
				
				// 3。 播放并翻译
				function play(e){
					var This = this;
					e = e||event;
					e.stopImmediatePropagation();
					e.preventDefault();

					switch( e.type ){
						case 'touchstart':
							break;
						case 'touchmove':
							break;
						case 'touchend':
							if( voice.localIds[This.index] ){
								//播放语音接口
								wx.playVoice({
									localId: voice.localIds[This.index] // 需要播放的音频的本地ID，由stopRecord接口获得
								});

								//监听语音播放完毕接口
								wx.onVoicePlayEnd({
									success: function (res) {
										voice.endlocalId = res.localId; // 返回音频的本地ID
										//智能接口
										//识别音频并返回识别结果接口
										wx.translateVoice({
										   localId: voice.localIds[This.index], // 需要识别的音频的本地Id，由录音相关接口获得
											isShowProgressTips: 1, // 默认为1，显示进度提示
											success: function (res) { 
												if( !(This.nextSibling) || This.nextSibling.className != 'text-node' ){
													var textNode = document.createElement('div');
													textNode.className = 'text-node';
													textNode.innerHTML = res.translateResult;
													if( !This.parentNode.nextSibling ){
														This.parentNode.parentNode.appendChild( textNode );
													}else if( This.parentNode.nextSibling && This.parentNode.nextSibling.className != 'text-node' ){
														This.parentNode.parentNode.insertBefore(textNode,This.parentNode.nextSibling);
													}
												}
											}
										});
									}
								});
							}
							break;
					}
				}
			})
		})
</script>
</body>
</html>