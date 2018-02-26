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
</style>
<?php $this->load->view('global/hint_message')?>
<style>
    .login-form ul li .input{
        width: 100%;
    }
</style>
<body>
<div id="findPassword" class="login">
    <div class="login-content">
        <h1 class="login-caption">会议室预约</h1>
        <div class="login-room">
            <h2 class="login-user" style="margin-top: 0">重置密码</h2>
            <div class="login-form">
                <ul>
                    <li>
                        <input v-model="mobile" @keyup.13="register" class="input" type="text" id="mobile" placeholder="请输入手机号码" />
                    </li>

                    <li>
                        <button @click="get_code" :class="sendingCode ? 'disabled' : '' " style="width: 100%;color: white;background-color: #e1deb3;border-radius: 0" class="btn">
                            <span v-if="!sendingCode">{{ getCodeButtonContent }}</span>
                            <span v-else>还剩{{ leftTime }}秒再次获取验证码</span>
                        </button>
                    </li>
                    <li>
                        <input v-model="code" @keyup.13="findPassword" class="input" type="text" id="password" placeholder="验证码" />
                    </li>
                    <li>
                        <input v-model="password" @keyup.13="findPassword" class="input" type="password" id="password" placeholder="请输入密码" />
                    </li>
                    <li>
                        <input v-model="confirm" @keyup.13="findPassword" class="input" type="password" id="password" placeholder="确认密码" />
                    </li>

                    <li>
                        <a class="input submit" @click="findPassword">重置密码</a>
                    </li>
                </ul>
            </div>
            <p class="f12"><a class="c-008" href="/?/user/login">登陆</a><a style="margin-left: 10px" class="c-008" href="/?/user/login">注册</a></p>
            <p style="text-align: right;color: red;margin-top: 5px" id="error_msg"></p>
        </div>
    </div>
</div>
</body>
</html>

<script>


    user_register_VM = new Vue({
        el : "#findPassword",
        data : {
            mobile : '',
            code : '',
            password : '',
            confirm : '',
            ssl_key : '',
            sendingCode : false,
            getCodeButtonContent : '获取验证码',

            leftTime : 0,
        },
        methods : {
            get_code : function(){
                var self = this;
                if(self.mobile == ''){
                    hint_message.show('请输入手机号码','danger');
                    return 0;
                }
                if(self.sendingCode){
                    return 0;
                }

                self.getCodeButtonContent = '正在发送验证码...'

                $.ajax({
                    url: "/?/api/user/get_find_password_code/",
                    type: 'POST',
                    async: true,
                    data: {
                        mobile : self.mobile,
                    },
                    dataType: 'json',
                    success: function (result) {
                        if(result.code == 1){
                            hint_message.show('验证码获取成功','success');
                            self.getCodeButtonContent = '获取验证码';
                            self.countToZero();
                        }else{
                            hint_message.show(result.msg,'danger');
                        }
                    }
                });
            },
            findPassword : function(){
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
                var encrypt = new JSEncrypt();
                encrypt.setPublicKey(get_public_key())
                $.ajax({
                    url: "/?/api/user/find_password/",
                    type: 'POST',
                    async: true,
                    data: {
                        mobile : self.mobile,
                        password : encrypt.encrypt(self.password),
                        code : encrypt.encrypt(self.code),
                    },
                    dataType: 'json',
                    success: function (result) {
                        if(result.code == 1){
                            hint_message.show('密码设置成功，页面即将跳转...','success');
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
            }
        }

    })
</script>