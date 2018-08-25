<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wxff630b0b0bd33a65", "85f7ab7425f8947a50194083c817e4a7");
$signPackage = $jssdk->GetSignPackage();
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <title>图片预览</title>

    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <link rel="stylesheet" href="css/weui.css" />
    <link rel="stylesheet" href="css/swiper-3.4.1.min.css" />

  </head>

  <body>
    <div class="page">
      <div class="page__bd">
        <div class="weui-gallery" id="gallery">
          <span class="weui-gallery__img" id="galleryImg"></span>
          <div class="weui-gallery__opr">
            <a href="javascript:" class="weui-gallery__del">
              <i class="weui-icon-delete weui-icon_gallery-delete"></i>
            </a>
          </div>
        </div>

        <div class="weui-cells weui-cells_form">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <div class="weui-uploader">
                <div class="weui-uploader__hd">
                  <p class="weui-uploader__title">图片上传</p>
                  <div class="weui-uploader__info" id='picLen'>0/2</div>
                </div>
                <div class="weui-uploader__bd">
                  <ul class="weui-uploader__files" id="uploaderFiles">
                    
                  </ul>
                  <div class="weui-uploader__input-box">
                    <input id="uploaderInput" class="weui-uploader__input" type="file" accept="image/*" multiple />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="page__ft">
        <a href="javascript:home()">图片上传功能课上已经讲过</a>
      </div>
    </div>


  </body>
  <script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="js/swiper-3.4.1.jquery.min.js"></script>
  <script>
    (function() {
		  var imgData={
			  imgUrl:[]
		   };
		  $(document).ready(function() {
			var user = {};
			var str = window.location.href;
			if ((/\?(\S*)/).test(str)) {
				//alert(str.match((/\?(\S*)/))[1])
				var mImg=str.match((/\?(\S*)/))[1].split("&");
				imgData.imgUrl=mImg;
			}
		  })
			

		wx.config({

		  appId: '<?php echo $signPackage["appId"];?>',
		  timestamp: <?php echo $signPackage["timestamp"];?>,
		  nonceStr: '<?php echo $signPackage["nonceStr"];?>',
		  signature: '<?php echo $signPackage["signature"];?>',
		  jsApiList: [
			'checkJsApi',
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
		wx.ready(function() {
		  
			
			var tmpl = '<li class="weui-uploader__file" style="background-image:url(#url#)"></li>',
			$gallery = $("#gallery"),
			$galleryImg = $("#galleryImg"),
			$uploaderInput = $("#uploaderInput"),
			$uploaderFiles = $("#uploaderFiles");
			var oPicLen = document.getElementById('picLen');
			//alert( imgData.imgUrl.length );
			//alert( tmpl );
			oPicLen.innerHTML = imgData.imgUrl.length+'/'+imgData.imgUrl.length;
			for( var i=0;i<imgData.imgUrl.length;i++ ){
				//alert( i );
				$uploaderFiles.append( '<li class="weui-uploader__file" style="background-image:url('+imgData.imgUrl[i]+')"></li>' );
				
			}
			

			document.getElementById('uploaderInput').onchange = function (e) {
				if(this.value){
					var This = this;
					//console.log(this.value);

					var files = this.files[0];  // 单文件上传
					

					var obj = new FileReader();  // 创建读取文件对象
					obj.readAsDataURL(files);  // 分析文件

					obj.onload = function () {
						//alert( this.result );
						var oLi = document.createElement('li');
						oLi.className = 'weui-uploader__file';
						oLi.innerHTML = '<img src="'+this.result+'" width="100%" height="100%"/>';
						
						document.getElementById('uploaderFiles').appendChild(oLi);
						oPicLen.innerHTML = document.getElementById('uploaderFiles').children.length+'/'+document.getElementById('uploaderFiles').children.length;
					};
					this.value = '';
				}
			}
		});	
    })();
  </script>

  </html>