<?php $this->load->view('admin/component/common/header')?>
<style>
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
        text-align: center;
        vertical-align: middle;
    }
</style>
<div id="page-wrapper">

    <div id="adminAdministrator" class="row" >

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="color: #007c8e">用户列表</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    用户列表
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div>
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example1">
                            <thead>
                            <tr>
                                <th>用户序号</th>
                                <th>用户名</th>
                                <th>账户类型</th>
                                <th>手机号码</th>
                                <th>部门</th>
                                <th>注册时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user in userList">
                                <td>{{ user.uid }}</td>
                                <td>{{ user.user_name }}</td>
                                <td>{{ user.type == 1 ? '超级管理员' : ( user.type == 2 ? '普通用户' : '管理员') }}</td>
                                <td>{{ user.mobile }}</td>
                                <td>{{ user.department }}</td>
                                <td>{{ user.reg_time }}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger btn-outline">注销用户</button>
                                    <button class="btn btn-sm btn-danger btn-outline">设为管理员</button>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>

    </div>
</div>

<script>
    admin_administrator_VM = new Vue({
        el: "#adminAdministrator",
        data: {
            adminList : [],
            userList : [],
        },
        methods : {
            getAdminList : function(){
                var self = this;
                $.ajax({
                    url: "/?/api/user/admin/list",
                    type: 'POST',
                    async: true,
                    data : {},
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        if(result.code == 1){
                            self.adminList = result.data.admin;
                        }else{
                            hint_message.show(result.msg);
                        }

                    }
                });
            },

            getUserList : function(){
                var self = this;
                $.ajax({
                    url: "/?/api/user/all_list",
                    type: 'POST',
                    async: true,
                    data : {

                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        if(result.code == 1){
                            self.userList = result.data.user;

                            // 渲染列表
                            $(document).ready(function() {
                                $('#dataTables-example1').DataTable({
                                    responsive: true
                                });
                            });
                        }else{
                            hint_message.show(result.msg);
                        }

                    }
                });
            }
        },

        computed: {
            visible : function () {
                return board_control_VM.currentItem == '管理员';
            }
        },
        watch : {
            visible : function(){
                var self = this;
                if(self.visible){
                    admin_administrator_VM.getAdminList();
                    admin_administrator_VM.getUserList();
                }
            }
        }
    })

    admin_administrator_VM.getAdminList();
    admin_administrator_VM.getUserList();



</script>
<?php $this->load->view('global/template_footer_meta')?>
