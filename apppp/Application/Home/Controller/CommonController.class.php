<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
    protected function _initialize(){
		$uid = session('uid');
		if ( $uid == false ) {
			$this->redirect('Public/login');
			
			//$this->error ( 'You are not logged in! Redirecting login page', U ( 'Public/login' ) );
			
		}
	}
	public function _empty($name){
       
        $this->display('Public:empty');
        exit;
    }
}