<?php $this->load->view('user/component/header')?>
<div id="page-wrapper">

    <!--  顶部标题  -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header" style="color: #007c8e">会议室详情</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div id="userRoomDetail" class="row" style="display: none" v-show="true">

        <!--  当前会议室总数  -->
        <div v-show="showRoomImgList" class="col-lg-12 col-md-12 col-sm-12  text-left editHeadButton">
            <span style="font-size: large">当前会议室总数 : {{ roomDetail.length }}</span>
            <!--        <button @click="hideOrShowRooms" class="btn btn-primary">{{ hideOrShow }}</button>-->
        </div>

        <!--  会议室图片列表  -->
        <div v-show="showRoomImgList">

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" v-for="(room,index) in roomDetail">
                <div class="panel panel-default pointer hoverRoom">
                    <div class="panel-heading clearfix">
                        <div class="col-lg-12">{{ room.name }}</div>
                    </div>
                    <!--会议室图片    -->
                    <div class="panel-body clearfix"  @click="clickRoom(room.cid)">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img style="width: 100%;" :src="roomDetail[index].images.split(',')[0] ? '<?=base_url('upload/room/')?>' + roomDetail[index].images.split(',')[0] : '<?=base_url('static/images/img02.png')?>'" />
                        </div>
                    </div>
                    <!--会议室地点    -->
                    <div class="panel-footer" v-html="roomDetail[index].position ? roomDetail[index].position : '<span style=\'color:#f0ad4e\'>未添加会议室地点</span>'">
                    </div>
                </div>
            </div>

        </div>

        <!-- 会议室详情-->
        <div v-show="showRoomDetail" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!-- 最新预约 -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    会议室详情
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body clearfix editRoom">
                    <!--上传图片-->
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pd0 clearfix">
                        <div class="text-center col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                            <img id="roomImg" class="img-rounded img-thumbnail" style="width: 76%" :src=" detailEara.images == undefined || detailEara.images == '' ? '<?=base_url()?>static/images/default-img.png' : '<?=base_url()?>upload/room/300x400/' + detailEara.images.split(',')[0]"/>
                        </div>

                    </div>
                    <div class="editRoomForm col-lg-8 col-md-8 col-sm-8 col-xs-8 clearfix">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    会议室 :
                                </label>
                                <label class="col-sm-6 control-label-2">
                                    {{ detailEara.name }}
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    会议室地点 :
                                </label>
                                <label class="col-sm-6 control-label-2">
                                    {{ detailEara.position }}
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    可容纳人数 :
                                </label>
                                <label class="col-sm-6 control-label-2">
                                    {{ detailEara.capacity }}
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    是否开放 :
                                </label>
                                <label class="col-sm-6 control-label-2">
                                    {{ detailEara.open ? '是' : '否' }}
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    开放时段 :
                                </label>
                                <label class="col-sm-6 control-label-2">
                                    {{ detailEara.openBeginTime }} - {{ detailEara.openEndTime }}
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    负责人 :
                                </label>
                                <label class="col-sm-6 control-label-2">
                                    {{ detailEara.personInCharge }}
                                </label>

                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    备注 :
                                </label>
                                <p class="col-sm-6 control-label-2">
                                    {{ detailEara.remark }}
                                </p>
                            </div>
                            <div class="col-sm-12 text-right">
                                <img id="loadingIcon" style="width: 3%;display: none" src="<?=base_url()?>static/images/loading.gif">
                                <button @click="backToRoomList" class="btn btn-warning">返回</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--  会议室预约时刻表  -->
        <div v-show="showRoomDetail" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!-- 最新预约 -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    未来七天预约时间表
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body clearfix editRoom">
                    <table class="table table-bordered">
                        <tbody>
                        <tr v-for="n in bookingTable">
                            <td style="vertical-align: middle;text-align: center" v-for="m in n" v-html="m.html" :class="m.type == 0 ? 'info':(m.type == 3 ? 'success' : (m.type == 2 ? 'warning' : 'danger' ))"></td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    admin_room_VM = new Vue({
        el: "#userRoomDetail",
        data: {

            transition : true,

            roomDetail : [],
            roomDetailObj : {},
            showRoomImgList : true,
            showAddRoom : false,
            showRoomDetail : false,

            selectedList : [],

            // 编辑区的内容
            editEara : {},

            // 详情区域的内容
            detailEara : {},

            // 预约表
            bookingTable : [],
        },
        methods : {
            // 获取会议室详情
            getRoomDetail : function(){
                var self = this;
                $.ajax({
                    url: "/?/api/room/query/",
                    type: 'POST',
                    async: true,
                    dataType: 'json',
                    data : {
                        limit : 100
                    },
                    success: function (result) {
                        if(result.code == 1){
                            self.roomDetail = result.data.room;
                            self.roomDetailObj = result.data.index;
                        }else{
                            hint_message.show('获取会议室内容失败','alert');
                        }

                    }
                });
            },

            // 点击新增会议室按钮
            addNewRoom : function(){
                var self = this;
                self.showAddRoom = !self.showAddRoom;
            },

            // 点击了会议室
            clickRoom : function (cid){
                var self = this;
                self.detailEara = self.roomDetailObj[cid];
                self.getBookingTatble(cid);
                self.showRoomImgList = false;
                self.showRoomDetail = true;
            },

            // 点击上传图片按钮
            clickUploadImage : function(){
                $('#fileupload').click();
            },

            // 点击保存会议室
            clickSaveRoom : function(){
                var self = this;

                if(!self.editEara.name){
                    hint_message.show('请输入会议室的名称','danger')
                    return 0;
                }

                if(!self.editEara.position){
                    hint_message.show('请输入会议室的地点','danger')
                    return 0;
                }

                if(!self.editEara.capacity){
                    hint_message.show('请输入可容纳人数','danger')
                    return 0;
                }

                document.getElementById("loadingIcon").style.display = 'inline-block';

                $.ajax({
                    url: "/?/api/room/add/",
                    type: 'POST',
                    async: true,
                    data: {
                        name : self.editEara.name,
                        position : self.editEara.position,
                        open : self.editEara.open,
                        openBeginTime : self.editEara.openBeginTime,
                        capacity : self.editEara.capacity,
                        openEndTime : self.editEara.openEndTime,
                        personInCharge : self.editEara.personInCharge,
                        mobile : self.editEara.mobile,
                        remark : self.editEara.remark,
                        images : self.editEara.images,
                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        if(result.code == 1){
                            // 从新获取会议室的信息
                            self.getRoomDetail();
                            // 选中最后一个会议室

                            hint_message.show('新的会议室保存成功','success');
                            document.getElementById("loadingIcon").style.display = 'none';

                            setTimeout(function(){
                                self.showAddRoom = false;
                                self.editEara = {};
//                                self..src = undefined;
                            },1000);


                        }
                    }
                });
            },

            // 隐藏或显示房间列表
            hideOrShowRooms : function(){
                var self = this;
                self.showRoomImgList = !self.showRoomImgList;
            },

            // 删除会议室
            deleteRoomAction : function(cid){
                var self = this;

                $.ajax({
                    url: "/?/api/room/delete/",
                    type: 'POST',
                    async: true,
                    data: {
                        cid : cid
                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        if(result.code == 1){
                            // 从新获取会议室的信息
                            self.getRoomDetail();
                            // 选中最后一个会议室

                            hint_message.show(result.msg,'success');

                        }
                    }
                });

            },

            // 点击编辑会议室按钮
            clickEditRoom : function(){

                hint_message.show('您的权限不够，无法编辑会议室','danger')

            },

            // 返回列表
            backToRoomList : function(){
                var self = this;
                self.showRoomDetail = false;
                self.showRoomImgList = true
            },

            // 获取一个会议室的预约情况
            getBookingTatble : function(cid){
                var self = this;
                $.ajax({
                    url: "/?/api/booking/query/table",
                    type: 'POST',
                    async: false,
                    data: {
                        cid : cid,
                        start : curentTime(),
                        last : 7,
                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        self.bookingTable = result.data;
                    }
                });

            }


        },
        computed: {

            newRoomButtonContent : function () {
                var self = this;
                return self.showAddRoom ? '取消' : '新增会议室';
            },
            hideOrShow : function(){
                var self = this;
                return self.showRoomImgList ? '隐藏' : '显示';
            },



        }
    })
    admin_room_VM.getRoomDetail();
</script>

<?php $this->load->view('global/template_footer_meta')?>
