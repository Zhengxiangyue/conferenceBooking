<?php $this->load->view('user/component/header')?>

<div id="page-wrapper">
    <div id="bookingDetail">
        <!-- 顶部标题 -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="color: #007c8e">预约(会议)详情</h1>
            </div>
        </div>

        <div class="clearfix" v-show="true" style="display: none">
            <div class="waitingDark col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                <div class="pd0 col-lg-4 col-md-4 col-sm-4 col-xs-4 waitingContent">
                    <span class="waitingItem">订单状态 : </span>
                    <span style="font-weight: 500" v-if="booking.bookingStatus == 0" class="text-info">等待审核</span>
                    <span style="font-weight: 500" v-if="booking.bookingStatus == 1" class="text-success">审核通过，准备开会</span>
                    <span style="font-weight: 500" v-if="booking.bookingStatus == 2" class="text-danger">预约遭到拒绝</span>
                    <span style="font-weight: 500" v-if="booking.bookingStatus == 3" class="text-warning">预约取消</span>
                    <span style="font-weight: 500" v-if="booking.bookingStatus == 4" class="text-danger">预约已经过期</span>
                    <span style="font-weight: 500" v-if="booking.bookingStatus == 5" class="text-success">会议正在进行中</span>
                    <span style="font-weight: 500" v-if="booking.bookingStatus == 6" class="text-success">会议已经圆满结束</span>
                </div>

                <div class="pd0 col-lg-4 col-md-4 col-sm-4 col-xs-4 waitingContent">
                    <span v-if="booking.bookingStatus == 0" class="waitingItem">订单提交时间 : </span>
                    <span v-if="booking.bookingStatus == 1" class="waitingItem">预定通过时间 : </span>
                    <span v-if="booking.bookingStatus == 2" class="waitingItem">预定拒绝时间 : </span>
                    <span v-if="booking.bookingStatus == 3" class="waitingItem">取消订单时间 : </span>
                    <span v-if="booking.bookingStatus == 5" class="waitingItem">会议结束时间 : </span>
                    <span v-if="booking.bookingStatus == 6" class="waitingItem">会议结束时间 : </span>

                    <span v-if="booking.bookingStatus == 0" data-toggle="tooltip" data-placement="top" :title="booking.bookingTime">{{ booking.bookingTimeFriendly }}</span>
                    <span v-if="booking.bookingStatus == 1" data-toggle="tooltip" data-placement="top" :title="booking.checkTime">{{ booking.checkTimeFriendly}}</span>
                    <span v-if="booking.bookingStatus == 2" data-toggle="tooltip" data-placement="top" :title="booking.checkTime">{{ booking.checkTimeFriendly}}</span>
                    <span v-if="booking.bookingStatus == 3" data-toggle="tooltip" data-placement="top" :title="booking.lastEditTime">{{ booking.lastEditTimeFriendly}}</span>
                    <span v-if="booking.bookingStatus == 5" data-toggle="tooltip" data-placement="top" :title="booking.meetEndTime">{{ booking.meetingEndTimeFriendly }}</span>
                    <span v-if="booking.bookingStatus == 6" data-toggle="tooltip" data-placement="top" :title="booking.meetEndTime">{{ booking.meetingEndTimeFriendly }}</span>
                </div>

                <div class="pd0 col-lg-4 col-md-4 col-sm-4 col-xs-4 waitingContent">
                    <span v-if="booking.bookingStatus == 1" class="waitingItem">距离会议 : </span>
                    <span v-if="booking.bookingStatus == 1" data-toggle="tooltip" data-placement="top" :title="booking.meetStartTime">{{ booking.meetingBeginTimeFriendly }}</span>
                </div>

            </div>
            <div class="waiting col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                <div class="pd0 col-lg-4 col-md-4 col-sm-4 col-xs-4 waitingContent">
                    <span class="waitingItem">预约时间 : </span><span data-toggle="tooltip" data-placement="top" :title="booking.bookingTime">{{  booking.bookingTimeFriendly }}</span>
                </div>
                <div class="pd0 col-lg-4 col-md-4 col-sm-4 col-xs-4 waitingContent">
                        <span class="waitingItem">审核时间 : </span><span data-toggle="tooltip" data-placement="top" :title="booking.checkTime">{{  booking.checkTimeFriendly ? booking.checkTimeFriendly : '未审核' }}</span>
                </div>

            </div>
            <div class="waitingDark col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                    <span class="waitingItem">预约编号 : </span>{{ booking.serialNumber }}
                </div>
                <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                    <span class="waitingItem">会议日期 : </span>{{ booking.useDate }}
                </div>
                <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                    <span class="waitingItem">会议时间 : </span>{{ booking.useBeginTime }}~{{ booking.useEndTime }}
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
        </div>
        <div class="row col-lg-12 text-right" style="margin-top: 20px">
            <button @click="goBack" class="btn btn-success">返回</button>
        </div>

    </div>
</div>

<script>
    booking_detail_VM = new Vue({
        el : "#bookingDetail",
        data : {
            bid : '<?=$bid?>',
            booking : {},
        },
        methods : {
            getBookingDetail : function(){
                var self = this;
                $.ajax({
                    url: "/?/api/booking/query/one/",
                    type: 'POST',
                    async: true,
                    data : {
                        bid : self.bid,
                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        if(result.code == 1){
                            self.booking = result.data;
                        }else{
                            hint_message.show(result.msg)
                        }
                    }
                });
            },
            goBack : function(){
                history.go(-1);
            }
        }
    })
    booking_detail_VM.getBookingDetail();
</script>

<?php $this->load->view('global/template_footer_meta')?>

