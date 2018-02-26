<?php $this->load->view('user/component/header')?>

    <div id="page-wrapper" class="row">
        <div id="newBooking" style="display: none" v-show="true">
            <!-- 顶部标题 -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" style="color: #007c8e">添加预约</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!--   进程展示    -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pro">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center processContent processComplete">
                        1.选择会议时间
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center processContent" :class="showChoosingRoom ? 'processComplete' : ''">
                        2.选择会议室
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center processContent" :class="showWriteInfo ? 'processComplete' : ''">
                        3.填写预约信息
                    </div>
                </div>
            </div>

            <!-- 第三部  填写预约信息 -->
            <div style="display: none" v-slide-show="showWriteInfo" class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        填写预约信息
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body clearfix editRoom">

                        <div  class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <div class="form-horizontal">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        会议室 :
                                    </label>
                                    <label v-if="selectedId != ''" class="col-sm-6 control-label-2">
                                        {{ roomDetailObj[selectedId].name }}
                                    </label>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        会议室地点 :
                                    </label>
                                    <label v-if="selectedId != ''" class="col-sm-6 control-label-2">
                                        {{ roomDetailObj[selectedId].position }}
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        会议时间 :
                                    </label>
                                    <label v-if="selectedId != ''" class="col-sm-6 control-label-2">
                                        {{ useDate + ' ' + useBeginTime + '~' + useEndTime }}
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        会议名称 :
                                    </label>
                                    <div class="col-sm-6">
                                        <input v-model="meetingName" :disabled="selectedId == ''  ? true : false" type="text" class="form-control"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        申请人姓名 :
                                    </label>
                                    <div class="col-sm-6">
                                        <input v-model="applicant" :disabled="selectedId == ''  ? true : false" type="text" class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        申请人部门 :
                                    </label>
                                    <div class="col-sm-6">
                                        <input v-model="department" :disabled="selectedId == ''  ? true : false" type="text" class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        申请人电话 :
                                    </label>
                                    <div class="col-sm-6">
                                        <input v-model="mobile" :disabled="selectedId == ''  ? true : false" type="text" class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        参会人数 :
                                    </label>
                                    <div class="col-sm-6">
                                        <input v-model="participateNum" :disabled="selectedId == ''" type="text" class="form-control"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        需求 :
                                    </label>
                                    <div class="col-sm-6" v-if="selectedId != ''">
                                        <div class="checkbox">
                                            <label v-for="item in needList" style="margin-left: 10px">
                                                <input v-model="needs" :value="item" type="checkbox" /> {{ item }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        特殊需求 :
                                    </label>
                                    <div class="col-sm-6">
                                        <textarea v-model="specialNeed" :disabled="selectedId == ''  ? true : false" style="width: 200%;max-width: 200%" class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        会议简介 :
                                    </label>
                                    <div class="col-sm-6">
                                        <textarea v-model="introduction" :disabled="selectedId == ''  ? true : false" style="width: 200%;max-width: 200%" class="form-control"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <button @click="bookNewRoom" :class="selectedId == '' ? 'disabled' : ''" style="width: 25%" class="btn btn-success">完成预约</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 第二部  选择会议室 -->
            <div style="display: none" v-slide-show="showChoosingRoom" class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        选择会议室
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body clearfix editRoom">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="margin-bottom: 20px">
                            <button :class="selectedId == '' ? 'disabled' : ''" @click="confirmSelectRoom" style="width: 25%" class="btn btn-success">确认选择</button>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" v-for="(room,index) in roomDetail">
                            <div class="panel panel-default" :class="selectedId == room.cid ? 'greenBorder' : ''">
                                <div class="panel-heading clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">{{ room.name }}</div>
                                </div>
                                <div v-show="selectedId == room.cid" style="position: absolute;z-index: 12321312;right:10%;top:20%">
                                    <i class="fa fa-check-circle-o" style="color: #5cb85c;font-size: xx-large"></i>
                                </div>
                                <!--会议室图片    -->
                                <div class="panel-body clearfix pd0 pdud0 pointer"  @click="clickRoom(room.cid,$event)">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0">
                                        <img style="width: 100%;" :src="room.images.split(',')[0] ? '<?=base_url('upload/room/')?>' + room.images.split(',')[0] : '<?=base_url('static/images/img02.png')?>'" />
                                    </div>
                                </div>
                                <!--会议室地点    -->
                                <div class="panel-footer">
                                    <span style="font-weight: 300">{{  room.position }}</span>
                                    <span style="font-weight: 300">可容纳 : {{ room.capacity }}人</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- 第一步 选择 查询时间 -->
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        选择预约时间
                    </div>

                    <!-- /.panel-heading -->
                    <div class="panel-body clearfix editRoom">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <!-- 年月日 -->
                                <div class="contentRom clearfix">
                                    <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label content">
                                        预约日期 :
                                    </label>
                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                            <div class="form-group input-group" style="width: 90%">
                                                <input id="pickYear" type="text" class="form-control inputWholeLeft">
                                                <span class="input-group-addon shortInput inputWholeRight pointer" @click="inputFocus('#pickYear')">年-月-日</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- 时间 -->
                                <div class="contentRom clearfix">
                                    <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label content">
                                    会议时间 :
                                </label>
                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <div class="form-group input-group" style="width: 90%">
                                                <input id="pickBeginTime" type="text" class="form-control inputWholeLeft">
                                                <span class="input-group-addon shortInput inputWholeRight pointer" @click="inputFocus('#pickBeginTime')">时:分</span>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <div class="form-group input-group" style="width: 90%">
                                                <input id="pickEndTime" type="text" class="form-control inputWholeLeft">
                                                <span class="input-group-addon shortInput inputWholeRight pointer" @click="inputFocus('#pickEndTime')">时:分</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                    <button @click="searchForAvailableRoom" style="width: 25%" class="btn btn-success">查询</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    new_booking_VM = new Vue({
        el : "#newBooking",
        data : {
            useDate : '',
            useBeginTime : '00',
            useEndTime : '12',

            meetingName : '',
            department : '',
            applicant : '',
            mobile : '',
            participateNum : '',
            introduction : '',
            specialNeed : '',

            needs : [],

            showChoosingRoom : false,

            showWriteInfo : false,

            roomDetail : [],
            roomDetailObj : {},


            // 选中的会议室
            selectedId : '',

            blockAddButton : false,

        },
        methods : {
            // 查询可用会议室
            searchForAvailableRoom : function(){
                var self = this;

                if(self.selectedId != ''){
                    hint_message.show('选择了会议室的情况下无法查询，若您要修改时间请勿勾选会议室','danger');
                    return 0;
                }

                self.useDate = $("#pickYear").val();
                self.useBeginTime = $("#pickBeginTime").val();
                self.useEndTime = $("#pickEndTime").val();


                $.ajax({
                    url: "/?/api/room/query/available",
                    type: 'POST',
                    async: true,
                    data: {
                        useDate : self.useDate,
                        useBeginTime : self.useBeginTime,
                        useEndTime : self.useEndTime,
                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        if(result.code == 1){

                            if(result.data.room.length == 0){
                                hint_message.show('该时段没有可用的会议室');
                            }else{
                                self.roomDetail = result.data.room;
                                self.roomDetailObj = result.data.index;

                                hint_message.show('已经为您查询到可用的会议室,请选择一个','success');

                                setTimeout(function () {
                                    self.showChoosingRoom = true;
                                },500)
                            }

                        }else{
                            hint_message.show(result.msg,'alert');
                        }
                    }
                });
            },

            // 获取needList
//            getNeedList : function(cid){
//                var self = this;
//                $.ajax({
//                    url: "/?/api/room/get_need_list",
//                    type: 'POST',
//                    async: true,
//                    data: {
//                        cid : cid
//                    },
//                    dataType: 'json',
//                    success: function (result) {
//                        console.log(result);
//                        self.needList = result.data;
//                    }
//                });
//            },

            // 点击选择会议室
            clickRoom : function(cid,event){
                var self = this;
                self.selectedId = self.selectedId == cid ? '' : cid;
            },

            // 点击确认选择会议室
            confirmSelectRoom : function(){
                var self = this;
                if(self.selectedId == ''){
                    hint_message.show('请选择一个合适的会议室','danger');
                    return 0;
                }

//                self.getNeedList(self.selectedId);


                hint_message.show('会议室选择成功,请填写信息完成预约','success');
                self.showWriteInfo = true;
            },

            // 预约新的会议室
            bookNewRoom : function(){
                var self = this;

                if(self.blockAddButton) {
                    return 0;
                }

                if(self.selectedId == ''){
                    hint_message.show('请先选择一个会议室');
                    return 0;
                }
                if(self.applicant == ''){
                    hint_message.show('请填写申请人');
                    return 0;
                }
                if(self.department == ''){
                    hint_message.show('请填写申请部门');
                    return 0;
                }
                $.ajax({
                    url: "/?/api/booking/add/",
                    type: 'POST',
                    async: true,
                    data: {
                        cid : self.selectedId,
                        useDate : self.useDate,
                        department : self.department,
                        applicant : self.applicant,
                        useBeginTime : self.useBeginTime,
                        useEndTime : self.useEndTime,
                        number : self.participateNum,
                        introduction : self.introduction,
                        applicantMobile : self.mobile,
                        meetingName : self.meetingName,
                        need : self.needs.toString(),
                        specialNeed : self.specialNeed,
                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        if(result.code == 1){
                            hint_message.show('预约成功','success');

                            self.blockAddButton = true;

                            setTimeout(function(){
                                window.location.href = '/?/user/'
                            },1000)

                        }else{
                            hint_message.show(result.msg,'alert');
                        }
                    }
                });
            },

            inputFocus : function(selecter){
                $(selecter).focus();
            },

            getUserInfo : function(){
                var self = this;
                $.ajax({
                    url: "/?/api/user/info/",
                    type: 'POST',
                    async: true,
                    data: {},
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        if(result.code == 1){
                            self.applicant = result.data.user_name;
                            self.department = result.data.department;
                            self.mobile = result.data.mobile;

                        }else{
                            hint_message.show(result.msg,'alert');
                        }
                    }
                });
            },

            checkItem : function(item){
                alert(item)
            },
        },
        computed : {
            needList : function () {
                var self = this;
                var returnArr = [];
                self.needs = [];
                if(self.roomDetailObj[self.selectedId].needList != '') {
                    returnArr = JSON.parse(self.roomDetailObj[self.selectedId].needList);
                }
                return returnArr;
            }
        }
    })
    new_booking_VM.getUserInfo();
    $("#inputDay").focus();
    $('#pickYear').datetimepicker({
        format : 'YYYY-MM-DD',
//        defaultDate : moment(),
    });

    $('#pickBeginTime').datetimepicker({
        format : 'HH:mm',
    });

    $('#pickEndTime').datetimepicker({
        format : 'HH:mm',
    });





</script>

<?php $this->load->view('global/template_footer_meta')?>