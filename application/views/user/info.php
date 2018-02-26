<?php $this->load->view('user/component/header')?>
<div id="page-wrapper">
    <div id="userInfo">
        <div class="panel panel-default" v-show="historyList.length > 0" style="display: none">
            <div class="panel-heading">
                基本资料
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body clearfix">

            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>


<script>
    userInfo_VM = new Vue({
        el : "#userInfo",
        computed : {
            info : function(){
                return boardControl_VM.info;
            }
        }
    })
</script>

<?php $this->load->view('global/template_footer_meta')?>
