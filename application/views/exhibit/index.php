<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
    <title>会议室预约—会议进行中</title>
    <script src="<?=base_url()?>static/js/common/vue.js"></script>
    <script src="<?=base_url()?>static/js/common/jquery.js"></script>
    <script>
        /*
         jQ向上滚动带上下翻页按钮
         */
        (function($){
            $.fn.extend({
                Scroll:function(opt,callback){
                    //参数初始化
                    if(!opt) var opt={};
                    var _btnUp = $("#"+ opt.up);//Shawphy:向上按钮
                    var _btnDown = $("#"+ opt.down);//Shawphy:向下按钮
                    var timerID;
                    var _this=this.eq(0).find("ul:first");
                    var     lineH=_this.find("li:first").height(), //获取行高
                        line=opt.line?parseInt(opt.line,10):parseInt(this.height()/lineH,10), //每次滚动的行数，默认为一屏，即父容器高度
                        speed=opt.speed?parseInt(opt.speed,10):500; //卷动速度，数值越大，速度越慢（毫秒）
                    timer=opt.timer //?parseInt(opt.timer,10):3000; //滚动的时间间隔（毫秒）
                    if(line==0) line=1;
                    var upHeight=0-line*lineH;
                    //滚动函数
                    var scrollUp=function(){
                        _btnUp.unbind("click",scrollUp); //Shawphy:取消向上按钮的函数绑定
                        _this.animate({
                            marginTop:upHeight
                        },speed,function(){
                            for(i=1;i<=line;i++){
                                _this.find("li:first").appendTo(_this);
                            }
                            _this.css({marginTop:0});
                            _btnUp.bind("click",scrollUp); //Shawphy:绑定向上按钮的点击事件
                        });

                    }
                    //Shawphy:向下翻页函数
                    var scrollDown=function(){
                        _btnDown.unbind("click",scrollDown);
                        for(i=1;i<=line;i++){
                            _this.find("li:last").show().prependTo(_this);
                        }
                        _this.css({marginTop:upHeight});
                        _this.animate({
                            marginTop:0
                        },speed,function(){
                            _btnDown.bind("click",scrollDown);
                        });
                    }
                    //Shawphy:自动播放
                    var autoPlay = function(){
                        if(timer)timerID = window.setInterval(scrollUp,timer);
                    };
                    var autoStop = function(){
                        if(timer)window.clearInterval(timerID);
                    };
                    //鼠标事件绑定
                    _this.hover(autoStop,autoPlay).mouseout();
                    _btnUp.css("cursor","pointer").click( scrollUp ).hover(autoStop,autoPlay);//Shawphy:向上向下鼠标事件绑定
                    _btnDown.css("cursor","pointer").click( scrollDown ).hover(autoStop,autoPlay);

                }
            })
        })(jQuery);


    </script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/exhibit/css/bootstrap.min.css"/>
    <style>
        html, body{
            margin:0;
            padding:0;
            font-family: "微软雅黑" !important;
            font-size: 10px !important; /* 10px ÷ 16px × 100% = 62.5;*/
        }
        p{margin: 0;}
        .p0{padding: 0;}
        .m0{margin: 0;}
        .next_room{width:100%;margin:0 auto;background:#fff}
        .room_title1{
            background: url('<?=base_url()?>static/exhibit/img/roomBanner_1.png') no-repeat;background-size: contain;padding: 20px 25px;
            font-size: 30px;margin-top: 30px;margin-bottom: 20px;color: #fff;
        }
        .room_title2{
            background: url('<?=base_url()?>static/exhibit/img/roomBanner_2.png') no-repeat;background-size: contain;padding: 20px 25px;
            font-size: 30px;margin-top: 30px;margin-bottom: 20px;color: #fff;
        }
        .room_title3{
            background: url('<?=base_url()?>static/exhibit/img/roomBanner_3.png') no-repeat;background-size: contain;padding: 20px 25px;
            font-size: 30px;margin-top: 30px;margin-bottom: 20px;color: #fff;
        }
        .room_name{color: #fff;border-bottom: 2px solid #fff;text-align: center;
            padding: 5px 0;font-size: 24px;}
        .room_eg{color: #fff;padding: 10px 20px;font-size: 20px;min-height: 80px;}
        .room_amount{font-size: 30px;padding: 30px 0 5px 25px;border-bottom: 1px solid #000;
            margin-bottom: 20px;}
        .room_amount_cont{padding: 10px 30px;color: #fff;font-size: 20px;}
        .room_myname{width:60px;height:60px;line-height:60px;border-radius: 50%;text-align: center;}
        .broken-line{width:100%;height:0;display: inline-block; margin:0px auto;padding:19px;
            overflow:hidden;;border-bottom:1px black dashed;}
        .room_myname_title{padding: 5px 10px;border-bottom: 2px solid #fff;min-height: 40px;}
        .room_myname_cont{padding: 5px 10px;min-height: 122px;}
        .room_amount_cont_item{margin-bottom: 20px;}
        .item_name{width: 10%;float: left;margin: 0;position: relative;top: 10px;}
        .item_line{width: 20%;float: left;margin-right: 5%;}
        .item_cont{width: 65%;float: left;}
        .bg_b{background: #5cb9d8;}
        .bg_r{background: #dc4e31;}
        .bg_g{background: #8fc31f;}
        .bg_h{background: #39555f;}
        @media only screen and (min-width: 321px) and (max-width: 640px){
            .room_title{font-size: 20px;padding: 15px 10px 15px 20px;margin-top: 15px;margin-bottom: 10px;}
            .room_name{padding: 3px 0;font-size: 16px;}
            .room_eg{padding:10px;font-size: 16px;}
            .room_amount{padding: 15px 0 5px 20px;font-size: 20px;}
            .room_amount_cont{font-size: 14px;padding: 5px 25px;}
            .item_name{top: 16px;}
            .room_myname{width: 45px;height: 45px;line-height: 45px;}
            .room_myname_cont{min-height: 100px;}
        }
        @media only screen and (max-width: 320px){
            .room_title{font-size: 18px;padding: 10px 10px 10px 20px;margin-top: 15px;margin-bottom: 10px;}
            .room_name{padding: 3px 0;font-size: 14px;}
            .room_eg{padding:5px;font-size: 14px;}
            .room_amount{padding: 10px 0 5px 15px;font-size: 18px;}
            .room_amount_cont{font-size: 12px;padding: 5px 15px;}
            .item_name{top: 16px;}
            .room_myname{width: 45px;height: 45px;line-height: 45px;}
            .room_myname_cont{min-height: 100px;}
        }


        .scrollbox{ width: 100%; margin: 0 auto; overflow: hidden; }
        #scrollDiv{width:100%;height:800px; overflow:hidden;}/*这里的高度和超出隐藏是必须的*/
        #scrollDiv li{height:200px; width:100%; padding:0 0;background:url(ico-4.gif) no-repeat 10px 23px; overflow:hidden; vertical-align:bottom; zoom:1; }
        #scrollDiv li h3{ height:24px; padding-top:13px; font-size:14px; color:#353535; line-height:24px; width:300px;}
        #scrollDiv li h3 a{color:#353535; text-decoration:none}#scrollDiv li h3 a:hover{ color:#F00}
        /*#scrollDiv li div{ height:36px; width:300px; color:#416A7F; line-height:18px; overflow:hidden}*/
        #scrollDiv li div a{ color:#416A7F; text-decoration:none}

        .scroltit{ height:26px; line-height:26px; padding-bottom:4px; margin-bottom:4px;}
        .scroltit h3{ width:100px; float:left;}
        .scroltit .updown{float:right; width:32px; height:22px; margin-left:4px}
        #but_up{ background:url(up.gif) no-repeat 0 0; text-indent:-9999px}
        #but_down{ background:url(down.gif) no-repeat 0 0; text-indent:-9999px}


        #n{margin:10px auto; width:920px; border:1px solid #CCC;font-size:12px; line-height:30px;}
        #n a{ padding:0 4px; color:#333}
    </style>
</head>
<body>
<div id="exhibit" class="next_room">
    <div class="container p0">
<!--        --><?php //var_dump($data)?>

<!--        当前会议室有会议进行-->
        <div class="row m0 clearfix">
            <div class="col-lg-5 col-sm-4 col-xs-5 p0 room_title1" :class="currentRoom.status == 0 ? 'room_title3' : (currentRoom.status == 1 ? 'room_title1' : 'room_title2') ">
                <span v-if="currentRoom.status == 0">无预约</span>
                <span v-if="currentRoom.status == 1">会议进行中</span>
                <span v-if="currentRoom.status == 2">下一场</span>
            </div>

            <div class="col-xs-12 p0 room_name bg_h" >
                <p>{{ currentRoom.roomName }}</p>
            </div>

            <div v-if="currentRoom.status != 0" class="col-xs-12 p0 room_eg" :class="currentRoom.status == 0 ? 'bg_g' : (currentRoom.status == 1 ? 'bg_r' : 'bg_b' )">
                <div class="col-xs-12 col-md-6">
                    <p>会议主题 : <span>{{ currentRoom.meetingName }}</span></p>
                </div>
                <div class="col-xs-6 col-md-6">
                    <p>时间 : <span>{{ currentRoom.useBeginTime + " ~ " + currentRoom.useEndTime  }}</span></p>
                </div>
                <div class="col-xs-6 col-md-6">
                    <p>部门 : <span>{{ currentRoom.department }}</span></p>
                </div>
                <div class="col-xs-12 col-md-6">
                    <p>参会人数 : <span>{{ currentRoom.number }}</span></p>
                </div>
            </div>
            <div v-else class="col-xs-12 p0 room_eg bg_g">
                无预约
            </div>
        </div>

        <div class="row m0 clearfix">
            <div class="col-xs-12 p0 room_amount">
                <p>会议室总览</p>
            </div>
        </div>

<!--        滚动播放会议室详情-->
        <div class="row m0 clearfix">
            <div class="scrollbox">
                <div id="scrollDiv" class="room_amount_cont clearfix">
                    <ul  style="padding: 0">

                        <li v-for="room in rooms">
                            <div class="item_name">
                                <p v-if="room.status == 0" class="room_myname bg_g">{{ room.roomName }}</p>
                                <p v-if="room.status == 1" class="room_myname bg_r">{{ room.roomName }}</p>
                                <p v-if="room.status == 2" class="room_myname bg_b">{{ room.roomName }}</p>
                            </div>
                            <div class="item_line">
                                <div class="broken-line"></div>
                            </div>
                            <div class="item_cont">
                                <p class="room_myname_title bg_h">
                                    <span v-if="room.status == 0"></span>
                                    <span v-if="room.status == 1">会议主题 : {{room.meetingName}}</span>
                                    <span v-if="room.status == 2">会议主题 : {{room.meetingName}}</span>
                                </p>

                                <div v-if=" room.status != 0" class="room_myname_cont" :class="room.status == 1 ? 'bg_r' : 'bg_b'">
                                    <p>时间 : {{ room.useBeginTime + " ~ " + room.useEndTime }}</p>
                                    <p>部门 : {{ room.department }}</p>
                                    <p>联系人 : {{ room.applicant }}</p>
                                    <p>电话 : {{ room.mobile }}</p>
                                </div>
                                <div v-else class="room_myname_cont bg_g">
                                    无预约
                                </div>

                            </div>
                            <div style="clear: both;"></div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-12 text-center">
            <img style="height: 120px" src="<?=base_url()?>static/images/car.png">
        </div>

    </div>

</div>

<script>
    exhibit_VM = new Vue({
        el : '#exhibit',
        data : {
            cid : <?=$cid?>,
            rooms : {},
            currentRoom : {},
        },
        methods : {
            getRooms : function () {
                var self = this;
                $.ajax({
                    url: "/?/api/exhibit/",
                    type: 'POST',
                    async: true,
                    data : {
                        cid : self.cid,
                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        if(result.code == 1){
                            self.currentRoom = result.data.currentRoom;
                            self.rooms = result.data.allRooms;
                        }
                    }
                });
            },
            polling : function(){
                var self = this;
                setTimeout(function(){
                    self.getRooms();
                    self.polling();
                },1000)
            }
        }
    })

    exhibit_VM.getRooms();
    exhibit_VM.polling();

        $(document).ready(function(){
            $("#scrollDiv").Scroll({line:1,speed:500,timer:3000});
        });
</script>
</body>
</html>
