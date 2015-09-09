<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
		//echo session('uid')."------".session('name')."------".session('truename');
		$this->display();
		//$this->redirect('/login');
	/*
        $Data = M('user'); // 实例化Data数据模型
        $this->data = $Data->select();
        $this->display();*/
		
    }
}