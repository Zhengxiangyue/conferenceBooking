
    <?php $this->load->view('global/template_header_meta')?>
    <style type="text/css">
        body{
            width: 100%;
            background: url(<?=base_url()?>static/images/login-bg.png) no-repeat;
            background-size: cover;-webkit-background-size: cover;-moz-background-size: cover;
        }
        a{text-decoration:none;}
        .login-container{
            width: 100%;
            max-width:320px;
            margin: 0 auto;
            padding-top: 8%;
        }
        .login-title{
            margin-bottom: 20px;
            color: #fff;
            font-size:28px;
            text-align: center;
            letter-spacing: 2px;
            font-family: "宋体";
        }
        .login-content{
            background: #fff;
            padding: 15px;
        }
        .login-content h2{
            font-size: 18px;
            font-weight: normal;
            color: #000;
            font-family: 微软雅黑;
            margin-top: 0px;
            margin-bottom: 15px;
        }
        .login-input-group{
            width: 100%;
            margin-bottom: 20px;
        }
        .login-input-group input{
            width: 100%;
            padding: 10px 0 10px 10px;
            font-size: 16px;
        }
        .remindpwd{
            margin-bottom: 10px;
        }
        .remindpwd span{
            vertical-align: text-bottom;
            display: inline-block;
            margin-left: 8px;
            font-size: 14px;
            color: #141414;
        }
        .remindpwd a{
            font-size: 14px;
            display: inline-block;
            float: right;
            color:#141414;
        }
        .register{
            width: 100%;
            border: none;
            outline: none;
            background: #5b95a4;
            color: #fff;
            font-size:20px;
            padding: 5px 0;
            margin-bottom: 10px;
            cursor: pointer;
        }
        .login-content p{
            margin: 0;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div id="backstageLogin" class="login-container">
    <!--<div>-->
    <p class="login-title">预约会议室后台系统</p>
    <div class="login-content">
        <h2>用户登录</h2>
        <div>
            <div class="login-input-group">
                <input id="inputMobile" v-model="mobile" placeholder="请输入手机号码"/>
            </div>
            <div class="login-input-group">
                <input v-model="password" type="password" @keyup.13="clickLoginAction" placeholder="请输入密码"/>
            </div>
            <div class="remindpwd">
                <input type="checkbox" v-model="rememberPassword" style="margin: 0;"><span style="vertical-align: middle">记住密码</span>
                <a href="backstage_forget_pwd.html">忘记密码？</a>
            </div>

            <button @click="clickLoginAction" class="btn" style="width:100%;color:#008ac3;margin-bottom: 10px;font-size: 18px;color:white;background-color: #5b95a4">登 录</button>


        </div>
        <p>还没有账号？<a style="color:#008ac3;" href="/?/manage/register/">点击注册</a></p>
    </div>
    <!--</div>-->
</div>
</body>
<script type="text/javascript">
    $(function(){
        bodyH();
        function bodyH(){
            var widowH = $(window).height();
            var widowW = $(window).width();
            $("bady").css({"height":widowH,"width":widowW});
        }
    })
</script>
</html>

<script>
    backstage_login_VM = new Vue({
        el : "#backstageLogin",
        data : {
            mobile : '',
            password : '',
            rememberPassword : false,
        },
        methods : {
            clickLoginAction : function(){
                var self = this;
                console.log(self.rememberPassword);
                if(self.mobile.length != 11){
                    hint_message.show('请输入正确的手机号码');
                    return 0;
                }
                if(self.password == ''){
                    hint_message.show('请输入密码');
                    return 0;
                }
                var encrypt = new JSEncrypt();
                encrypt.setPublicKey(get_public_key())
                $.ajax({
                    url: "/?/api/user/admin/login",
                    type: 'POST',
                    async: false,
                    data:{
                        mobile : self.mobile,
                        password : encrypt.encrypt(self.password),
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.code == 1){
                            window.location.href = "/?/admin/";
                        }else{
                            hint_message.show(result.msg,'danger');
                        }
                    }
                });
            }

        },
    });

    setTimeout(function(){
        $("#inputMobile").focus();
    },500)
</script>
