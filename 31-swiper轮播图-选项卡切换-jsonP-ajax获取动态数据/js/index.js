/**
 * Created by aflyi on 2017/8/24.
 */

window.onload = function () {

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





    createScript();
    function createScript() {
        var oScript = document.createElement('script');
        // oScript.src = 'http://route.showapi.com/181-1?showapi_timestamp'+formatterDateTime()+'&showapi_appid=37928&showapi_sign=d0ca1605e19241c38849c3fb9a56b447&num=10&rand=1&jsonpcallback=getNews';
        document.body.appendChild(oScript);
    }

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

};






















