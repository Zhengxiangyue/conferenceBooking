<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?=isset($title) ? $title : '会议室管理系统'?></title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/css/publicCss.css"/>
    <script type="text/javascript" src="<?=base_url()?>static/js/common/jquery.js"></script>
    <script type="text/javascript" src="<?=base_url()?>static/js/common/publicScript.js"></script>

    <script type="text/javascript" src="<?=base_url()?>static/js/common/jsencrypt.js"></script>
    <script type="text/javascript" src="<?=base_url()?>static/js/common/common_helper.js"></script>

    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/template/vendor/bootstrap/css/bootstrap.css"/>
    <script src="<?=base_url()?>static/js/common/vue.js"></script>
    <script src="<?=base_url()?>static/js/common/vue_helper.js"></script>
</head>
<style>
    .container{
        margin: 0;
        padding: 0;
    }
    .header{
        margin: 0;
        margin-bottom: 10px;
        padding-top: 18px;
        padding-left: 18px;

    }
    h1{
        margin-top: 0;
        padding: 10px;
    }
    .btn-my{
        background-color: #8fc31f;
        color: white;
    }
    .btn-my:hover{
        color: #5bc0de;
    }
    .reservation-details-choice{
        width: 100%;
    }
    .pointer{
        cursor: pointer;
    }
    .pointer:hover{
        text-decoration: none;
    }
    .news-reservation-title{
        margin-top: 0;!important;
        margin-bottom: 0;!important;
        padding: 10px;
        font-size: 20px;
        font-weight: 300;
    }
    .item{
        font-size: x-large;
        font-weight: 300;
    }
    .reservation-title{
        padding-left: 0;
        font-size: x-large;
        font-weight: 400;
    }
    .large-title{
        font-size: x-large;
        font-weight: 500;
    }
    .news-detailed-top{
        font-size: 20px;
        font-weight: 300;
    }
    .news-detailed-text{
        font-size: 20px;
        font-weight: 300;
    }
    .login-form ul li .input{
        text-align: center;
    }
</style>
<?php $this->load->view('global/hint_message')?>
<style>
    .login-form ul li .input{
        width: 100%;
    }
</style>
<body>
<div id="userRegister" class="login">
    <div class="login-content">
        <h1 v-show="step == 1" class="login-caption">会议室预约</h1>
        <div class="login-room">
            <div class="login-form">
                <ul>
                    <div v-show="step == 2" style="display: none">
                        <li>
                            <input v-model="mobile" @keyup.13="register" class="input" type="text" id="mobile" placeholder="请输入手机号码" />
                        </li>

                        <li>
                            <button @click="get_code" :class="sendingCode ? 'disabled' : '' " style="width: 100%;color: white;background-color: #e1deb3;border-radius: 0" class="btn">
                                <span v-if="!sendingCode">获取验证码</span>
                                <span v-else>还剩{{ leftTime }}秒再次获取验证码</span>
                            </button>
                        </li>
                        <li>
                            <input v-model="code" @keyup.13="register" class="input" type="text" placeholder="验证码" />
                        </li>
                        <li>
                            <input id="password" v-model="password" @keyup.13="register" class="input" type="password"  placeholder="请输入密码" />
                        </li>
                        <li>
                            <input v-model="confirm" @keyup.13="register" class="input" type="password"  placeholder="确认密码" />
                        </li>

                        <button @click="register" style="width: 100%;color: white;background-color: #e1deb3;border-radius: 0" class="btn">
                            <span>注册</span>
                        </button>
                    </div>


                    <div v-show="step == 1">
                        <li>
                            <input id="nameInput" v-model="user_name" @keyup.13="nextOne" class="input" type="text"  placeholder="姓名" />
                        </li>

                        <li>
                            <input v-model="department" @keyup.13="nextOne" class="input" type="text"  placeholder="部门" />
                        </li>

                        <li>
                            <span class="input submit" @click="nextOne">下一步</span>
                        </li>

                    </div>



                </ul>
            </div>
            <p style="margin-bottom: 0" class="f12">已有账号<a class="c-008" href="/?/user/login">点击登陆</a></p>
        </div>
    </div>
</div>
</body>
</html>

<script>


    user_register_VM = new Vue({
        el : "#userRegister",
        data : {
            mobile : '',
            code : '',
            password : '',
            confirm : '',
            ssl_key : '',
            sendingCode : false,
            user_name : '',
            department : '',

            step : 1,

            leftTime : 0,
        },
        methods : {
            get_code : function(){
                var self = this;

                if(self.mobile == ''){
                    hint_message.show('请输入手机号码','alert');
                    return 0;
                }

                if(self.sendingCode){
                    return 0;
                }

                $.ajax({
                    url: "/?/api/user/get_register_code/",
                    type: 'POST',
                    async: true,
                    data: {
                        mobile : self.mobile,
                    },
                    dataType: 'json',
                    success: function (result) {
                        if(result.code == 1){
                            hint_message.show('验证码获取成功','success');
                            self.countToZero();
                        }else{
                            hint_message.show(result.msg,'alert');
                        }
                    }
                });
            },
            register : function(){
                var self = this;
                if(self.mobile == ''){
                    hint_message.show('请输入手机号码','danger');
                    return 0;
                }
                if(self.code == ''){
                    hint_message.show('验证码不能为空','danger');
                    return 0;
                }
                if(self.password == ''){
                    hint_message.show('密码不能为空','danger');
                    return 0;
                }
                if(self.password != self.confirm){
                    hint_message.show('两次密码不一致','danger');
                    return 0;
                }
                if(self.user_name == ''){
                    hint_message.show('请输入姓名','danger');
                    return 0;
                }
                if(self.department == ''){
                    hint_message.show('请输入部门','danger');
                    return 0;
                }
                var encrypt = new JSEncrypt();
                encrypt.setPublicKey(get_public_key())
                $.ajax({
                    url: "/?/api/user/register/",
                    type: 'POST',
                    async: true,
                    data: {
                        mobile : self.mobile,
                        password : encrypt.encrypt(self.password),
                        code : encrypt.encrypt(self.code),
                        user_name : self.user_name,
                        department : self.department,
                    },
                    dataType: 'json',
                    success: function (result) {
                        if(result.code == 1){
                            hint_message.show('注册成功，页面即将跳转','success');
                            setTimeout(function(){
                                window.location.href = '/?/user/login/';
                            },1000)
                        }else{
                            hint_message.show(result.msg,'danger');
                        }
                    }
                });
            },
            countToZero : function (init = true){
                var self = this;
                if(init){
                    self.leftTime = 60;
                    self.sendingCode = true;
                }
                if(self.leftTime == 0){
                    self.sendingCode = false;
                    return 0;
                }
                setTimeout(function(){
                    self.leftTime -= 1;
                    self.countToZero(false);
                },1000);
            },
            nextOne : function(){
                var self = this;
                if(self.user_name == ''){
                    hint_message.show('请输入姓名');
                    return 0;
                }
                if(self.department == ''){
                    hint_message.show('请输入部门');
                    return 0;
                }

                self.step = 2;
                setTimeout(function(){
                    $('#mobile').focus();
                },100)


            }
        }
    });

    setTimeout(function(){
        $('#password').focus()
    },200);
</script>