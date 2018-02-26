<ul class="nav navbar-top-links navbar-right clearfix">
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-messages">
            <li>
                <div style="margin: 10px 20px;color: #00a4cf">您还有6条预约没有处理 <a style="color: steelblue;background-color: white">点击查看</a></div>
            </li>
        </ul>
        <!-- /.dropdown-messages -->
    </li>
    <!-- /.dropdown -->

    <!-- /.dropdown -->
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-alerts">
            <li>
                <div style="margin: 10px 20px;color: #00a4cf">没有新消息</div>

            </li>
        </ul>
        <!-- /.dropdown-alerts -->
    </li>
    <!-- /.dropdown -->

    <!-- /.dropdown -->
</ul>
<div id="boardControl" class="navbar-default sidebar" role="navigation">

    <div class="sidebar-nav navbar-collapse">

        <ul class="nav" id="side-menu" >
            <li class="sidebar-search clearfix">
                <div class="col-lg-12 pd0">
                    <img class="img-circle" style="width: 28%" src="http://demo.cssmoban.com/cssthemes3/yzts_34_adminlte1/img/avatar3.png">
                    <span v-text="info.regards + ',' + info.user_name"></span>
                </div>
            </li>

            <li><a href="/?/admin/" style="font-size: large" >
                    <i class="fa fa-table fa-fw"></i> 预约管理</a>
            </li>
            <li><a href="/?/admin/booking_history" style="font-size: large" >
                    <i class="fa fa-table fa-fw"></i> 预约历史</a>
            </li>
            <li><a href="/?/admin/meeting" style="font-size: large" >
                    <i class="fa fa-table fa-fw"></i> 会议</a>
            </li>
            <li><a href="/?/admin/meeting_history" style="font-size: large" >
                    <i class="fa fa-table fa-fw"></i> 会议历史</a>
            </li>
            <li><a href="/?/admin/room/" style="font-size: large" >
                    <i class="fa fa-book fa-fw"></i> 会议室</a>
            </li>
            <li style="font-size: large"><a href="/?/admin/administrator/" style="font-size: large" >
                    <i class="fa fa-eye fa-fw"></i> 管理员</a>
            </li>
            <li style="font-size: large"><a href="/?/admin/setting/" style="font-size: large" >
                    <i class="fa fa-cog fa-fw"></i> 设置</a>
            </li>
<!--            <li style="font-size: large"><a href="/?/admin/data_backup/" style="font-size: large" >-->
<!--                    <i class="fa fa-sitemap fa-fw"></i> 数据备份</a>-->
<!--            </li>-->
            <li style="font-size: large">
                <a href="javascript:(0)" @click="logout" style="font-size: large">
                    <i class="fa fa-share-square-o fa-fw"></i> 退出系统
                </a>
            </li>

        </ul>

    </div>
    <!-- /.sidebar-collapse -->
</div>
<script>

    board_control_VM = new Vue({
        el : "#boardControl",
        data : {
            menuItem : ['预约管理','会议室','管理员','数据备份'],

            currentItem : '预约管理',

            info : {},
        },
        methods : {
            currentItem : '预约管理',

            urlDest : function(){
                var self = this;
                var dest = '<?=$dest?>';
                console.log(dest)
                switch (dest){
                    case '1' : self.currentItem = '会议室';
                        break;
                    case '2' : self.currentItem ='管理员';
                        break;
                    case '3' : self.currentItem = '数据备份';
                        break;
                    default :

                }
            },

            clickItemAction : function(item,event){
                var self = board_control_VM;
                self.currentItem = item;
            },

            logout : function(){
                var self = this;
                $.ajax({
                    url: "/?/api/user/admin/logout",
                    type: 'POST',
                    async: true,
                    data:{},
                    dataType: 'json',
                    success: function(result) {
                        window.location.href = "/?/admin/";
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
            }
        }
    })

    board_control_VM.urlDest();
    board_control_VM.getRegards();

</script>
