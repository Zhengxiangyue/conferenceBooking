<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>预约会议室后台管理</title>
    <link rel="stylesheet" type="text/css" href="<?php echo G_VIEWS_PATH;?>/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo G_VIEWS_PATH;?>/css/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo G_VIEWS_PATH;?>/css/backPublicCss.css?time=<?=time()?>"/>

    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/css/bootstrap.css"/>

    <script type="text/javascript" src="<?php echo G_VIEWS_PATH;?>/js/jquery.js"></script>
    <script src="<?php echo G_VIEWS_PATH;?>/js/vendor/jquery.ui.widget.js"></script>
    <script src="<?php echo G_VIEWS_PATH;?>/js/jquery.iframe-transport.js"></script>
    <script src="<?php echo G_VIEWS_PATH;?>/js/jquery.fileupload.js"></script>
    <script type="text/javascript" src="<?php echo G_VIEWS_PATH;?>/js/publicScript.js?time=<?=time()?>"></script>

    <script src="<?=base_url()?>static/js/knockout-3.4.1.js"></script>
    <script src="<?=base_url()?>static/js/ko_helper.js"></script>
    <script src="<?=base_url()?>static/js/ajaxfileupload.js"></script>
    <script src="<?=base_url()?>static/js/common_helper.js"></script>
    <script src="<?=base_url()?>static/js/vue2.js"></script>
</head>
<style>
    .container{
        margin: 0;
        padding: 0;
    }
    .header{
        margin: 0;
        padding-top: 18px;
        padding-left: 18px;

    }
    h1{
        margin-top: 0;
        padding: 10px;
    }
</style>

<?php $this->load->view('global/hint_message')?>