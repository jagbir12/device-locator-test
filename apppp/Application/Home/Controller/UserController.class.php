<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class UserController extends CommonController {
	public function addDept() {
		$status=1;
		$model = new Model();
		$count = $model->query("select count(1) count from department where del_flag=0 and dept_name = '".$_POST['deptName']."'");
		$model->execute("insert into tmp(col1) values('".$count[0]['count']."')");
		if($count[0]['count']>0) {
			$status=0;
			$msg="The company already exists, please confirm";
		} else {
			$model->execute("insert into department(dept_name) values('".$_POST['deptName']."')");
		}
		$returnData['status']=$status;
		$returnData['msg']=$msg;
		$this->ajaxReturn($returnData,'JSON');
	}
    public function listUser(){
		$userTreeHtml = $this->createUserTree(); 
		$this->assign("userTree",$userTreeHtml);
		$this->display();
    }
	public function readUser() {
		$deptList = $this->getDepartment();
		$this->assign('deptList',$deptList);
		$uid=$_GET['uid'];
		if ($uid == null || $uid == "") {
			$this->assign('addFlag',1);
			$this->display();
		} else {
			$user = M('user');
			$map['uid']=$uid;
			if($info=$user->where($map)->find()){
				$this->assign('info',$info);
				$this->assign('addFlag',0);
				$this->display();
			} else {
				$this->assign('addFlag',1);
				$this->display();
			}
		}
		/*
		$user = M('user');
		$map['uid']=$uid;
        if($info=$user->where($map)->find()){
			$this->assign('info',$info);
			$this->assign('addFlag',0);
			$this->display();
		} else {
			$this->assign('addFlag',1);
			$this->display();
		}
		*/
	}
	
	public function saveUser() {
		$data=null;
		$name = $_POST['name'];
		$truename = $_POST['truename'];
		$deptId = $_POST['deptId'];
		$adminFlag = $_POST['adminFlag'];
		$delFlag = $_POST['delFlag'];
		$model = new Model();
		
		if($_POST['addFlag'] == 1) {
			//insert
			$sql="insert into user (name,truename,pwd,dept_id,admin_flag,del_flag) values('".$name."','".$truename."',md5(123456),'".$deptId."','".$adminFlag."','".$delFlag."')";
			$model->execute($sql);
		} else {
			//update
			$sql="update user set name = '".$name."'
			,truename = '".$truename."'
			,dept_id = '".$deptId."'
			,admin_flag = '".$adminFlag."'
			,del_flag = '".$delFlag."'
			where uid = '".$_POST['uid']."'
			";
			$model->execute($sql);
		}
		$userTreeHtml = $this->createUserTree(); 
		$data["userTree"] = $userTreeHtml;
		$data["status"] = 1;
		$this->ajaxReturn($data,'JSON');
	}
	
	private function createUserTree() {
		$model = new Model();
		$sql = "select * from user where 1=1 ";
		if($_SESSION['dept_id'] != "1") {
			$sql .= " and dept_id= '".$_SESSION['dept_id']."'";
		}
		$userList = $model->query($sql);
		$userTree = "<ul>";
		foreach($userList as $userKey => $userVal) {
			$userTree .='<li class="list_s"><a href="###" onclick="showUser('.$userVal['uid'].')">'.$userVal['truename'].'</a></li>';
		}
		$userTree .= "</ul>";
		return $userTree;
		
	}
	
	private function getDepartment () {
		$model = new Model();
		
		$sql = "select * from department ";
		if($_SESSION['dept_id'] != "1") {
			$sql .= " where dept_id= '".$_SESSION['dept_id']."'";
		}
		
		$deptList = $model->query($sql);
		return $deptList;
	}
}