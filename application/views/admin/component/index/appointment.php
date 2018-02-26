
<div id="adminAppointment" class="row" v-show="true" style="display: none">
    <div class="col-lg-12">
        <h1 class="page-header" style="color: #007c8e">预约管理</h1>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <!-- 最新预约 -->
        <div class="panel panel-default">
            <div class="panel-heading">
                等待审核
            </div>
            <!-- /.panel-heading -->
<!--            <transition-group name="list" tag="div">-->
            <div v-if="uncheckedList.length>0" :key="booking" v-for="booking in uncheckedList" v-slide-show="true">
                <div class="panel-body clearfix">
                    <div class="waiting col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                        <div class="pd0 col-lg-12 col-md-12 col-sm-12 col-xs-12 waitingContent">
                            <span class="waitingItem">预约时间 : </span><span>{{ booking.bookingTime + "  (" + booking.bookingTimeFriendly + ")" }}</span>
                            <span class="waitingItem" v-if="booking.lastEditTime.length > 0">最后编辑时间 : {{ booking.lastEditTime + "  (" + booking.lastEditTimeFriendly + ")" }}</span>
                        </div>

                    </div>
                    <div class="waitingDark col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                        <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                            <span class="waitingItem">预约编号 : </span>{{ booking.serialNumber }}
                        </div>
                        <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                            <span class="waitingItem">日期 : </span>{{ booking.useDate }}
                        </div>
                        <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                            <span class="waitingItem">会议时间 : </span>{{ booking.useBeginTime }}-{{ booking.useEndTime }}
                        </div>
                        <div class="tpd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                            <span class="waitingItem">会议室 : </span>{{ booking.name }}
                            <span v-if="booking.conferenceRoomStatus == 0" class="waitingItem text-danger">(会议室已删除)</span>
                        </div>

                    </div>
                    <div class="waiting col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                        <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                            <span class="waitingItem">姓名 : </span><span>{{ booking.applicant }}</span>
                        </div>
                        <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                            <span class="waitingItem">联系电话 : </span><span>{{ booking.applicantMobile }}</span>
                        </div>
                        <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                            <span class="waitingItem">部门 : </span><span>{{ booking.department }}</span>
                        </div>
                        <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                            <span class="waitingItem">参会人数 : </span>{{ booking.applicant }}
                        </div>

                    </div>
                    <div class="waitingDark col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                        <div class="pd0 col-lg-12 col-md-12 col-sm-12 col-xs-12 waitingContent">
                            <span class="waitingItem ">会议简介 : </span>{{ booking.introduction }}
                        </div>
                    </div>
                    <div class="waiting col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                        <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                            <span class="waitingItem">其他需求 : </span> {{ booking.need }}
                        </div>
                    </div>
                    <div class="waitingDark col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                        <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                            <span class="waitingItem">特别要求 : </span> {{ booking.specialNeed }}
                        </div>
                    </div>
                    <!-- 通过 拒绝 按钮-->
                    <div class="text-right col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0">
                        <button @click="passBooking(booking.bid,$event)" class="btn btn-success waitingButton">通过</button>
                        <button @click="refuseBooking(booking.bid)" class="btn btn-danger btn-outline waitingButton">拒绝</button>
<!--                        <button class="btn btn-danger btn-outline waitingButton">删除该条预约</button>-->
                    </div>
                </div>
                <hr style="margin-top: 0"/>
            <!-- /.panel-body -->
            </div>
<!--            </transition-group>-->
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                最近预约
            </div>
            <!-- /.panel-heading -->
            <!--            <transition-group name="list" tag="div">-->
            <div v-if="checkedList.length>0" class="panel-body clearfix" v-slide-show="true">
                    <div v-for="booking in checkedList" class="clearfix" style="margin-bottom: 20px">
                        <div class="waiting col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                            <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent tooltip-demo">

                                <span class="waitingItem">预约时间 : </span>
                                <span :title="booking.bookingTime">{{ booking.bookingTimeFriendly }}</span>
                            </div>

                            <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                                <span class="waitingItem">审核时间 : </span>
                                <span :title="booking.checkTime">{{  booking.checkTimeFriendly ? booking.checkTimeFriendly : '未审核' }}</span>
                            </div>

                            <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                                <span class="waitingItem">申请人 : </span>
                                <span :title="booking.checkTime">{{  booking.applicant }}</span>
                            </div>

                            <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                                <span class="waitingItem">订单状态 : </span>
                                <span style="font-weight: 500" v-if="booking.bookingStatus == 0" class="text-warning">等待审核</span>
                                <span style="font-weight: 500" v-if="booking.bookingStatus == 1" class="text-success">审核通过，准备开会</span>
                                <span style="font-weight: 500" v-if="booking.bookingStatus == 2" class="text-danger">预约遭到拒绝</span>
                                <span style="font-weight: 500" v-if="booking.bookingStatus == 3" class="text-warning">预约取消</span>
                                <span style="font-weight: 500" v-if="booking.bookingStatus == 4" class="text-danger">预约已经过期</span>
                                <span style="font-weight: 500" v-if="booking.bookingStatus == 5" class="text-success">会议正在进行中</span>
                                <span style="font-weight: 500" v-if="booking.bookingStatus == 6" class="text-success">会议已经圆满结束</span>
                            </div>

                        </div>
                        <div class="waitingDark col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                            <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                                <span class="waitingItem">预约编号 : </span>{{ booking.serialNumber }}
                            </div>
                            <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                                <span class="waitingItem">日期 : </span>{{ booking.useDate }}
                            </div>
                            <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                                <span class="waitingItem">会议时间 : </span>{{ booking.useBeginTime }}-{{ booking.useEndTime }}
                            </div>
                            <div class="tpd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                                <span class="waitingItem">会议室 : </span>{{ booking.name }}
                                <span v-if="booking.conferenceRoomStatus == 0" class="waitingItem text-danger">(会议室已删除)</span>
                            </div>

                        </div>
                        <div class="waiting col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                            <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                                <span class="waitingItem">姓名 : </span><span>{{ booking.applicant }}</span>
                            </div>
                            <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                                <span class="waitingItem">联系电话 : </span><span>{{ booking.applicantMobile }}</span>
                            </div>
                            <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                                <span class="waitingItem">部门 : </span><span>{{ booking.department }}</span>
                            </div>
                            <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                                <span class="waitingItem">参会人数 : </span>{{ booking.number }}
                            </div>

                        </div>
                        <div class="waitingDark col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                            <div class="pd0 col-lg-12 col-md-12 col-sm-12 col-xs-12 waitingContent">
                                <span class="waitingItem ">会议简介 : </span>{{ booking.introduction }}
                            </div>
                        </div>
                        <div class="waiting col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                            <div class="pd0 col-lg-12 col-md-12 col-sm-12 col-xs-12 waitingContent">
                                <span class="waitingItem">其他需求 : </span> {{ booking.need }}
                            </div>
                        </div>
                        <div class="waitingDark col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                            <div class="pd0 col-lg-12 col-md-12 col-sm-12 col-xs-12 waitingContent">
                                <span class="waitingItem">特别要求 : </span> {{ booking.specialNeed }}
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border: 1px solid #efefef;margin-top: 20px"></div>
                    </div>
                    <div class="col-lg-12 text-center ">
                        <button @click="loadMore" :class="total == checkedList.length ? 'disabled' : ''" class="btn btn-default" style="width: 50%;color:darkgrey;font-size: large;border-color: darkgrey;">
                            <span v-if="checkedList.length < total">点击加载更多</span>
                            <span v-if="checkedList.length == total">没有更多预约了</span>
                            {{ checkedList.length + "/" + total }}
                        </button>
                    </div>
                <!-- /.panel-body -->
            </div>


            <!--            </transition-group>-->
        </div>
    </div>
</div>

<script>
    admin_appointment_VM = new Vue({
        el: "#adminAppointment",
        data: {
            uncheckedList : [],
            checkedList : [],

            total : 0,

            limit : 10,
        },
        methods : {
            // 获取等待审核的列表
            getUncheckedList : function(first = true, hint = false){
                var self = this;
                var uncheckedListLength = self.uncheckedList.length;
                $.ajax({
                    url: "/?/api/booking/query/admin_unchecked",
                    type: 'POST',
                    async: true,
                    data : {
                        limit : 20,
                    },
                    dataType: 'json',
                    success: function (result) {
                        if(result.code == 1){
                            self.uncheckedList = result.data.uncheckedList;
                            if(first){
                                hint_message.show('获取列表成功','success');
                            }else{
                                if(hint){
                                    if (uncheckedListLength < self.uncheckedList.length){
                                        hint_message.show('有人刚刚提交了新的预约','warning');
                                    }else if(uncheckedListLength > self.uncheckedList.length){
//                                        hint_message.show('预约处理成功','warning');
                                    }else{
                                    }
                                }
                            }
                        }else{
                            if(first){
                                hint_message.show(result.msg,'alert');
                            }else{
                                if(hint){
                                    if (uncheckedListLength > self.checkedList.length){
                                        hint_message.show(result.msg,'danger');
                                    }else if(uncheckedListLength < self.checkedList.length){
                                        hint_message.show(result.msg,'danger');
                                    }else{

                                    }
                                }
                            }
                        }
                    }
                });
            },

            // 获取历史预约记录
            getHistoryList : function(first = true, hint = false){
                var self = this;
                $.ajax({
                    url: "/?/api/booking/query/admin_checked",
                    type: 'POST',
                    async: true,
                    data : {
                        limit : self.limit,
                    },
                    dataType: 'json',
                    success: function (result) {
                        if(result.code == 1){
                            self.checkedList = result.data.historyList;
                            self.total = result.data.total;
                        }else{
                            hint_message.show(result.msg,'alert');
                        }
                    }
                });
            },

            // 点击加载更多按钮
            loadMore : function(){
                var self = this;
                if(self.total == self.checkedList.length){
                    return 0;
                }
                self.limit += 10;
                self.getHistoryList(false,false);
            },

            // 通过审核
            passBooking : function(bid,event){
                var self = this;
                $.ajax({
                    url: "/?/api/booking/pass/",
                    type: 'POST',
                    async: true,
                    data : {
                        bid : bid,
                    },
                    dataType: 'json',
                    success: function (result) {
                        if(result.code == 1){
                            hint_message.show('会议室预约成功','success');
                            self.getUncheckedList();
                            self.getHistoryList()
                        }else{
                            hint_message.show(result.msg,'danger');
                        }
                    }
                });
            },

            // 拒绝通过审核
            refuseBooking : function(bid){
                var self = this;
                $.ajax({
                    url: "/?/api/booking/refuse/",
                    type: 'POST',
                    async: true,
                    data : {
                        bid : bid,
                    },
                    dataType: 'json',
                    success: function (result) {
                        if(result.code == 1){
                            hint_message.show('成功的拒绝了预约请求','success');

                            setTimeout(function(){
                                self.getUncheckedList();
                                self.getHistoryList();
                            },100)

                        }else{
                            hint_message.show(result.msg,'danger');
                        }
                    }
                });
            },

            // 轮训更新会议室预约情况
            polling : function(time = 1000){
                var self = this;
                self.getUncheckedList(false,true);
                self.getHistoryList(false,true);
                setTimeout(function(){
                    self.polling(time);
                },time)
            },
        },
    });

    admin_appointment_VM.getUncheckedList();
    admin_appointment_VM.getHistoryList();
    admin_appointment_VM.polling();

</script>
