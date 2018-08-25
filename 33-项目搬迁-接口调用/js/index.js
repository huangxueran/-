/**
 * Created by aflyi on 2017/8/24.
 */
	var str=window.location.href;                                            //因为请求到code后会跳转回到本页面,所以要对我们的地址进行抓取判断,判断是否存在code值
		if((/code=(\S*)\&/).test(str)){                    
            var substr = str.match(/code=(\S*)\&/);
            var code=substr[1];                                                 //如果存在的话,就使用正则match抓取下来      
             $.ajax({                                
                method:'GET',                                               
                url:'http://www.tanzhouweb.com/wx/get_openid.php',        //通过ajax提交给后台页面get_openid.php
                data:{
                    code:code                                                   //传递code
                },
                success:function(res){                                          //后台经过两次请求分别通过appid和secret结合code获取到用户access_token与openid,再通过access_token和openid获取用户信息json对象返回用户信息对象,详见get_openid.php页面
                    if(typeof res === 'string'){                            
                        var open=JSON.parse(res);                               //对传递回来的数据进行json格式化,转化成json对象
                        userInfo=open;                                               
                    }
                 }
            })
       }else{
            window.location.href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxff630b0b0bd33a65&redirect_uri=http%3a%2f%2fwww.tanzhouweb.com%2fwx%2findex.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        }


    //  1. 轮播图
    var mySwiper1 = new Swiper('.swiper-container', {
        //effect : 'fade',
        autoplay: 2000, //可选选项，自动滑动
        speed:500, // slide 运动的速度
        autoplayDisableOnInteraction : false, //用户操作swiper之后，是否禁止autoplay。默认为true：停止。
        touchAngle : 20, // 允许触发拖动的角度值。默认45度，即使触摸方向不是完全水平也能拖动slide。
        pagination : '.swiper-pagination', // 分页器
        paginationElement : 'span', // 分页器元素
        loop : true
    });


    // 2. 选项卡

    var aTab = document.querySelector('#con .con-title').querySelectorAll('div');
    var len = aTab.length;
    //console.log( aTab.length );

    // 选项卡添加类名
    for( var i=0;i<len;i++ ){
        (function (i) {
            aTab[i].addEventListener('touchstart',function () {
                Addclass(i);
            });
        })(i);
    }

    // 左右切换

    var oWrap = document.querySelector('#con .contents');
    var aPage = document.querySelectorAll('#con .page');
    var index = 0;
    //console.log(aPage.length);
    oWrap.addEventListener('touchstart',touch);
    oWrap.addEventListener('touchmove',touch);
    oWrap.addEventListener('touchend',touch);

    var start = {
        x:0,
        y:0
    };
    var end = {
        x:0,
        y:0
    };
    function touch(e) {
        //console.log( e.type );
        switch ( e.type ){
            case 'touchstart':
                //console.log( 1 );
                start.x = e.changedTouches[0].pageX;
                start.y = e.changedTouches[0].pageY;

                //console.log( start.x );
                break;
            case 'touchmove':
                end.x = e.changedTouches[0].pageX;
                end.y = e.changedTouches[0].pageY;

                //console.log( 2 );
                break;
            case 'touchend':
                console.log( '抬起来了' )   // 比较的是距离  不是正负 值
                if( ( start.x - end.x ) > ( Math.abs(end.y - start.y) ) ){
                    index ++;
                    index = index > (len-1)?(len-1):index;
                    Addclass(index);
                }
                if( ( end.x - start.x ) > ( Math.abs(end.y - start.y) ) ){
                    index --;
                    index = index < 0?0:index;
                    Addclass(index);
                }

                break;
        }
    }
    
    function Addclass(k) {
        console.log( k );
        for(var i=0;i<len;i++ ){
            aTab[i].classList.remove('on');
            aPage[i].classList.remove('on');
        }
        aTab[k].classList.add('on');
        aPage[k].classList.add('on');
    }

	
	// 
	























