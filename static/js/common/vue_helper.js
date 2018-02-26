
Vue.directive('slide-show', {
    inserted: function (el,binding,vnode,oldVnode) {
        el.style.display = binding.value ? 'block' : 'none';
    },
    update: function(el,binding,vnode,oldVnode){
        if(binding.value)
            $(el).slideDown(300);
        else
            $(el).slideUp(300);
    },
    componentUpdated : function(){
        console.log('com updated');
    }
})