<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?=isset($title) ? $title : '会议室管理系统'?></title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/css/publicCss.css"/>
    <script type="text/javascript" src="<?=base_url()?>static/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>static/js/publicScript.js"></script>

    <script type="text/javascript" src="<?=base_url()?>static/js/jsencrypt.js"></script>
    <script type="text/javascript" src="<?=base_url()?>static/js/common_helper.js"></script>

    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/css/bootstrap.css"/>
    <script src="<?=base_url()?>static/js/vue2.js"></script>
    <script src="<?=base_url()?>static/js/vue_helper.js"></script>


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