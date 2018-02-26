<div id="adminDataBackup" class="row" v-if="visible" v-show="visible" style="display: none">
    <div class="col-lg-12">
        <h1 class="page-header" style="color: #007c8e">数据备份</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<script>
    admin_data_back_VM = new Vue({
        el: "#adminDataBackup",
        data: {},
        computed: {
            visible : function () {
                return board_control_VM.currentItem == '数据备份';
            }
        }
    })
</script>
