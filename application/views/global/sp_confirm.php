<div id="sp_confirm">
    <!-- Modal -->
    <div style="position: fixed;top:20%" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">{{ title }}</h4>
                </div>
                <div class="modal-body">
                    {{ content }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" @click="callback">确定</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>


<script>
    sp_comfirm = new Vue({
        el : "#sp_confirm",
        data : {
            title : "",
            content : "",
        },
        methods : {
            callback : function(){},
            show : function (title,content,callback){
                var self = this;
                self.title = title;
                self.content = content;
                self.callback = function(){
                    callback();
                    $('#myModal').modal('hide');
                }
                $('#myModal').modal('show');
            }
        }
    })
</script>