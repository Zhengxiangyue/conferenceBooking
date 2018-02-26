<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?=isset($title) ? $title : '会议室预约系统'?></title>
    <script src="<?=base_url()?>static/js/vue2.js"></script>
    <script src="<?=base_url()?>static/js/knockout-3.4.1.js"></script>
    <script src="<?=base_url()?>static/js/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/css/bootstrap.css"/>
    <style type="text/css">
        body{
            width: 100%;
            background: url(<?=base_url('static/images/login-bg.png')?>) no-repeat;
            background-size: cover;-webkit-background-size: cover;-moz-background-size: cover;
        }
        a{text-decoration:none;}
        .login-container{
            width: 100%;
            max-width:320px;
            margin: 0 auto;
            padding-top: 7%;
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
            font-size: 16px;
            display: inline-block;
            float: right;
            color:#141414;
        }
        .register-next{
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
        .register-input-code{
            width: 100%;
            margin-bottom: 20px;
            position: relative;
        }
    </style>
    <?php $this->load->view('global/hint_message')?>
</head>
