<?php $this->load->view('admin/component/common/header')?>
<style>
    .btn-default:focus {
        outline: none;
        background-color: white;
    }
    .heavy{
        font-weight:900;
    }
</style>
<div id="page-wrapper">
    <div id="bookingHistory">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="color: #007c8e">历史预约</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row" style="display: none" v-show="showTable">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel-body clearfix">
                    <table width="100%" id="tableBookingHistory" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>预定号</th>
                            <th>会议名称</th>
                            <th>会议时间</th>
                            <th>预约时间</th>
                            <th>预约人</th>
                            <th>会议室</th>
                            <th>会议室地址</th>
                            <th>审批状态</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="booking in bookingList">
                            <td>{{booking.serialNumber}}</td>
                            <td>{{booking.meetingName}}</td>
                            <td>{{booking.useDate + " " + booking.useBeginTime}}</td>
                            <td>{{booking.bookingTime}}</td>
                            <td>{{booking.applicant}}</td>
                            <td>{{booking.name}}</td>
                            <td>{{booking.position}}</td>
                            <td v-if="booking.bookingStatus == 0">正在审批</td>
                            <td v-if="booking.bookingStatus == 1">会议即将进行</td>
                            <td v-if="booking.bookingStatus == 2">审批未通过</td>
                            <td v-if="booking.bookingStatus == 3">预约取消</td>
                            <td v-if="booking.bookingStatus == 4">预约过期</td>
                            <td v-if="booking.bookingStatus == 5">会议进行中</td>
                            <td v-if="booking.bookingStatus == 6">会议结束</td>
                        </tr>
                        </tbody>
                    </table>
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
        el : "#bookingHistory",
        data : {
            bookingList : [],
            // 数据量较少的情况下加载全部
            limit : 99999,
            page : 1,
            total : 0,

            showTable : false,

            loadingMorePage : false,
        },
        methods : {
            getBookingList : function (first = true,hint=false) {
                var self = this;

//                setTimeout(function(){
//                    hint_message.show('正在获取数据...','warning',5000);
//                },10)

                $.ajax({
                    url: "/?/api/booking/query/admin_meeting",
                    type: 'POST',
                    async: true,
                    data : {
                        limit : self.limit,
                    },
                    dataType: 'json',
                    success: function (result) {
                        if(result.code == 1){

                            // 列表渲染完成的时间
                            $(document).on( 'init.dt', function ( e, settings ) {
                                if(self.bookingList.length > 1000){
                                    hint_message.show('列表渲染完成','success',2000);
                                }
                                self.showTable = true;
                            } );

                            // 渲染列表
                            $(document).ready(function() {
                                self.table = $('#tableBookingHistory').DataTable({
                                    responsive: true
                                });
                            });

                            self.bookingList = result.data.historyMeeting;
                            self.total = result.data.meeingNum;


                            if(self.bookingList.length > 1000) {
                                hint_message.show('正在渲染数据列表...', 'warning', 10000);
                            }else{
                                hint_message.closeHint();
                            }



                        }else{

                            if(result.code == -10){
                                window.location.href = '/?/user/login';
                            }else{

                            }
                        }
                    }
                });
            },

            loadingExactPage : function(page){
                var self = this;
                self.page = page;
                self.getBookingList();
            },
            loadingNextPage : function(){
                var self = this;
                if(self.page == self.pageNum){
                    return 0;
                }
                self.page += 1;
                self.getBookingList();
            },
            loadingPrevPage : function(){
                var self = this;
                if(self.page == 1){
                    return 0;
                }
                self.page -= 1;
                self.getBookingList();
            },

            // 查看详情
            goToDetail : function(bid){
                window.location.href = '/?/booking/detail/' + bid;
            },

            bookingListPolling : function (time = 5000){
                var self = this;
                setTimeout(function(){

                    $.ajax({
                        url: "/?/api/booking/query/user",
                        type: 'POST',
                        async: true,
                        data : {
                            limit : self.limit,
                            page : self.page,
                        },
                        dataType: 'json',
                        success: function (result) {
                            if(result.code == 1) {
                                self.bookingList = result.data.historyMeeting;
                                self.total = result.data.meeingNum;
                            }
                            self.bookingListPolling(time);
                        }
                    });

                },time);
            }

        },
        computed : {
            pageNum : function(){
                var self = this;
                return Math.ceil(self.total/self.limit);
            }
        },
    });


    userAppointment_VM.getBookingList();
    //    userAppointment_VM.bookingListPolling();
</script>

<?php $this->load->view('global/template_footer_meta')?>

<!-- /#wrapper -->

