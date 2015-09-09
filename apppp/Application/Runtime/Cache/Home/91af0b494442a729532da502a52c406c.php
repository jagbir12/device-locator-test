<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="/apppp/Common/css/public.css" />
	<script src="/apppp/Common/js/jquery/jquery-1.8.0.min.js"></script>
	<script src="/apppp/Common/js/jqueryUI/jquery-ui.min.js"></script>
	<script src="/apppp/Common/js/jquery/jquery.form.js"></script>
</head>
<body>
<form id="imageDetail" action="<?php echo U('saveDetail');?>" method="post" >
	<input type="hidden" name="id" value="<?php echo ($info["image_id"]); ?>">
	<input type="hidden" id="count" name="count" value="<?php echo ($count); ?>">
	<div class="right_con">
		<div class="operation">
			<div class="op-search">
               <div class="op-select"><select id="selopt" ><option value="1">Haika No.</option><option value="2">Ext</option></select></div>
               <input type="text" id="selval" class="op-reading" /><input type="button" onclick="search_pic()" value="search for" class="op-button" />
            </div>
			<div class="op-dete">
			<ul class="clearfix">
				<?php if($_SESSION['admin_flag']== 1): ?><li class="save"></li>
				<li><a class="add_pic" href="###"><i></i>Add information points</a></li>
				<li><a class="delete_pic" href="###"><i></i>Remove picture</a></li><?php endif; ?>
			</ul>
			</div>
		</div>
		<div class="con_pic">
			<img src="/apppp/UPLOADS/<?php echo ($info["path"]); echo ($info["savename"]); ?>" alt="" />
			<?php if(is_array($infoDetail)): $i = 0; $__LIST__ = $infoDetail;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><a id="<?php echo ($info["showid"]); ?>" href="###" style="top:<?php echo ($info["top"]); ?>;left:<?php echo ($info["left"]); ?>;" class="<?php if($info["type"] == 0): ?>green_cur<?php endif; if($info["type"] == 1): ?>blue_cur<?php endif; if($info["type"] == 2): ?>red_cur<?php endif; ?>"></a>
				
				<div class="popup" id="popup<?php echo ($info["showid"]); ?>">
					<input id="left_<?php echo ($info["showid"]); ?>" name="left[]" type="hidden" value="<?php echo ($info["left"]); ?>" />
					<input id="top_<?php echo ($info["showid"]); ?>" name="top[]" type="hidden" value="<?php echo ($info["top"]); ?>" />
					<div class="popup_item"><span>With frame numbers:</span><input type="text" name="content1[]" value="<?php echo ($info["content1"]); ?>" <?php if($_SESSION['admin_flag']== 0): ?>readonly<?php endif; ?> /></div>
					<div class="popup_item"><span>Switch ports:</span><input type="text" name="content2[]" value="<?php echo ($info["content2"]); ?>" <?php if($_SESSION['admin_flag']== 0): ?>readonly<?php endif; ?> /></div>
					<div class="popup_item"><span>Ext:</span><input type="text" name="content3[]" value="<?php echo ($info["content3"]); ?>" <?php if($_SESSION['admin_flag']== 0): ?>readonly<?php endif; ?> /></div>
					<div class="popup_item"><span>Information point type:</span>
						<div class="styled-select">
							<select class="news_type" name="type[]" <?php if($_SESSION['admin_flag']== 0): ?>disabled<?php endif; ?> >
								<option <?php if($info["type"] == 0): ?>selected<?php endif; ?> value="0">General information points</option>
								<option <?php if($info["type"] == 1 ): ?>selected<?php endif; ?> value="1">Wireless information points</option>
								<option <?php if($info["type"] == 2): ?>selected<?php endif; ?> value="2">Other information points</option>
							</select>
						</div>
					</div>
					<div class="popup_btn">
						<?php if($_SESSION['admin_flag']== 1): ?><input class="btn_delete" type="button" value="Delete" /><?php endif; ?>
						<input class="btn_ok" type="button" value="Determine" />
					</div>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
	</div>

	<script>
		function search_pic(){
			
			var selopt = $("#selopt").val();
			var selval = $("#selval").val();
			var pjh=null;
			var fjh=null;
			if(selval == "") {
				alert("Please fill in the search for content")
				return;
			}
			if(selopt == 1) {
				//pjh
				pjh = selval;
			} else {
				//fjh
				fjh = selval;
			}
			var popup_btn = (".con_pic a");
			var content1 = document.getElementsByName("content1[]");
			var content3 = document.getElementsByName("content3[]");
			var flag = false
			if(selopt == 1) {
				for (var i=0;i<content1.length ;i++ )//弹框遍历
				{
					if(content1[i].value == pjh) {
						flag = true;
						//var dian = content1[i].parentNode.parentNode.previousSibling
						var div_id=content1[i].parentNode.parentNode.id
						//var btn_id = dian.id;
						var btn_id = div_id.substr(5)
						$(".popup").hide();					
						$(".popup").css({"top":"","left":"","right":""});
						/*
						var top = parseInt(dian.style.top);					
						var left = parseInt(dian.style.left);
						var right = parseInt(dian.style.right);
						*/
						var top = parseInt($("#"+btn_id).css("top").replace("px",""))
						var left = parseInt($("#"+btn_id).css("left").replace("px",""))
						var right
						$(".popup").css({"top":top,"left":left+33,"right":right+33});
						$("#popup"+btn_id).show();
						$("#"+btn_id).removeClass()
						window.scrollTo(left-50,top-50); 
					}
				}
			} else {
				for (var i=0;i<content3.length ;i++ )//弹框遍历
				{
					if(content3[i].value == fjh) {
						flag = true;
						var div_id=content3[i].parentNode.parentNode.id
						
						var btn_id = div_id.substr(5)
						$(".popup").hide();					
						$(".popup").css({"top":"","left":"","right":""});
						var top = parseInt($("#"+btn_id).css("top").replace("px",""))
						var left = parseInt($("#"+btn_id).css("left").replace("px",""))
						var right
						$(".popup").css({"top":top,"left":left+33,"right":right+33});
						$("#popup"+btn_id).show();
						$("#"+btn_id).addClass('');
						window.scrollTo(left-50,top-50); 
					}
				}
			}
			if(flag == false) {
				alert("I did not find the relevant information points");
			}
			
		}
		
		$(".delete_pic").click(function(){
			window.parent.delete_pic("<?php echo ($info["image_id"]); ?>","/apppp/UPLOADS/<?php echo ($info["path"]); echo ($info["savename"]); ?>");
		});

		//var popup_btn=$(".con_pic a");//获取信息点
		//var popup_box=$(".popup");//获取弹框
		//var hide=function()
		//{
			//for (var i=0;i<popup_box.length ;i++ )//弹框遍历
			//{
				//popup_box[i].style.display="none";
			//}
		//}
		//window.onload=function(){
		  //hide();
		  //for(var i = 0; i < popup_btn.length; i++)//信息点遍历
		  //{
		$(function(){
			$(".con_pic a").live("click",function()
			{
				$(".popup").hide();
				var btn_id = $(this).attr("id");
				$(".popup").css({"top":"","left":"","right":""});//清除弹框position值
				var top = $(this).css("top");					
				var left = parseInt($(this).css("left"));
				var right = parseInt($(this).css("right"));		//获取信息点position值
				$(".popup").css({"top":top,"left":left+33,"right":right+33});//position值赋值给弹框
				//$(".popup").show();
				//$(this).addClass('cur').siblings().removeClass('cur');
				//oEvent = oEvent || event;hide();
				$("#popup"+btn_id).show();
			});
			
			
			//添加信息点
			$(".add_pic").click(function(){
				var default_top = "0px";
				var default_left = "0px";
				var maxid = parseInt($("#count").val())+1;
				$("#count").val(maxid);
				/*
				var newbtn = "<a class='green_cur' id='"+maxid+"' href='###' style='top:"+default_top+";left:"+default_left+";'></a>"+'<input id="left_'+maxid+'" name="left[]" type="hidden" value="'+default_left+'" /><input id="top_'+maxid+'" name="top[]" type="hidden" value="'+default_top+'" />';
				var newdiv = "<div id='popup"+maxid+"' class='popup'><div class='popup_item'><span>配架号：</span><input type='text' name='content1[]' /></div><div class='popup_item' class='popup_item'><span>交换机端口：</span><input type='text' name='content2[]' /></div><div class='popup_item'><span>分机号：</span><input type='text' name='content3[]' /></div><div class='popup_item'><span>信息点类型：</span><div class='styled-select'><select class='news_type' name='type[]'><option value='0'>一般信息点</option><option value='1'>无线信息点</option><option value='2'>其他信息点</option></select></div></div><div class='popup_btn'><input class='btn_delete' type='button' value='删除' /><input class='btn_ok' type='button' value='确定' /></div></div>";
				*/
				var newbtn = "<a class='green_cur' id='"+maxid+"' href='###' style='top:"+default_top+";left:"+default_left+";'></a>";
				var newdiv = "<div id='popup"+maxid+"' class='popup'>"+'<input id="left_'+maxid+'" name="left[]" type="hidden" value="'+default_left+'" /><input id="top_'+maxid+'" name="top[]" type="hidden" value="'+default_top+'" />'+"<div class='popup_item'><span>配架号：</span><input type='text' name='content1[]' /></div><div class='popup_item' class='popup_item'><span>交换机端口：</span><input type='text' name='content2[]' /></div><div class='popup_item'><span>分机号：</span><input type='text' name='content3[]' /></div><div class='popup_item'><span>信息点类型：</span><div class='styled-select'><select class='news_type' name='type[]'><option value='0'>一般信息点</option><option value='1'>无线信息点</option><option value='2'>其他信息点</option></select></div></div><div class='popup_btn'><input class='btn_delete' type='button' value='删除' /><input class='btn_ok' type='button' value='确定' /></div></div>";
				//var id_num = parseInt($(".con_pic a").length)+1;
				//var index = id_num-1;
				$(".con_pic").append(newbtn);
				//$(".con_pic a").eq(index).attr("id",id_num);
				$(".con_pic").append(newdiv);
				//$(".popup").eq(index).attr("id","popup"+id_num);
				move();
			});
			<?php if($_SESSION['admin_flag']== 1): ?>move();<?php endif; ?>
			
			//添加楼层ajax提交
			$('#imageDetail').ajaxForm({
				success:       saveImageSuccess,
				dataType: 'json'
			});
			
			//添加楼层成功
			function saveImageSuccess(data){
				alert('保存成功');
			}
			
			//保存
			$(".save").click(function(){
				$("#imageDetail").submit();
			});
			
		});

		function move() {
			$( ".con_pic a" ).draggable(
				{ stop: function(event, ui){
					var id=ui.helper.attr('id');
					$("#left_"+id).val(ui.helper.css("left"));
					$("#top_"+id).val(ui.helper.css("top"));
				} 	
			}); 
		}
		
		//信息点类型
		$(".popup_btn .btn_ok").live("click",function(){
			var color = parseInt($(this).parents(".popup").find(".news_type").val());
			var news_id = $(this).parents(".popup").attr("id").substr(5);
			$("#"+news_id).removeClass();
			if (color == 1) {
				$("#"+news_id).addClass('blue_cur');
			}
			else if (color == 2) {
				$("#"+news_id).addClass('red_cur');
			}
			else
				$("#"+news_id).addClass('green_cur');
			$(".popup").hide();
		});

		//删除信息点
		$(".popup_btn .btn_delete").live("click",function(){
			
			var news_id = $(this).parents(".popup").attr("id").substr(5);
			var news_box = $(this).parents(".popup");
			news_box.remove();
			$("#"+news_id).remove();
		});
	</script>
</form>
</body>
</html>