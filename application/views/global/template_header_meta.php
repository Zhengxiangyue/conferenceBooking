<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=isset($html_header) ? $html_header : '会议室系统'?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=base_url('static/template')?>/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?=base_url('static/template')?>/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?=base_url('static/template')?>/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?=base_url('static/template')?>/vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?=base_url('static/template')?>/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="<?=base_url('static/')?>css/daterangepicker.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url('static/')?>css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css">

    <!-- DataTables CSS -->
    <link href="<?=base_url('static/template')?>/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?=base_url('static/template')?>/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
    <link rel='stylesheet' href='<?=base_url()?>static/css/calendar/fullcalendar.min.css' />


    <script type="text/javascript" src="<?=base_url()?>static/js/common/jsencrypt.js"></script>
    <script type="text/javascript" src="<?=base_url()?>static/js/common/common_helper.js"></script>

    <script type="text/javascript"  src="<?=base_url()?>static/js/common/vue.js"></script>
    <script type="text/javascript" src="<?=base_url()?>static/js/common/vue_helper.js?time=<?=time()?>"></script>

    <!-- jQuery -->
<!--    上传头像用不成min-->
    <script src="<?=base_url('static/template')?>/vendor/jquery/jquery.min.js"></script>


    <script src="<?=base_url('static/template')?>/vendor/bootstrap/js/bootstrap.min.js"></script>



    <!-- DataTables JavaScript -->
    <script src="<?=base_url('static/template')?>/vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="<?=base_url('static/template')?>/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="<?=base_url('static/template')?>/vendor/datatables-responsive/dataTables.responsive.js"></script>


    <script type="text/javascript" src="<?=base_url()?>static/js/common/knockout.js"></script>
    <script type="text/javascript" src="<?=base_url()?>static/js/common/ko_helper.js"></script>
    <script type="text/javascript" src="<?=base_url()?>static/js/common/moment.js"></script>

    <script type="text/javascript" src="<?=base_url()?>static/js/common/daterangepicker.js"></script>
    <script type="text/javascript" src="<?=base_url()?>static/js/common/bootstrap-datetimepicker.js"></script>


</head>
<?php $this->load->view('global/hint_message')?>
<?php $this->load->view('global/sp_confirm')?>
<style>
    .pd0{
        padding-left: 0;
        padding-right: 0;
    }
    .btn-default:focus {
        outline: none;
        background-color: white;
    }
    .heavy{
        font-weight:900;
    }
    .pdl0{
        padding-left: 0;
    }
    .pdr0{
        padding-right: 0;
    }
    .status{
        margin-top: 10px;
        font-size: x-large;
        color: #8fc31f;
        text-align: center;
    }
    .line{
        display:inline-block;
        vertical-align:super;border: 1px #8fc31f solid;
    }
    .booking-content{
        font-size: large;
        font-weight: 300;
    }
    .newest-booking{
        height: 80px;
    }
    .newest-booking{
        height: 80px;
    }
    .vertical-center{
        top: 50%;
        transform: translate(0, -50%);
    }
    .booking-process{
        color: darkgrey;
        font-size: x-large;
        margin-top: 10px;
    }
    .booking-process-done{
        color: #8fc31f;
    }
    .booking-process-fail{
        color: red;
    }
    .newest-button{
        text-align: center;
    }
    .badge-date{
        font-size: 0.7em;
    }
    .panel-heading{
        font-weight: 300;
    }
    .sidebar ul li{
        border: 0;
    }
    /*.nav>li>a{*/
    /*color:white;*/
    /*background-color: #a8d7de;*/
    /*font-size: 20px;*/
    /*}*/
    /*#wrapper{*/
    /*background-color:#a8d7de;*/
    /*}*/
    /*.sidebar ul li a.active{*/
    /*background-color: #e1deb3;*/
    /*}*/
    /*.sidebar .sidebar-search{*/
    /*background-color: #e1deb3;*/
    /*}*/
    /*.navbar-top-links li a{*/
    /*background-color: #e1deb3;*/
    /*}*/
    .page-header{
        border-bottom: 2px #8fc31f solid;
        font-size: x-large;
        margin-top: 20px;
    }
    .nav > li > a{
        text-align: center;
    }
    .pointer{
        cursor: pointer;
    }
    .pointer:hover{
        text-decoration: none;
    }
    .navbar-brand:hover{
        color: white;
    }
    .preventChoose{
        moz-user-select: -moz-none;
        -moz-user-select: none;
        -o-user-select:none;
        -khtml-user-select:none;
        -webkit-user-select:none;
        -ms-user-select:none;
        user-select:none;
    }
    .uploadButton {
        margin-top: 20px;
        width: 30%;
    }
    .editRoom{
        margin-top: 10px;
    }
    .shortInput{
        width: 30%;
    }
    .xshortInput{
        width: 10%;
    }
    .editRoomForm{

    }
    .form-group{
        margin-bottom: 3%;
    }
    .control-label{
        font-weight: 400;
    }
    .form-horizontal{
        /*margin-top: 3%;*/
    }
    .actionButton{
        margin: 20px 10px;
    }
    .editHeadButton{
        margin-bottom: 20px;
    }
    .hoverRoom{
        /*background-color:#fff;*/
        transition:background-color 0.5s;
        -moz-transition:background-color 0.5s; /* Firefox 4 */
        -webkit-transition:background-color 0.5s; /* Safari and Chrome */
        -o-transition:background-color 0.5s; /* Opera */
    }
    .hoverRoom:hover{
        background-color:#f5f5f5;
    }
    .deleteButton{
        color: red;
        display: none;
        font-weight: 400;
    }
    .deleteButton:hover{
        font-weight: 600;
    }
    .hoverRoom:hover .deleteButton{
        display: inline-block;
    }
    #page-wrapper{
        /*margin-left: 20%;*/
    }
    #boardControl{
        /*width: 20%;*/
    }
    /*.navbar-default{*/
    /*background-color: #3c8dbc;*/
    /*}*/
    .navbar-static-top{
        background-color: #3c8dbc;
    }
    .navbar-default .navbar-brand{
        color: white;
        margin-left: 20px;
    }
    .nav > li > a{
        color: #222;
        font-weight: 300;
        padding: 10px 25px;
        text-align: left;
        border-top: 1px solid #eee;
    }
    .fa-fw{
        color: darkgrey;
    }
    .navbar-top-links li a{
        border: 0;
        color: white;
        padding: 15px;
    }
    .navbar-top-links li a:hover{
        background-color: #3c8dbc;
    }
    .dropdown .fa-fw{
        color: white;
    }
    .nav .open > a, .nav .open > a:hover, .nav .open > a:focus{
        border: 0;
        background-color: #337ab7;
    }
    .pdud0{
        padding-bottom: 0;
        padding-top: 0;
    }
    .control-label-2{
        padding-top: 7px;
        margin-bottom: 0;
        text-align: left;
    }
    .history{
        font-size: large;
        color: darkgrey;
    }
    .text-info{
        color:#5bc0de !important
    }
    .text-danger{
        color: #d9534f !important
    }
    .waitingItemTime{
        font-size: x-large;
    }
    .waitingItem{
        color: rgb(91, 149, 164);
        font-weight: 400;

    }
    .waitingDark{
        background-color: #efefef;
        /*margin-top: 10px;*/
        padding: 10px;
    }
    .waiting{
        /*margin-top: 10px;*/
        padding: 10px;
    }
    .tal{
        text-align: left;
    }
    .waitingButton{
        margin-top: 20px;
        margin-left: 10px;
    }
    .waitingContent{
        font-size: 1.2em;
        font-weight: 300;

    }

    .list-item {
        display: inline-block;
        margin-right: 10px;
    }
    .list-enter-active, .list-leave-active {
        transition: all 1s;
    }
    .list-enter, .list-leave-active {
        opacity: 0;
        transform: translateX(-30px);
    }
    .processContent{
        color: darkgrey;
        font-size: large;
        margin-bottom: 20px;
    }
    .processComplete{
        color: #8fc31f
    }
    .placeRight::-ms-input-placeholder{text-align: right;}
    .placeRight::-webkit-input-placeholder{text-align: right;}
    .inputWholeLeft{
        text-align: center;
        border-right: 0;
    }
    .inputWholeRight{
        border-left:0;
        background-color: white;
        color: darkgrey;
    }
    .inputWholeGray{

    }
    .inputWholeMiddle{
        border-left:0;
        border-right: 0;
        padding-left: 0;
        padding-right: 0;
        background-color: white;
        color: darkgrey;
    }
    .input-group-addon, .input-group-btn{
        border-shdow:inset 0 1px 1px rgba(0, 0, 0, .075)
    }

    .content{
        font-size: larger;
        color: #696969;
    }
    .contentRom{
        margin-bottom: 20px;
    }
    .greenBorder{
        border: 1px solid #5cb85c;
    }
    .roomBrand{
        float: left;
        height: 50px;
        padding: 15px 15px;
        font-size: 18px;
        line-height: 20px;
        color: white;
    }
    .pointer-disable{
        cursor: not-allowed;
    }

    @media (max-width: 767px){
        ul.timeline > li > .timeline-panel{
            width: 80%;
        }
    }

</style>

