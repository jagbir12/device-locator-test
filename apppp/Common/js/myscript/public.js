$(function(){
	//目录树
	$(".list_c i").click(function(){
		var list_c = $(this).parent();
		var name=list_c.attr("name");
		if (list_c.hasClass('show_list')) {
    		list_c.removeClass("show_list");
    		//list_c.next(".list_p").hide();
    		$(".list_p[name="+name+"]").next(".item_list_s").hide();
    		$(".list_p[name="+name+"]").removeClass("show_list");
    		$(".list_p[name="+name+"]").hide();
    	}else{
    		list_c.addClass("show_list");
            //list_c.next(".list_p").show();
            $(".list_p[name="+name+"]").show();
    	}
	})
	$(".list_p i").click(function(){
		var list_p = $(this).parent();
		if (list_p.hasClass('show_list')) {
    		list_p.removeClass("show_list");
    		list_p.next(".item_list_s").hide();
    	}else{
    		list_p.addClass("show_list");
            list_p.next(".item_list_s").show();
    	}
	})

	var aobj=$('.list_s a');
	aobj.each(function(){
		$(this).click(function(){
			aobj.removeClass("on")
			$(this).addClass("on");
			return false;
		});
	});

	$(".list_c").mouseover(function () {
        $(this).find(".list_delete").css("display","inline-block");
    });
    $(".list_c").mouseleave(function () {
        $(this).find(".list_delete").css("display","none");
    });

    $(".list_p").mouseover(function () {
        $(this).find(".list_delete").css("display","inline-block");
    });
    $(".list_p").mouseleave(function () {
        $(this).find(".list_delete").css("display","none");
    });

    //弹框遮罩
	$(".mask").css({  "height": $(document).height() });
	$(".add a").click(function(){
		$(".mask").show();
		$(".popup_cat").show();
	});

	$(".set_pwd").click(function(){
		$(".mask").show();
		$(".popup_setpwd").show();
	});
	//上传弹框
	$(".upload a").click(function(){
		$(".mask").show();
		$(".popup_upload").show();
	});

	//退出按钮
	$(".exit").click(function(){
		$(".mask").show();
		$(".popup_prompt p").html("确定退出吗？");
		$(".popup_prompt").show();
	});

	//取消按钮
	$(".btn_cancel").click(function(){
		$(".mask").hide();
		$(".popup_upload").hide();
		$(".popup_cat").hide();
		$(".popup_prompt").hide();
		$(".popup_company").hide();
		$(".popup_setpwd").hide();
	});

	//添加公司弹框
	$(".add_company").click(function(){
		$(".mask").show();
		$(".popup_company").show();
	});

	//添加新目录
	/*
	$(".popup_cat_btn .btn_ok").click(function(){
		alert(222);
		//add_cat();
	});
	*/
	
	

	//删除目录
	$(".list_delete").click(function(){
		var parent=$(this).parent();
		var classname=parent.attr("class");
		if (classname=="list_c") {
			var id=parent.attr("id");
			$(".mask").show();
			$(".popup_prompt p").html("确定删除目录吗？");
			$(".popup_prompt").show();
			$(".btn_delete").click(function(){
				$(".mask").hide();
				$(".popup_prompt").hide();
				$('#'+id+'').next(".list_p").next(".item_list_s").remove();
				$('#'+id+'').next(".list_p").remove();
				$('#'+id+'').remove();
				
				deptId = id.replace("list_c","");
				delDept(deptId);
			});
			
		}
		else if (classname=="list_p"){
			var id=parent.attr("id");
			$(".mask").show();
			$(".popup_prompt p").html("确定删除目录吗？");
			$(".popup_prompt").show();
			$(".btn_delete").click(function(){
				$(".mask").hide();
				$(".popup_prompt").hide();
				$('#'+id+'').next(".item_list_s").remove();
				$('#'+id+'').prev(".list_c").removeClass("show_list");
				$('#'+id+'').remove();
				floorId = id.replace("list_p","");
				delFloor(floorId);
			});
			
		}
		else{
			return false;
		}
		
	});

});
	//添加新目录
	function add_cat(){
		var i=parseInt($("#company").val());
		var count=$("#company option").length;
		var newcat=$("#newcat").val();
		if (newcat=="") {
			alert("请输入新的目录名!");
		}
		else if(i==count){
			var cat_last=$(".item_list_p");
			cat_last.append('<li class="list_p" name="list_'+i+'" id="list_p'+i+'"><i class="ico"></i><i class="p_click"></i>'+newcat+'<span class="list_delete"></span></li>');
			$(".mask").hide();
			$(".popup_cat").hide();
		}
		else{
			var cat_par=$(".list_c").eq(i);
			//console.log(cat_par.index());
			cat_par.before('<li class="list_p" name="list_'+i+'" id="list_p'+i+'"><i class="ico"></i><i class="p_click"></i>'+newcat+'<span class="list_delete"></span></li>');
			$(".mask").hide();
			$(".popup_cat").hide();
		}
	};
	