<?php $this->load->view('admin/component/common/header')?>

<div id="page-wrapper">
    <div id="myMeeting">
        <div class="row"  >
            <div class="col-lg-12">
                <h1 class="page-header" style="color: #007c8e">近期会议</h1>
                <!--  我的会议包括即将要开的会和正在开的会       -->
            </div>

            <div v-for="booking in myMeeting" style="display: none" v-show="myMeeting.length>0">
                <div class="panel-body clearfix">
                    <div class="waiting col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                        <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent tooltip-demo">
                            <span class="waitingItem">
                                会议开始时间 :
                            </span>
                            <span data-toggle="tooltip" data-placement="top" :title="booking.useDate +' '+ booking.useBeginTime + '~' + booking.useEndTime ">
                                {{ booking.meetingBeginTimeFriendly }}
                            </span>
                            <!--                            <span class="waitingItem" v-if="booking.lastEditTime.length > 0">-->
                            <!--                                最后编辑时间 :-->
                            <!--                            </span>-->
                            <!--                            <span data-toggle="tooltip" data-placement="top" :title="booking.lastEditTime">-->
                            <!--                                {{ booking.lastEditTimeFriendly }}-->
                            <!--                            </span>-->
                        </div>

                        <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent tooltip-demo">
                            <span class="waitingItem">
                                会议名称 :
                            </span>
                            <span data-toggle="tooltip" data-placement="top" :title="booking.useDate +' '+ booking.useBeginTime + '~' + booking.useEndTime ">
                                {{ booking.meetingName }}
                            </span>
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
                        <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                            <span class="waitingItem">其他需求 : </span> {{ booking.need }}
                        </div>
                    </div>
                    <div class="waitingDark col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                        <div class="pd0 col-lg-3 col-md-3 col-sm-3 col-xs-3 waitingContent">
                            <span class="waitingItem">特别要求 : </span> {{ booking.specialNeed }}
                        </div>
                    </div>
                </div>
                <hr style="margin-top: 0"/>
                <!-- /.panel-body -->
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-ld-12 text-center" style="margin-bottom: 20px;display: none" v-show="true">
                <button :class=" myMeeting.length == total ? 'disabled' : ''" @click="loadMore" class="btn btn-default" style="width: 30%">
                    <span v-show="myMeeting.length < total">加载更多 {{ myMeeting.length + "/" + total }}</span>
                    <span v-show="myMeeting.length == total">没有更多会议</span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->

<script>
    userAppointment_VM = new Vue({
        el : "#myMeeting",
        data : {
            myMeeting : [],
            total : 0,
            page : 1,
        },
        methods : {
            getBookingList : function (first = true,hint=false) {
                var self = this;
                $.ajax({
                    url: "/?/api/booking/query/admin_future_meeting",
                    type: 'POST',
                    async: true,
                    data : {
                        limit : self.page * 2,
                        order : 'useDate ASC, useBeginTime ASC'
                    },
                    dataType: 'json',
                    success: function (result) {
//                        console.log(result);
                        if(result.code == 1){

                            self.myMeeting = result.data.myMeeting;
                            self.total = result.data.meeingNum;
                            setTimeout(function(){
                                $('.tooltip-demo').tooltip({
                                    selector: "[data-toggle=tooltip]",
                                    container: "body"
                                })
                            },500);


                        }else{

                        }
                    }
                });
            },

            loadMore : function (){
                var self = this;
                if(self.myMeeting.length == self.total){
                    return 0;
                }
                self.page += 1;
                self.getBookingList();

            },

            bookingListPolling : function(){
                var self = this;
                setTimeout(function(){
                    self.getBookingList();
                    self.bookingListPolling();
                },1000);
            }
        }
    });

    userAppointment_VM.getBookingList();
    userAppointment_VM.bookingListPolling();




</script>

<?php $this->load->view('global/template_footer_meta')?>

<!-- /#wrapper -->

