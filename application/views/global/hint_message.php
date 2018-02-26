<style>
    #spHintMessage {
        position: fixed;
        margin: 1%;
        z-index: 999999999;
        left: 0;
        right: 0;
        top: 0;
        -webkit-box-shadow: #999  5px 5px 8px;
        -moz-box-shadow: #999  5px 5px 8px;
        box-shadow: #999  5px 5px 8px;
        border-top-right-radius: 5px;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;

        /*clear: both;display: block*/
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-active {
        opacity: 0
    }
</style>
    <div id="spHintMessage" class="alert alert-danger" v-fade="visible" style="display: none">
        <button type="button" class="close" @click="closeHint">×</button>
        <div id="spHintMessageContent" style="display: inline-block">{{ content }}</div>
    </div>


<script>

    Vue.directive('fade', {
        inserted: function (el,binding,vnode,oldVnode) {
            el.style.display = binding.value ? 'block' : 'none';
        },
        update: function(el,binding,vnode,oldVnode){
            if(binding.value)
                $(el).fadeIn(300);
            else
                $(el).fadeOut(300);
        },
        componentUpdated : function(){
            console.log('com updated');
        }
    })

    hint_message = new Vue({
        el : "#spHintMessage",
        data : {
            visible : false,
            height : '',
            content : '',
            timeOutId : '',
        },
        methods : {
            closeHint : function(){
                var self = this;
                self.visible = false;
            },
            show : function (content,type = 'danger',last = 3000){
                var self = this;
                clearTimeout(self.timeOutId);
                self.content = content;
                switch (type){
                    case 'success' : $("#spHintMessage").attr("class","alert alert-success");
                    break;
                    case  'warning' : $("#spHintMessage").attr("class","alert alert-warning");
                    break;
                    case  'danger' : $("#spHintMessage").attr("class","alert alert-danger");
                    default : $("#spHintMessage").attr("class","alert alert-danger");;
                }
                self.visible = true;
                self.timeOutId = setTimeout(function(){
                    self.visible = false;
                },last)
            }
        }
    })
</script>


