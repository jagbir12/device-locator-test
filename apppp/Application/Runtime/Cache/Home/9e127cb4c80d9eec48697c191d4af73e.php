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
<script>
$(function(){
	$('#userInfo').ajaxForm({
        success:       saveUserSuccess,
        dataType: 'json'
    });
	jQuery("#deptId").val(<?php echo ($info["dept_id"]); ?>);  
});
function saveUserSuccess(data) {
	if(data.status == 1) {
		window.parent.refreshUserList(data.userTree);
	}
}
</script>
<body style="background-color:#fff;">
<form id="userInfo" method="post" action="/apppp/index.php/Home/User/saveUser">
<input type="hidden" name="addFlag" value="<?php echo ($addFlag); ?>">
<input type="hidden" name="uid" value="<?php echo ($info["uid"]); ?>">
		<div class="user_info">
		
			<p><span>login name:</span><input name="name" type="text" value="<?php echo ($info["name"]); ?>"  <?php if($addFlag == 0): ?>readonly<?php endif; ?> /></p>
			<p><span>Name:</span><input name="truename" type="text" value="<?php echo ($info["truename"]); ?>" /></p>
			<p><span>the company:</span>
					<span class="styled-select">
						<select id="deptId" name="deptId" >
							<?php if(is_array($deptList)): $i = 0; $__LIST__ = $deptList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$deptInfo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($deptInfo["dept_id"]); ?>"><?php echo ($deptInfo["dept_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</span>
			</p>
			<p class="permission">
				<span>Administrator privileges:</span>
				<input type="radio" name="adminFlag" value="1"   <?php if($info["admin_flag"] == 1): ?>checked<?php endif; ?>   />It is
				<input type="radio" name="adminFlag" value="0" <?php if($info["admin_flag"] == 0): ?>checked<?php endif; ?> style="margin-left:37px;" />No
			</p>
			<p class="state">
				<span>Status:</span>
				<input type="radio" name="delFlag" value="0" <?php if($info["del_flag"] == 0): ?>checked<?php endif; ?>  />Enable
				<input type="radio" name="delFlag" value="1" style="margin-left:20px;" <?php if($info["del_flag"] == 1): ?>checked<?php endif; ?> />Disabled
			</p>
			<div class="user_btn">
				<input class="btn_ok" type="submit" value="确定" />
			</div>
			
		</div>
</form>
</body>
</html>