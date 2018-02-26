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
    .pointer{
        cursor: pointer;
    }
    .pointer:hover{
        text-decoration: none;
    }
</style>
<?php $this->load->view('global/hint_message')?>
<style>
    .login-form ul li .input{
        width: 100%;
    }
</style>
<body>
<div id="userLogin" class="login">
    <div class="login-content">
        <h1 class="login-caption">会议室预约</h1>
        <div class="login-room">
            <h2 class="login-user" style="margin-top: 0">用户登录</h2>
            <div class="login-form">
                <ul>
                    <li>
                        <input v-model="mobile" @keyup.13="login" class="input" type="text" id="mobile" placeholder="请输入手机号码" />
                    </li>
                    <li>
                        <input v-model="password" @keyup.13="login" class="input" type="password" id="password" placeholder="请输入密码" />
                    </li>

                    <li>
                        <a class="input submit pointer" @click="login">登&nbsp录</a>
                    </li>
                </ul>
            </div>
            <p class="f12">
                <a class="c-008 pointer" href="/?/user/register">注册</a>
                <a style="margin-left: 10px" class="c-008 pointer" href="/?/user/find_password">忘记密码</a>
            </p>

        </div>
    </div>
</div>
</body>
</html>

<script>


    user_login_VM = new Vue({
        el : "#userLogin",
        data : {
            mobile : '',
            password : '',
            ssl_key : '',
        },
        methods : {
            login : function(){
                var self = this;
                if(self.mobile == ''){
                    hint_message.show('请输入手机号码','alert');
                    return 0;
                }
                if(self.password == ''){
                    hint_message.show('密码不能为空','alert');
                    return 0;
                }
                var encrypt = new JSEncrypt();
                encrypt.setPublicKey(get_public_key())
                $.ajax({
                    url: "/?/api/user/login/",
                    type: 'POST',
                    async: true,
                    data: {
                        mobile : self.mobile,
                        password : encrypt.encrypt(self.password),
                        toUrl : "<?=$toUrl?>",
                    },
                    dataType: 'json',
                    success: function (result) {
                        if(result.code == 1){
                            console.log(result)
                            if(result.data.url != undefined){
                                window.location.href = result.data.url;
                            }else{
                                window.location.href = '/?/user/';
                            }
                        }else{
                            hint_message.show(result.msg,'alert');
                        }
                    }
                });
            },
        }

    })
</script>