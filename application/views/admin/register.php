<?php $this->load->view('global/front_header')?>
<body>
<div id="bsRegister" class="login-container">
    <!--<div>-->
    <p class="login-title">预约会议室后台系统</p>
    <div class="login-content">
        <h2>用户注册</h2>
        <div v-show="step == '1'">
            <div class="login-input-group">
                <input v-model="user_name" type="text" placeholder="姓名"/>
            </div>
            <div class="login-input-group">
                <input v-model="department" type="text" @keyup.13="clickNextStep" placeholder="部门"/>
            </div>
            <input @click="clickNextStep" class="register-next btn" type="button"  value="下一步" />
        </div>

        <div v-show="step == '2'">
            <div class="login-input-group">
                <input id="inputMobile" v-model="mobile" type="text" placeholder="请输入手机号码"/>
            </div>
            <div class="login-input-group">
                <input @click="clickGetVerifyCodeAction" class="btn" style="background-color: #499ef3;color: white;margin-bottom : 20px;padding: 10px;" type="button" value="获取验证码" />
                <input v-model="verifyCode" type="text" placeholder="请输入验证码"/>
            </div>
            <div class="login-input-group" style="margin-bottom: 10px">
                <input  type="password" placeholder="请输入密码"/>
            </div>
            <div class="remindpwd">
                <input type="checkbox" style="margin: 0;"><span style="vertical-align: middle">同意《用户注册协议》</span>
            </div>
            <div style="width: 100%">
                <input class="btn" style="padding-bottom: 10px;padding-top:10px;margin-bottom:10px;width:100%;background-color: #5b95a4;color: white;font-size: 16px" type="button" value="注册" />
            </div>
        </div>
        <p>已有账号？<a style="cursor:pointer;color:#008ac3;" href="/?/manage/">点击登录</a></p>
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
    bs_register_VM = new Vue({
        el : "#bsRegister",
        data : {
            user_name : '',
            department : '',
            step : '1',
            mobile : '',
            verifyCode : '',
            password : '',
        },
        methods : {

            // 点击下一步
            clickNextStep : function(){
                var self = this;
                if(self.user_name == ""){
                    hint_message.show('请输入用户名');
                    return 0;
                }
                if(self.department == ""){
                    hint_message.show('请输入您的部门');
                    return 0;
                }
                self.step = "2";

                // 6666666
                setTimeout(function(){
                    $("#inputMobile").focus();
                },1);
            },
            // 点击登录
            clickLoginAction : function () {
                window.location.href = '/?/manage/'
            },
            // 获取验证码
            clickGetVerifyCodeAction : function(){
                var self = this;
                if(self.mobile.length != 11){
                    hint_message.show('请输入正确的手机号码','warning');
                }
            },

        }
    })
</script>
