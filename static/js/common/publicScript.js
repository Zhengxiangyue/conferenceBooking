$(function(){
    //设置登录页面
	pulblic();
	function pulblic(){
		
		var login = $(".login");
		setWindow(login);
		
		//设置上下居中
		var longinCon = $(".login-content");
		var longinConH = setCenter(longinCon);
		longinCon.css({"top":longinConH})
		
		var header = $(".header");
		var disH = setDifference(header);
	    $(".container-left").height(disH);  //设置导航栏的高度
	    $(".container-line").height(disH);  //设置竖线的高度
	    
	    //标签切换的调用
	    // var containerLeft = $(".container-left");
	    // var containerRight = $(".container-right");
	    // setTab(containerLeft,containerRight);
	    
	    //标签切换的调用
	    // var assemblyLeft = $(".assembly-container-left");
	    // var assemblyRight = $(".assembly");
	    // setTab(assemblyLeft,assemblyRight);
	    
	    //通过审核的删除操作
	    setBackRemove($(".back-remove"));
	    	   	    
	    //管理员操作的删除
		$(".admin-operateOne span:last-child").click(function(){
			$(this).parents(".tableListTwo-group").remove();
		});
		//数据备份的全选
		$(".all-check").click(function(){
			$(".dataTab-group").find("input[name='checking']").attr("checked",true);
		});
		
		
	}
	
	function setBackRemove(obj){		
	    obj.on("click",function(){
	    	$(this).parent().parent().remove();	    
	    })
	}
	
	//计算差值的函数
	function setDifference(value){
		var windowH = $(window).height();
		var valueH = value.outerHeight(true);
		var subValueH = Math.floor(windowH - valueH);
		return subValueH;
	}
	
	
	//设置标签切换的函数	
	function setTab(eleOne,eleTwo){
		//$(".container-right>div:not(:first-child)").hide();
		eleTwo.children("div:not(:first-child)").hide();
		eleOne.find("li").click(function () {
			$(this).addClass("active").siblings().removeClass("active");
			eleTwo.children("div").hide().eq($(this).index()).show();
			//alert(eleTwo.outerHeight(true));
		})
	}
	
	//设置上下居中的函数
	function setCenter(obj){
		var windowH = $(window).height();
		var objH = obj.outerHeight(true);
		var surplus = Math.floor((windowH-objH)/2);
		return surplus;
	}
	
	//设置高度
	function setWindow(eleObj){
		var windowH = $(window).height();
		eleObj.height(windowH);
	}
})
