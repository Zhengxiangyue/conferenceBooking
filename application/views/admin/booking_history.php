<?php $this->load->view('admin/component/common/header')?>

<div id="page-wrapper">
    <div id="bookingHistory">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="color: #007c8e">历史预约</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel-body clearfix">
                    <table id="tableBookingHistory" width="100%" class="table table-striped table-bordered table-hover" v-show="!renderNewTableData" style="display: none">
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
                            <td>{{booking.useDate + " " + booking.useBeginTime + " ~ " + booking.useEndTime}}</td>
                            <td>{{booking.bookingTime}}</td>
                            <td>{{booking.applicant}}</td>
                            <td>{{booking.name}}</td>
                            <td>{{booking.position}}</td>
                            <td v-if="booking.bookingStatus == 0">正在审批</td>
                            <td v-if="booking.bookingStatus == 1">审批通过</td>
                            <td v-if="booking.bookingStatus == 2">审批未通过</td>
                            <td v-if="booking.bookingStatus == 3">预约取消</td>
                            <td v-if="booking.bookingStatus == 4">预约过期</td>
                            <td v-if="booking.bookingStatus == 5">会议进行中</td>
                            <td v-if="booking.bookingStatus == 6">会议结束</td>
                        </tr>
                        </tbody>
                    </table>

                    <div v-show="renderNewTableData">新的数据加载</div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->

<script>



    userAppointment_VM = new Vue({
        el : "#bookingHistory",
        data : {
            bookingList : [],
            limit : 9999999,
            table : {},

            renderNewTableData : false,

            loadingMorePage : false,
        },
        methods : {
            getBookingList : function (first = true,hint=false) {
                var self = this;
                $.ajax({
                    url: "/?/api/booking/query/user",
                    type: 'POST',
                    async: true,
                    data : {
                        limit : self.limit,
                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        if(result.code == 1){
                            self.bookingList = result.data.bookingList;
                        }else{

                            if(result.code == -10){
                                window.location.href = '/?/user/login';
                            }else{

                            }
                        }

                        // 渲染列表
                        $(document).ready(function() {
                            self.table = $('#tableBookingHistory').DataTable({
                                responsive: true
                            });
                        });

                    }
                });
            },

            // 查看详情
            goToDetail : function(bid){
                window.location.href = '/?/booking/detail/' + bid;
            },

            bookingListPolling : function (time = 5000){
                var self = this;

                // 保存一下当前会议的个数，如果个数发生了变化从新渲染列表
                setTimeout(function(){

                    var length = self.bookingList.length;

                    $.ajax({
                        url: "/?/api/booking/query/user",
                        type: 'POST',
                        async: true,
                        data : {
                            limit : self.limit,
                        },
                        dataType: 'json',
                        success: function (result) {
                            if(result.code == 1) {
                                self.bookingList = result.data.bookingList;
                                if(length < self.bookingList.length){
                                    self.renderNewTableData = true;
                                    // 间隔时间让vue渲染数据
                                    self.table.destroy();
                                    setTimeout(function(){
                                        self.table = $('#tableBookingHistory').DataTable({
                                            responsive: true
                                        });
                                        self.renderNewTableData = false;
                                    },5)

                                }
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
    userAppointment_VM.bookingListPolling();

</script>

<?php $this->load->view('global/template_footer_meta')?>

<!-- /#wrapper -->

