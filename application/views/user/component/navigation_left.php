<div id="boardControl">
    <ul class="nav navbar-top-links navbar-right clearfix">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-messages">
                <li>
                    <div style="margin: 10px 20px;color: #00a4cf">没有新消息</div>
                </li>
            </ul>
            <!-- /.dropdown-messages -->
        </li>
        <!-- /.dropdown -->

        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-alerts" style="width: 10vw;text-align: center">
                <li>
                    <div @click="userInfo" class="pointer" style="margin: 10px 20px;color: #00a4cf;">个人资料</div>
                </li>

                <li v-if="info.admin">
                    <div @click="goToAdmin" class="pointer" style="margin: 10px 20px;color: #00a4cf;">管理员</div>
                </li>

                <li class="divider"></li>
                <li>
                    <div @click="logout" class="pointer" style="margin: 10px 20px;color: #00a4cf">退出</div>
                </li>
            </ul>
            <!-- /.dropdown-alerts -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li class="sidebar-search clearfix">
                    <div class="col-lg-12 pd0">
                        <img class="img-circle" style="width: 28%" src="http://demo.cssmoban.com/cssthemes3/yzts_34_adminlte1/img/avatar3.png">
                        <span style="display: none" v-show="info.regards" v-text="info.regards + ',' + info.user_name"></span>
                    </div>
                </li>
                <li>
                    <a href="/?/user/add_new_booking/" style="font-size: large"><i class="fa fa-phone fa-fw"></i>  添加预约</a>
                </li>
                <li>
                    <a href="#" style="font-size: large"><i class="fa fa-table fa-fw"></i> 我的预约<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="/?/user/" > 待审核预约</a>
                        </li>
                        <li>
                            <a href="/?/user/booking_history" > 历史预约</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" style="font-size: large"><i class="fa fa-bar-chart-o fa-fw"></i> 我的会议<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="/?/user/meeting/" > 将来的会议</a>
                        </li>
                        <li>
                            <a href="/?/user/history_meeting" > 历史会议</a>
                        </li>
                        <li>
                            <a href="/?/user/room_detail" > 会议室详情</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
</div>

<script>
    boardControl_VM = new Vue({
        el : "#boardControl",
        data : {
            itemList : ['我的预约','添加预约','会议室详情'],
            currentItem : '我的预约',
            info : {}

        },
        methods : {
            changeItem : function(item){
                var self = this;
                self.currentItem = item;
            },
            logout : function() {
                $.ajax({
                    url: "/?/api/user/logout/",
                    type: 'POST',
                    async: true,
                    dataType: 'json',
                    success: function (result) {
                        if (result.code == 1) {
                            window.location.href = "/?/user/";
                        }
                    }
                });
            },
            getRegards : function(){
                var self = this;
                $.ajax({
                    url: "/?/api/user/info",
                    type: 'POST',
                    async: true,
                    data:{},
                    dataType: 'json',
                    success: function(result) {
                        self.info = result.data;
                    }
                });
            },
            userInfo : function(){
                window.location.href = "/?/user/info/";
            },
            goToAdmin : function(){
                window.location.href = "/?/admin/";
            },
        },
    });
    boardControl_VM.getRegards();
</script>
