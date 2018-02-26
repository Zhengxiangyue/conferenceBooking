<?php $this->load->view('admin/component/common/header')?>

<style>
    .inputNeed{
        background-color:
                rgba(0, 0, 0, 0)
    ;
        background-image:
                none
    ;
        border-bottom-color:
                rgb(46, 109, 164)
    ;
        border-bottom-left-radius:
                4px
    ;
        border-bottom-right-radius:
                4px
    ;
        border-bottom-style:
                solid
    ;
        border-bottom-width:
                1px
    ;
        border-image-outset:
                0px
    ;
        border-image-repeat:
                stretch
    ;
        border-image-slice:
                100%
    ;
        border-image-source:
                none
    ;
        border-image-width:
                1
    ;
        border-left-color:
                rgb(46, 109, 164)
    ;
        border-left-style:
                solid
    ;
        border-left-width:
                1px
    ;
        border-right-color:
                rgb(46, 109, 164)
    ;
        border-right-style:
                solid
    ;
        border-right-width:
                1px
    ;
        border-top-color:
                rgb(46, 109, 164)
    ;
        border-top-left-radius:
                4px
    ;
        border-top-right-radius:
                4px
    ;
        border-top-style:
                solid
    ;
        border-top-width:
                1px
    ;
        box-sizing:
                border-box
    ;
        color:
                rgb(66, 139, 202)
    ;
        cursor:
                pointer
    ;
        display:
                inline-block
    ;
        font-family:
                "Helvetica Neue", Helvetica, Arial, sans-serif
    ;
        font-size:
                14px
    ;
        font-stretch:
                normal
    ;
        font-style:
                normal
    ;
        font-variant-caps:
                normal
    ;
        font-variant-ligatures:
                normal
    ;
        font-variant-numeric:
                normal
    ;
        font-weight:
                normal
    ;
        height:
                34px
    ;
        letter-spacing:
                normal
    ;
        line-height:
                20px
    ;
        margin-bottom:
                10px
    ;
        margin-left:
                0px
    ;
        margin-right:
                20px
    ;
        margin-top:
                0px
    ;
        padding-bottom:
                6px
    ;
        padding-left:
                12px
    ;
        padding-right:
                12px
    ;
        padding-top:
                6px
    ;
        text-align:
                center
    ;
        text-indent:
                0px
    ;
        text-rendering:
                auto
    ;
        text-shadow:
                none
    ;
        text-size-adjust:
                100%
    ;
        text-transform:
                none
    ;
        touch-action:
                manipulation
    ;
        transition-delay:
                0s
    ;
        transition-duration:
                0.5s
    ;
        transition-property:
                all
    ;
        transition-timing-function:
                ease
    ;
        user-select:
                none
    ;
        vertical-align:
                middle
    ;
        white-space:
                nowrap
    ;
        width:
                45.7969px
    ;
        word-spacing:
                0px
    ;
        writing-mode:
                horizontal-tb
    ;
        -webkit-appearance:
                none
    ;
        -webkit-rtl-ordering:
                logical
    ;
        -webkit-tap-highlight-color:
                rgba(0, 0, 0, 0)
    ;
        -webkit-border-image:
                none
    ;
    }
</style>

<div id="page-wrapper">

    <div id="admin-setting">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="color: #007c8e">系统设置</h1>
            </div>
            <!-- /.col-lg-12 -->

            <div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="panel-body clearfix">
                            <div class="form-horizontal">
                                <div class="form-group" style="margin-bottom: 10px">
                                    <label class="col-sm-2 control-label">
                                        会议室设施 :
                                    </label>
                                    <label class="col-sm-6 control-label-2 pd0">
                                        <span @click="tryDeleteNeed(need)" class="delete-father btn btn-primary btn-outline" v-for="need in allNeedList"  data-toggle="tooltip" data-placement="top" title="点击删除该项设施" style="margin-right: 20px;margin-bottom: 10px">
                                            {{need}}
<!--                                            <span class="delete-button glyphicon glyphicon-remove"></span>-->
                                        </span>
                                        <span @click="clickAddButton" v-show="addButtonVisible" class="delete-father btn btn-primary btn-outline" style="margin-right: 20px;margin-bottom: 10px"><i class="fa fa-plus"></i></span>
                                        <span class="delete-father" v-show="!addButtonVisible" style="margin-right: 20px;margin-bottom: 10px">
                                            <input @keyup.13="addNeed" v-model="inputNewNeed" style="width: 20%;margin-right: 20px;margin-bottom: 10px;display: inline-block" class="inputNeed">
                                        </span>

                                    </label>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                    </label>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->

<script>
    admin_setting_VM = new Vue({
        el : "#admin-setting",
        data : {
            allNeedList : [],
            inputNewNeed : "",
            addButtonVisible : true,
        },
        methods : {
            // 获取setting中的会议室设施
            getAllNeedList : function () {
                var self = this;
                $.ajax({
                    url: "/?/api/room/get_need_list",
                    type: 'POST',
                    async: true,
                    data: {},
                    dataType: 'json',
                    success: function (result) {
                        self.allNeedList = result.data;
                    }
                });
            },

            // 添加一项会议室设施
            addNeed : function(){
                var self = this;

                if(self.inputNewNeed == ""){
                    hint_message.show('请输入要添加的设施');
                    return 0;
                }

                $.ajax({
                    url: "/?/api/room/add_need",
                    type: 'POST',
                    async: true,
                    data: {
                        need : self.inputNewNeed,
                    },
                    dataType: 'json',
                    success: function (result) {
                        if(result.code == 1){
                            self.allNeedList = result.data;
                            self.inputNewNeed = "";
                            self.addButtonVisible = true;
                            $('[data-toggle=tooltip]').tooltip()

                            hint_message.show('新的设施添加成功','success');

                        }else{
                            hint_message.show(result.msg);
                        }
                    }
                });
            },

            // 点击添加设置按钮
            clickAddButton : function () {
                var self = this;
                self.addButtonVisible = false;
            },

            tryDeleteNeed : function(need){
                var self = this;
                sp_comfirm.show('确认','您确定要删除"'+need+'"这项设施吗?',function(){self.deleteNeed(need)});
            },

            deleteNeed : function(need){
                var self = this;
                $.ajax({
                    url: "/?/api/room/delete_need",
                    type: 'POST',
                    async: true,
                    data: {
                        need : need
                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result.data);
                        self.allNeedList = result.data;
                        console.log(self.allNeedList);
                        hint_message.show('成功删除了');
                    }
                });
            }
        }
    });

    admin_setting_VM.getAllNeedList();
</script>

<?php $this->load->view('global/template_footer_meta')?>
