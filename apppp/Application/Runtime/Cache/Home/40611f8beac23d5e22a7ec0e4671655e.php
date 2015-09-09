<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="/apppp/Common/css/public.css" />
	<script src="/apppp/Common/js/jquery/jquery-1.9.0.min.js"></script>
	<script src="/apppp/Common/js/jquery/jquery.js"></script>
	<script src="/apppp/Common/js/jquery/jquery.form.js"></script>
	<script src="/apppp/Common/js/myscript/public.js"></script>
</head>
<script type="text/javascript">
$(function(){
	$(".popup_prompt .btn_delete").click(function(){
		//alert($("#imageUrl").val())
		$(".mask").hide();
		$(".popup_prompt").hide();
		$("#delImage").submit();
		//delImage
	});


	$('#changePassword').ajaxForm({
        success:       changePasswordSuccess,
        dataType: 'json'
    });
	
	function changePasswordSuccess(data){
		$("#newcat1").val("");
		$("#newcat2").val("");
		$("#newcat3").val("");
		if(data.status == 1) {
			$(".mask").hide();
			$(".popup_setpwd").hide();
		} else {
			alert(data.msg);
		}
    }
	
	//修改密码
	$(".popup_setpwd .btn_ok").click(function(){
		if($("#newcat1").val() == "") {
			alert("Please enter your password");
			return;
		}
		if($("#newcat2").val() == "") {
			alert("Please enter a new password");
			return;
		}
		if($("#newcat3").val() == "") {
			alert("Please enter the confirmation a new password");
			return;
		}
		if($("#newcat2").val() != $("#newcat3").val()) {
			alert("2nd passwords do not match , please confirm");
			return;
		}
		$("#changePassword").submit();
		//addFloorForm.submit();
		
	});
	
	
	//添加楼层ajax提交
    $('#addFloor').ajaxForm({
        success:       addFloorSuccess,
        dataType: 'json'
    });
	
	//添加楼层成功
    function addFloorSuccess(data){
		$(".mask").hide();
		$(".popup_cat").hide();
		var tree = document.getElementById("tree");
        tree.innerHTML=data.tree;
		treeBind()
		
		
    }
	//添加楼层
	$(".popup_cat_btn .btn_ok").click(function(){
		var floorNameVal=$("#floorName").val();
		if (floorNameVal=="") {
			alert("Please enter a new directory name !");
			return;
		}
		
		$("#addFloor").submit();
		//addFloorForm.submit();
		
	});
	
	//上传图片
	$(".popup_upload .btn_ok").click(function(){
		var imageNameVal=$("#imageName").val();
		if (imageNameVal=="") {
			alert("Please enter the picture name !");
			return;
		}
		
		var imageVal = $("#image").val();
		if (imageVal=="") {
			alert("Please select the input images!");
			return;
		}
		$("#upload").submit();
		
	});	
	
	
	
	$("#uploadDeptId").change(function(){
		$.post('/apppp/index.php/Home/Image/searchFloor',{'deptId':$('#uploadDeptId').val()},
		function(data){
			$("#floorId ").empty();
			for(var i=0;i<data.floorList.length;i++) {
				//alert(data.floorList[0]['floor_id']);
				var option = "<option value='"+data.floorList[i]['floor_id']+"'>"+data.floorList[i]['floor_name']+"</option>";
				$("#floorId").append(option);
			}
		},'json');
	});
	$("#uploadDeptId").change();
	
});

//绑定树
function treeBind() {
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
}
function delDept(id) {
	$.post('/apppp/index.php/Home/Image/delDept',{'deptId':id},
		function(data){
		},'json');
}
function delFloor(id) {
	$.post('/apppp/index.php/Home/Image/delFloor',{'floorId':id},
		function(data){
		},'json');
}
function showImage(imageId) {
	var url = "<?php echo U('Image/readImage');?>";
	var realUrl = url.replace(/readImage/,"readImage/image_id/"+imageId);
	
	var imageFrame = document.getElementById("imageFrame");
	imageFrame.src=realUrl;
	//opennewwin(realUrl,'show');
}
//删除图片提示框
	function delete_pic(imageId,url){
		$("#imageId").val(imageId)
		$("#imageUrl").val(url)
		$(".mask").show();
		$(".popup_prompt p").html("Are you sure ?");
		$(".popup_prompt").show();
	}

</script>


<body>
	<div class="main">
		<div class="main_left">
			<div class="logo"></div>
			<div id="tree" class="item_list">
				<?php echo ($tree); ?>
			</div>
			
			<div class="add">
				<?php if($_SESSION['admin_flag']== 1): ?><a href="###">Create a directory</a><?php endif; ?>
			</div>
			<div class="upload">
				<?php if($_SESSION['admin_flag']== 1): ?><a href="###">upload image</a><?php endif; ?>
			</div>
		</div>
		<div class="main_right">
			<div class="top">
				<h2></h2>
				<ul class="clearfix">
					<?php if($_SESSION['admin_flag']== 1): ?><li><a href="<?php echo U('User/listUser');?>">User List</a></li>
						<li>|</li><?php endif; ?>
					<li><a class="set_pwd" href="###">Change Password</a></li>
					<li>|</li>
					<li><a class="exit" href="<?php echo U('Public/logout');?>">Log out</a></li>
				</ul>
			</div>
			<iframe  id="imageFrame" src="" width="975" height="685" frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="yes" allowtransparency="yes"></iframe>
			
		</div>
		
		<form id="addFloor" method="post" action="/apppp/index.php/Home/Image/addFloor">
		<div class="mask"></div>
		<div class="popup_cat">
			<div class="popup_cat_tit">Create a directory</div>
			<div class="popup_cat_main">
				<div class="popup_cat_item"><span>Select the company:</span>
					<div class="styled-select">
						<select name="deptId" id="company">
							<?php if(is_array($deptList)): $i = 0; $__LIST__ = $deptList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$deptInfo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($deptInfo["dept_id"]); ?>"><?php echo ($deptInfo["dept_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</div>
				</div>
				<input type="hidden" name="abc" value="222" />
				<div class="popup_cat_item"><span>Directory name :</span><input name="floorName" id="floorName" type="text" /></div>
				<div class="popup_cat_btn">
					<input class="btn_cancel" type="button" value="Cancel" />
					<input class="btn_ok" type="button" value="Ok"" />
				</div>
			</div>
		</div>
		</form>
		
		<form id="upload" name="upload" action="/apppp/index.php/Home/Image/upload" enctype="multipart/form-data" method="post">
		<div class="popup_upload">
			<div class="popup_upload_tit">upload image</div>
			<div class="popup_upload_main">
				<div class="popup_upload_item"><span>Title:</span><input type="text" id="imageName" name="imageName"/></div>
				<div class="popup_upload_item"><span>The company:</span>
					<div class="styled-select">
						<select name="deptId" id="uploadDeptId" >
							<?php if(is_array($deptList)): $i = 0; $__LIST__ = $deptList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$deptInfo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($deptInfo["dept_id"]); ?>"><?php echo ($deptInfo["dept_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</div>
				</div>
				<div class="popup_upload_item"><span>Belongs room :</span>
					<div class="styled-select">
						<select name="floorId" id="floorId">
						</select>
					</div>
				</div>
				<div class="popup_upload_item"><span>Upload pictures:</span><input type="file" name="image" id="image" /></div>
				<div class="popup_upload_btn">
					<input class="btn_cancel" type="button" value="Cancel" />
					<input class="btn_ok" type="button" value="Ok" />
				</div>
			</div>
		</div>
		</form>
		
		<form id="delImage" method="post" action="/apppp/index.php/Home/Image/delImage">
			<input type="hidden" id="imageUrl" name="imageUrl" />
			<input type="hidden" id="imageId" name="imageId" />
		</form>
		
		<div class="popup_prompt">
			<div class="popup_prompt_tit">Confirmation</div>
			<div class="popup_prompt_main">
				<p>xxxxxxxx</p>
				<div class="popup_prompt_btn">
					<input class="btn_cancel" type="button" value="Cancel" />
					<input class="btn_delete" type="button" value="Ok" />
				</div>
			</div>
		</div>

		<form id="changePassword" method="post" action="<?php echo U('Public/changePassword');?>">
		<div class="popup_setpwd">
			<div class="popup_setpwd_tit">Change Password</div>
			<div class="popup_setpwd_main">
				<div class="popup_setpwd_item"><span>Old Password:</span><input id="newcat1" name="oldpwd" type="password" /></div>
				<div class="popup_setpwd_item"><span>New Password:</span><input id="newcat2" name="newpwd1" type="password" /></div>
				<div class="popup_setpwd_item"><span>Confirm the new password:</span><input id="newcat3" name="newpwd2" type="password" /></div>
				<div class="popup_setpwd_btn">
					<input class="btn_cancel" type="button" value="Cancel" />
					<input class="btn_ok" type="button" value="Ok" />
				</div>
			</div>
		</div>
		</form>
	</div>
</body>
</html>