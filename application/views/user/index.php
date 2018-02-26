<?php $this->load->view('user/component/header')?>
<style>
    .btn-default:focus {
        outline: none;
        background-color: white;
    }
</style>
    <div id="page-wrapper">
        <div id="userAppointment" style="display: none;" v-show="true">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" style="color: #007c8e">我的预约</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div style="text-align: center;font-size: x-large;" v-if="newestList.length == 0 && historyList.length == 0" >没有任何预约，您可以去<a href="/?/user/add_new_booking">预约会议室</a></div>
                    <!-- 最新预约 -->
                    <div class="panel panel-default" v-show="newestList.length > 0" style="display: none">
                        <div class="panel-heading">
                            最新预约
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body clearfix">
                            <div class="clearfix" v-for="booking in newestList" v-if="newestList.length > 0">
                                <div class="newest-booking col-lg-9 col-md-9 col-sm-12 col-xs-12 pd0">
                                    <div class="text-center vertical-center pd0 col-lg-4 col-md-4 col-sm-4 col-xs-4 booking-content">会议室: <span class="text-info">{{ booking.name }}</span></div>
                                    <div class=" text-center vertical-center pd0 col-lg-4 col-md-4 col-sm-4 col-xs-4 booking-content">会议时间: <span style="cursor: default" class="text-info" :title="'会议时间:'+booking.useDate + ' ' + booking.useBeginTime + '~' + booking.useEndTime">{{ booking.meetingBeginTimeFriendly }}</span></div>
                                    <div class=" text-center vertical-center pd0 col-lg-4 col-md-4 col-sm-4 col-xs-4 booking-content">订单已经提交了: <span class="text-info" :title="'订单提交时间:'+booking.bookingTime">
                                            {{ (booking.bookingLastHour ? booking.bookingLastHour + " 小时 " : '')  +  (booking.bookingLastMinute ?  booking.bookingLastMinute + " 分 " : '' ) + booking.bookingLastSecond + " 秒" }}</span>
                                    </div>
                                </div>
                                <div class="newest-booking col-lg-3 col-md-3 col-sm-12 col-xs-12 pd0">

                                    <div class="vertical-center col-lg-6 col-md-6 col-sm-6 col-xs-6 pdr0">
                                        <button @click="goToDetail(booking.bid)" type="button" class="pd0 col-lg-12 col-md-12 col-sm-12 col-xs-12 btn btn-success newest-button">查看详情</button>
                                    </div>
                                    <div class="vertical-center col-lg-6 col-md-6 col-sm-6 col-xs-6 pdr0">
                                        <button @click="cancelBooking(booking.bid)" type="button" class="pd0 col-lg-12 col-md-12 col-sm-12 col-xs-12 btn btn-outline btn-danger newest-button">取消预约</button>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- 历史预约 -->
                    <div class="panel panel-default" v-show="historyList.length > 0" style="display: none">
                        <div class="panel-heading">
                            近期预约
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body clearfix">
                            <ul class="timeline">
                                <li @click="goToDetail(booking.bid)" v-for="booking in historyList" :class="booking.inverted ? 'timeline-inverted' : ''" class="pointer" >
                                    <a :href="'/?/booking/detail/' + booking.bid"></a>
                                    <div class="timeline-badge" :class="booking.badge">
                                        <span class="badge-date">{{ booking.simpleBookingDate }}</span>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-body">
<!--                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pd0 history">{{ booking.name }}</div>-->
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 pd0 history text-center">
                                                <!--
                                                        预约成功，申请拒绝，会议正在进行 开会成功 显示管理员操作的时间
                                                        预约取消 显示用户操作的时间
                                                        -->
                                                <span>{{ booking.bookingTimeFriendly }}</span>预定了<span class="text-info">{{ " " + booking.name }}</span>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pd0 history">
                                                <span v-if="booking.bookingStatus == 1" class="text-success">预约成功</span>
                                                <span v-if="booking.bookingStatus == 2" class="text-danger">申请被拒绝</span>
                                                <span v-if="booking.bookingStatus == 3" class="text-info">预约取消</span>
                                                <span v-if="booking.bookingStatus == 4" class="text-danger">预约过期</span>
                                                <span v-if="booking.bookingStatus == 5" class="text-info">会议正在进行中</span>
                                                <span v-if="booking.bookingStatus == 6" class="text-success">会议结束</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                            <div class="col-lg-12 text-center ">
                                <button @click="loadingMoreHistory" class="btn btn-default" style="width: 50%;color:darkgrey;font-size: large;border-color: darkgrey;">点击加载更多{{ historyList.length + "/" + historyTotal }}</button>
                            </div>


                        </div>
                        <!-- /.panel-body -->
                    </div>

                </div>
                <!-- /.col-lg-8 -->

                <!-- /.col-lg-4 -->
            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->

<script>
    userAppointment_VM = new Vue({
        el : "#userAppointment",
        data : {
            newestList : [],
            historyList : [],

            historyLimit : 10,
            historyPage : 1,

            historyTotal : 0,

            loadingMorePage : false,
        },
        methods : {
            // 取消预约
            cancelBooking : function(bid){
                var self = this;
                $.ajax({
                    url: "/?/api/booking/cancel/",
                    type: 'POST',
                    async: true,
                    data : {
                        bid : bid
                    },
                    dataType: 'json',
                    success: function (result) {
                        if(result.code == 1){
                            self.getHistoryList();
                            self.getNewestList();
                            hint_message.show('预约取消成功','success');

                        }else{
                            hint_message.show(result.msg,'alert');
                        }
                    }
                });
            },

            // 轮询获取列表
            checkBookingList : function(time = 10000){
                var self = this;
                setTimeout(function(){
                    self.getBookingList(false,true);
                    self.checkBookingList(time);
                },time);
            },

            // 查看详情
            goToDetail : function(bid){
                window.location.href = '/?/booking/detail/' + bid;
            },

            // 让一个时间动起来 hh mm ii
            activeTime: function(booking) {
                var self = this;
                if( booking.bookingLastSecond+1 == 60 ){
                    if( booking.bookingLastMinute+1 == 60 ){
                        booking.bookingLastHour += 1;
                        booking.bookingLastMinute = 0;
                        booking.bookingLastSecond = 0;
                    }else{
                        booking.bookingLastMinute += 1;
                        booking.bookingLastSecond = 0;
                    }
                }else{
                    booking.bookingLastSecond += 1;
                }

                setTimeout(function(){
                    self.activeTime(h,m,i)
                },1);

            },

            // 加载历史预约消息
            getHistoryList : function(){
                var self = this;
                var historyTotal = self.historyTotal;

                $.ajax({
                    url: "/?/api/booking/query/user_checked",
                    type: 'POST',
                    async: false,
                    data : {
                        limit : self.historyPage * self.historyLimit,
                        page : 1,
                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        if(result.code == 1){
                            self.historyList = result.data.historyList;
                            self.historyTotal = result.data.total;
                        }else{
                            hint_message.show(result.msg);
                        }

                        self.loadingMorePage = false;
                    }
                });
            },

            getNewestList : function(first = true,hint=true){
                var self = this;
                $.ajax({
                    url: "/?/api/booking/query/user_unchecked",
                    type: 'POST',
                    async: true,
                    data : {
                    },
                    dataType: 'json',
                    success: function (result) {
                        if(result.code == 1){
                            self.newestList = result.data.uncheckedList;
                        }else{
                            if(hint){
                                hint_message.show(result.msg);
                            }
                        }
                    }
                });
            },

            loadingMoreHistory : function(){
                var self = this;
                if(self.historyList.length == self.historyTotal){
                    hint_message.show('没有更多预约了','warning');
                    return 0;
                }
                self.historyPage += 1;
                self.getHistoryList();
            },

            // 轮询检查历史预约
            historyPolling : function(time = 1000){
                var self = this;
                setTimeout(function(){

                    $.ajax({
                        url: "/?/api/booking/query/user_checked",
                        type: 'POST',
                        async: true,
                        data : {
                            limit : self.historyPage * self.historyLimit,
                            page : 1,
                        },
                        dataType: 'json',
                        success: function (result) {
                            if(result.code == 1) {
                                self.historyList = result.data.historyList;
                                self.historyTotal = result.data.total;
                            }
                            self.historyPolling(time);
                        }
                    });

                },time);
            },

            newestPolling : function(time = 1000){
                var self = this;
                setTimeout(function(){
                    var newestLength = self.newestList.length;
                    $.ajax({
                        url: "/?/api/booking/query/user_unchecked",
                        type: 'POST',
                        async: true,
                        data : {},
                        dataType: 'json',
                        success: function (result) {

                            if(result.code == 1) {
                                self.newestList = result.data.uncheckedList;
                            }else{
                                self.newestList = [];
                            }

                            if(newestLength > self.newestList.length){
                                hint_message.show('预约状态发生了变化','warning');
                            }

                            self.newestPolling(time);
                        }
                    });
                },time);
            }

        }
    });


    userAppointment_VM.getHistoryList();
    userAppointment_VM.getNewestList();

    userAppointment_VM.historyPolling(1000);
    userAppointment_VM.newestPolling(1000);


    //    userAppointment_VM.getBookingList();
//    userAppointment_VM.checkBookingList(1000);
</script>

<?php $this->load->view('global/template_footer_meta')?>

<!-- /#wrapper -->

