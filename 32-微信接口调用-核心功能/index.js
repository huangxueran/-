
    window.onload=function(){
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
    }
     