<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;

class PublicController extends Controller {
	public function login(){
		
		if(IS_POST){  
			$user = M('user');
			$map['name'] = $_POST['name'];
			$map['pwd'] = md5($_POST['pwd']);
			$row = $user->where($map)->field('uid,name,truename,admin_flag,dept_id,pwd')->find();
			if(empty($row)){
				$this->assign('msg',"Wrong username or password");
				$this->display();
			}else{
				$_SESSION['uid'] = $row['uid'];
				$_SESSION['name'] = $row['name'];
				$_SESSION['truename'] = $row['truename'];
				$_SESSION['admin_flag'] = $row['admin_flag'];
				$_SESSION['dept_id'] = $row['dept_id'];
				$_SESSION['pwd'] = $row['pwd'];
				
				$this->redirect('Image/listImage');
			}   
		} else {
			$this->display();
        }
    }
	
    //退出登录 ,清除 session
    public function logout(){ 
        if(isset($_SESSION['uid'])) {
            unset($_SESSION['uid']);
			unset($_SESSION['name']);
			unset($_SESSION['truename']);
			unset($_SESSION['admin_flag']);
			unset($_SESSION['dept_id']);
			unset($_SESSION['pwd']);
            session('[destroy]');
			$this->redirect('Public/login');
        }else {
			$this->assign('msg',"已经登出");
            $this->redirect('Public/login');
        }
    }
	//修改密码
	public function changePassword() {
		$status=1;
		$model = new Model();
		
		if(md5($_POST['oldpwd']) != $_SESSION['pwd']){
			$msg="输入密码不对";
			$status=0;
		}
		if($status == 1) {
		//$sql="update user set pwd=".md5($_POST['newpwd1'])." where uid ='".$_SESSION['uid']."'";
			//$model->execute("insert into tmp(col1) values('".$sql."')");
			$model->execute("update user set pwd='".md5($_POST['newpwd1'])."' where uid ='".$_SESSION['uid']."'");
		}
		$returnData['status'] = $status;
		$returnData['msg'] = $msg;
		$this->ajaxReturn($returnData,'JSON');
	}
}