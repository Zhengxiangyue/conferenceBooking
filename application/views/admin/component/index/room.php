

<div id="adminRoom" class="row" v-show="true" style="display: none">
    <div class="col-lg-12">
        <h1 class="page-header" style="color: #007c8e">会议室<span v-show="showRoomDetail"> / 详情</span></h1>
    </div>

    <!--  当前会议室总数  -->
    <div v-show="showRoomImgList" class="col-lg-6 col-md-6 col-sm-6  text-left editHeadButton">
        <span style="font-size: large">当前会议室总数 : {{ roomDetail.length }}</span>
        <!--        <button @click="hideOrShowRooms" class="btn btn-primary">{{ hideOrShow }}</button>-->
    </div>



    <div v-show="showRoomImgList">
        <!--  新增或取消新增按钮  -->
        <div  class="col-lg-6 col-md-6 col-sm-6 text-right editHeadButton">
            <button @click="addNewRoom" class="btn btn-primary">{{ newRoomButtonContent }}</button>
            <!--        <button @click="hideOrShowRooms" class="btn btn-primary">{{ hideOrShow }}</button>-->
        </div>

        <!-- 新增会议室-->
        <div v-slide-show="showAddRoom" class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!-- 最新预约 -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    新增会议室
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body clearfix editRoom">
                    <!--上传图片-->
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pd0 clearfix">
                        <div class="text-center col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                            <img id="roomImg" class="img-rounded img-thumbnail" style="width: 76%" :src=" editEara.images == undefined ? '<?=base_url()?>static/images/default-img.png' : '<?=base_url()?>upload/room/300x400/' + editEara.images.split(',')[0]"/>
                        </div>
                        <div class="text-center col-lg-12 col-md-12 col-sm-12 col-xs-12 pd0 clearfix">
                            <button @click="clickUploadImage" class="btn btn-primary uploadButton">上传图片</button>
                        </div>

                        <div style="display: none">
                            <input onchange="uploadRoomImage()" id="fileupload" class="fileupload" type="file" name="conference_room_image[]" multiple>
                        </div>


                    </div>
                    <div class="editRoomForm col-lg-8 col-md-8 col-sm-8 col-xs-8 clearfix">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    会议室 :
                                </label>
                                <div class="col-sm-6">
                                    <input v-model="editEara.name" type="text" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    会议室地点 :
                                </label>
                                <div class="col-sm-6">
                                    <input v-model="editEara.position" type="text" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    可容纳人数 :
                                </label>
                                <div class="col-sm-6">
                                    <input v-model="editEara.capacity" type="text" class="form-control shortInput"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    是否开放 :
                                </label>
                                <div class="col-sm-6">
                                    <label class="radio-inline">
                                        <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline1" value="1" checked>是
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline2" value="0">否
                                    </label>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    开放时段 :
                                </label>
                                <div class="col-sm-6">
                                    <div class="col-sm-6">
                                        <input id="newRoomBegin" type="text" class="form-control">
                                    </div>

                                    <div class="col-sm-6">
                                        <input id="newRoomEnd" type="text" class="form-control">
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    负责人 :
                                </label>
                                <div class="col-sm-3">
                                    <input v-model="editEara.personInCharge" class="form-control"/>
                                </div>

                                <label class="col-sm-2 control-label">
                                    手机 :
                                </label>
                                <div class="col-sm-3">
                                    <input v-model="editEara.mobile" class="form-control"/>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    备注 :
                                </label>
                                <div class="col-sm-6">
                                    <textarea v-model="editEara.remark" style="min-width: 100%;max-width: 100%" class="form-control shortInput"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 text-right">
                                <img id="loadingIcon" style="width: 3%;display: none" src="<?=base_url()?>static/images/loading.gif">
                                <button @click="clickSaveRoom" class="btn btn-success actionButton">保存会议室</button>
                                <!--                            <button class="btn btn-disabled actionButton">删除会议室</button>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <!--  会议室图片列表  -->
    <div v-show="showRoomImgList">

        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" v-for="(room,index) in roomDetail">
            <div class="panel panel-default pointer hoverRoom">
                <div class="panel-heading clearfix">
                    <div class="col-lg-8">{{ room.name }}</div>
                    <div class="col-lg-4 text-right">
                        <div class="deleteButton preventChoose" @click="tryDeleteRoom(room.cid,room.name)">删除</div>
                    </div>
                </div>
                <!--会议室图片    -->
                <div class="panel-body clearfix"  @click="clickRoom(room.cid)">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center">
                        <img style="width: 100%" :src="roomDetail[index].images.split(',')[0] ? '<?=base_url('upload/room/')?>' + roomDetail[index].images.split(',')[0] : '<?=base_url('static/images/img02.png')?>'" />
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

                        <div v-if=" detailEara.images !== undefined && detailEara.images != '' ">
                            <img class="img-rounded img-thumbnail" v-for="imageUrl in detailEara.images.split(',')" :src="'<?=base_url()?>upload/room/' + imageUrl" />
                        </div>
                        <div v-else>
                            <img id="roomImg" class="img-rounded img-thumbnail" style="width: 76%" src="<?=base_url()?>static/images/default-img.png"/>
                        </div>
                    </div>

                </div>
                <div class="editRoomForm col-lg-8 col-md-8 col-sm-8 col-xs-8 clearfix">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                会议室 :
                            </label>
                            <label v-if="!editing" class="col-sm-6 control-label-2">
                                {{ detailEara.name }}
                            </label>
                            <input style="width: 50%" v-else v-model="inputEara.name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                会议室地点 :
                            </label>
                            <label v-if="!editing" class="col-sm-6 control-label-2">
                                {{ detailEara.position }}
                            </label>
                            <input style="width: 50%" v-else v-model="inputEara.position" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                可容纳人数 :
                            </label>
                            <label v-if="!editing" class="col-sm-6 control-label-2">
                                {{ detailEara.capacity }}
                            </label>
                            <input style="width: 50%" v-else v-model="inputEara.capacity" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                是否开放 :
                            </label>
                            <label v-if="!editing" class="col-sm-6 control-label-2">
                                {{ detailEara.open ? '是' : '否' }}
                            </label>
                            <div v-else class="col-sm-6">
                                <label class="radio-inline">
                                    <input type="radio" value="1" checked>是
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" value="0">否
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                开放时段 :
                            </label>
                            <label v-if="!editing" class="col-sm-6 control-label-2">
                                {{ detailEara.openBeginTime }} - {{ detailEara.openEndTime }}
                            </label>
                            <div v-show="editing" class="col-sm-6 pd0">
                                <div class="col-sm-3">
                                    <input id="editRoomBegin" type="text" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <input id="editRoomEnd" type="text" class="form-control">
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                负责人 :
                            </label>
                            <label v-if="!editing" class="col-sm-6 control-label-2">
                                {{ detailEara.personInCharge }}
                            </label>
                            <input style="width: 50%" v-else v-model="inputEara.personInCharge" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                会议室设施 :
                            </label>
                            <p v-if="!editing" class="col-sm-6 control-label-2">
                                {{ detailEara.needList }}
                            </p>
                            <div v-else class="col-sm-6 pd0 checkbox">
                                <label v-for="item in needList" style="margin-left: 10px">
                                    <input @click="checkItem" v-model="inputNeeds" :value="item" type="checkbox" /><span v-text="item"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                备注 :
                            </label>
                            <p v-if="!editing" class="col-sm-6 control-label-2">
                                {{ detailEara.remark }}
                            </p>
                            <input style="width: 50%" v-else v-model="inputEara.remark" class="form-control">
                        </div>
                        <div class="col-sm-12 text-right">
                            <img id="loadingIcon" style="width: 3%;display: none" src="<?=base_url()?>static/images/loading.gif">
                            <button v-show="!editing" @click="clickEditRoom" class="btn btn-success actionButton">编辑会议室</button>
                            <button v-show="editing" @click="saveEdit" class="btn btn-success actionButton">保存</button>
                            <button v-show="editing" @click="clickEditRoom" class="btn btn-default actionButton">取消</button>
                            <button @click="backToRoomList" class="btn btn-warning actionButton">返回</button>
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

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div id="calendar"></div>
            </div>

            <!-- /.panel-heading -->
            <div class="panel-body clearfix editRoom">
                <table class="table table-bordered">
                    <tbody class="tooltip-demo">
                    <tr v-for="n in bookingTable">
                        <td data-toggle="tooltip" data-placement="top" :title="exampleTooltip" style="vertical-align: middle;text-align: center" v-for="m in n" v-html="m.html" :class="m.type == 0 ? 'info':(m.type == 3 ? 'success' : (m.type == 2 ? 'warning' : 'danger' ))"></td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- /.row -->

    <!-- /.row -->

    <!-- /.col-lg-12 -->
</div>

<script type="text/javascript" src="<?=base_url()?>static/js/common/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/js/common/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/js/common/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?=base_url('static/template')?>/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src='<?=base_url()?>static/js/calendar/fullcalendar.min.js'></script>
<script>
    function clone(obj)
    {
        var o,i,j,k;
        if(typeof(obj)!="object" || obj===null)return obj;
        if(obj instanceof(Array))
        {
            o=[];
            i=0;j=obj.length;
            for(;i<j;i++)
            {
                if(typeof(obj[i])=="object" && obj[i]!=null)
                {
                    o[i]=arguments.callee(obj[i]);
                }
                else
                {
                    o[i]=obj[i];
                }
            }
        }
        else
        {
            o={};
            for(i in obj)
            {
                if(typeof(obj[i])=="object" && obj[i]!=null)
                {
                    o[i]=arguments.callee(obj[i]);
                }
                else
                {
                    o[i]=obj[i];
                }
            }
        }

        return o;
    }
    function uploadRoomImage(){
        $.ajaxFileUpload(
            {
                url: '/?/api/room/upload_conference_room_image',
                secureuri: false,
                fileElementId: 'fileupload',
                dataType: 'json',
                success: function (data, status)
                {
                    if(data.code == 1){
                        // 上传成功后 显示图片
                        document.getElementById('roomImg').src = data.data.url[0];
                        // 显示提示信息
                        hint_message.show(data.msg,'success');
                        console.log( data.data.url[0]);

                        admin_room_VM.editEara['images'] = data.data.image.join(',');
                        console.log(admin_room_VM.editEara.images);
                    }else{
                        hint_message.show(data.msg,'alert');
                    }

                },
                error: function (data, status, e)
                {
                    hint_message.show(data.msg,'alert');
                },
                complete : function(){
                    console.log('complete');
                    $('#fileupload').replaceWith('<input onchange="uploadRoomImage()" id="fileupload" class="fileupload" type="file" name="conference_room_image[]" multiple>');
                }
            }
        )
    }
    // page is now ready, initialize the calendar...

    admin_room_VM = new Vue({
        el: "#adminRoom",
        data: {
            roomDetail : [],
            roomDetailObj : {},
            showRoomImgList : true,
            showAddRoom : false,
            showRoomDetail : false,


            // 编辑区的内容
            editEara : {},

            // 详情区域的内容
            detailEara : {},

            // 详情input的内容
            inputEara : {},

            // 正在编辑会议室
            editing : false,

            // 设施列表
            needList : {},

            // 选中的设施列表
            inputNeeds : [],

            // 预约表
            bookingTable : [],

            calendarData : [],

            exampleTooltip : "<p>(示例数据)可用时段 : 18:00 ~ 24:00 </p>"
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
                        console.log(result);
                        if(result.code == 1){
                            self.roomDetail = result.data.room;
                            self.roomDetailObj = result.data.index;

                            setTimeout(function(){
                                $('.tooltip-demo').tooltip({
                                    selector: "[data-toggle=tooltip]",
                                    container: "body",
                                    html : true,
                                })
                            },500);
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

            // 保存修改的会议室信息
            saveEdit : function(){
                var self = this;

                self.inputEara.openBeginTime = $("#editRoomBegin").val();
                self.inputEara.openEndTime = $("#editRoomEnd").val();

                $.ajax({
                    url: "/?/api/room/update/",
                    type: 'POST',
                    async: true,
                    dataType: 'json',
                    data : {
                        cid : self.inputEara.cid,
                        name : self.inputEara.name,
                        position : self.inputEara.position,
                        open : self.inputEara.open,
                        openBeginTime : self.inputEara.openBeginTime,
                        capacity : self.inputEara.capacity,
                        openEndTime :  self.inputEara.openEndTime,
                        personInCharge : self.inputEara.personInCharge,
                        mobile : self.inputEara.mobile,
                        remark : self.inputEara.remark,
                        images : self.inputEara.images,
                        needList : self.inputNeeds ? JSON.stringify(self.inputNeeds) : "",
                    },
                    success: function (result) {
                        if(result.code == 1)
                        {
                            self.getRoomDetail();

                            hint_message.show('会议室内容更新成功','success');

                            setTimeout(function(){
                                self.detailEara = clone(self.roomDetailObj[self.detailEara.cid]);
                                self.inputEara = clone(self.detailEara);

                                self.editing = false;

                            },500);

                        }

                    }
                });
            },


            checkItem : function(){
                console.log(this.inputNeeds);
            },

            // 点击了会议室
            clickRoom : function (cid){
                var self = this;

                self.detailEara = clone(self.roomDetailObj[cid]);
                self.inputEara = clone(self.detailEara);
                console.log(self.detailEara.needList == "");

                self.inputNeeds = self.detailEara.needList == "" ? [] : self.detailEara.needList.split(',') ;

                // 获取到的每个needlist是一个数组
                console.log(self.inputNeeds);

                $("#editRoomBegin").val(self.inputEara.openBeginTime);
                $("#editRoomEnd").val(self.inputEara.openEndTime);

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
                        openBeginTime : $("#newRoomBegin").val(),
                        capacity : self.editEara.capacity,
                        openEndTime : $("#newRoomEnd").val(),
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

            // 提醒是否要删除会议室
            tryDeleteRoom : function(cid,name){
                var self = this;
                sp_comfirm.show('确认信息',"您确定要删除\"" + name +"\"这个会议室吗?",function(){self.deleteRoomAction(cid)});
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
//                hint_message.show('您的权限不够，无法编辑会议室','danger')
                var self = this;
                self.inputEara = clone(self.detailEara);
                self.inputNeeds = self.detailEara.needList == "" ? [] : self.detailEara.needList.split(',')
                self.editing = !self.editing;
            },

            // 返回列表
            backToRoomList : function(){
                var self = this;
                self.editing = false;
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

            },

            // 获取会议室设施列表
            getNeedList : function () {
                var self = this;
                $.ajax({
                    url: "/?/api/room/get_need_list",
                    type: 'POST',
                    async: true,
                    data: {},
                    dataType: 'json',
                    success: function (result) {
                        self.needList = result.data;
                    }
                });
            },

            // 获取calendar时间表
            getCalendarData : function(start,end,cid) {
                var self = this;
                $.ajax({
                    url: "/?/api/booking/get_meetings_for_calendar/",
                    type: 'POST',
                    async: true,
                    data: {
                        start : start,
                        end : end,
                        cid : cid,
                    },
                    dataType: 'json',
                    success: function (result) {
                        for(key in result.data)
                        {
                            var event = {
                                title : result.data[key].meetingName,
                                start : result.data[key].meetStartTime,
                                end : result.data[key].meetEndTime,
                            }

                            self.calendarData.push(clone(event));
                        }

                        $('#calendar').fullCalendar({
                            header: {
                                left: 'prev,next,today',
                                center: 'title',
                                right: 'month,agendaWeek,agendaDay'
                            },
                            buttonText:{
                                today:'Jump to current day'
                            },
                            monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                            monthNamesShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                            dayNames: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
                            dayNamesShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
                            today: ["今天"],
                            firstDay: 1,
                            buttonText: {
                                today: '本月',
                                month: '月',
                                week: '周',
                                day: '日',
                                prev: '往前',
                                next: '往后'
                            },
                            events: self.calendarData,
                        })
                    }
                });

            }

        },
        computed: {
            visible : function () {
                return board_control_VM.currentItem == '会议室';
            },
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
    admin_room_VM.getNeedList();

    admin_room_VM.getCalendarData('2017-02-01','2017-03-20');


    $('#newRoomBegin').datetimepicker({
        format : 'HH:mm',
    });

    $('#newRoomEnd').datetimepicker({
        format : 'HH:mm',
    });

    $('#editRoomBegin').datetimepicker({
        format : 'HH:mm',
    });

    $('#editRoomEnd').datetimepicker({
        format : 'HH:mm',
    });





</script>
