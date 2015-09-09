<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class ImageController extends CommonController {
    public function listImage(){
		//$image = M('image');
		//$this->list = $image->select();
		
		$treeHtml = $this->createTree();
		//die($treeHtml);
		$this->assign('tree',$treeHtml);
		
		//department
		$deptList = $this->getDepartment();
		$this->assign('deptList',$deptList);
		$this->display();
    }
	public function readImage() {
		$id=I('get.image_id');
		if(!$id){$this->_empty($id);}
		$image = M('image');
		$map['image_id']=$id;
        if($info=$image->where($map)->find()){
			$this->assign('info',$info);
			$imageDetail = M('image_detail');
			$mapDetail['image_id']=$id;
			$infoDetail = $imageDetail->where($mapDetail)->select();
			for($i =0;$i<count($infoDetail); $i++ ) {
				$infoDetail[$i]['showid'] = $i+1;
			}
			$this->assign('count',count($infoDetail));
			$this->assign('infoDetail',$infoDetail);
			$this->display();
		} else {
			$this->_empty($id);
		}
	}
	public function addImage() {
		$this->display();
	}
	public function delImage() {
		$imageId = $_POST['imageId'];
		$model = new Model();
		$sql = "select * from image where image_id= '".$imageId."'";
		$image = $model->query($sql);
		$url=str_replace("./","./UPLOADS/",$image[0]['path']).$image[0]['savename'];
		$model->execute("delete from image_detail where image_id= '".$imageId."' ");
		$model->execute("delete from image where image_id= '".$imageId."' ");
		unlink($url);
		
		$this->redirect('Image/listImage');
	}
	public function upload() {
		$config = array(
			'maxSize'    =>    3145728,
			'savePath'   =>    './Public/Upload/Image/',
			'saveName'   =>    array('uniqid',''),
			'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
			'autoSub'    =>    true,
			'subName'    =>    array('date','Ymd'),
		);
		$upload = new \Think\Upload($config);// 实例化上传类
		
		$info = $upload->uploadOne($_FILES['image']);
		
		//$filename=$_FILES['photo']['name'];
		//echo $filename;
		//$filename=iconv("utf-8","gbk",$filename); 

		$returnData = null;
		if(!$info) {// 上传错误提示错误信息
			
		}else{// 上传成功
			
			$image = M('image');
			$data['image_name'] = $_POST['imageName'];
			$data['savename'] = $info['savename'];
			$data['path'] = $info['savepath'];
			$data['dept_id'] = $_POST['deptId'];
			$data['floor_id'] = $_POST['floorId'];
			$image->create($data);
			$image->add();

		}
		$this->redirect('Image/listImage');
	}
	public function saveDetail() {
		$content1=$_POST['content1'];
		$content2=$_POST['content2'];
		$content3=$_POST['content3'];
		$type=$_POST['type'];
		$left=$_POST['left'];
		$top=$_POST['top'];
		$id=$_POST['id'];
		$imageDetail = M('image_detail');
		
		$imageDetail->where('image_id='.$id)->delete();
		$model = new Model();
		
		for($i =0;$i<count($content1); $i++ ) {
			$data['image_id']=$id;
			$data['content1']=$content1[$i];
			$data['content2']=$content2[$i];
			$data['content3']=$content3[$i];
			$data['type']=$type[$i];
			$data['left']=$left[$i];
			$data['top']=$top[$i];
			$imageDetail->create($data);
			$imageDetail->add();
		}
		$returnData['status'] = '1';
		$this->ajaxReturn($returnData,'JSON');
	}
	
	public function addFloor() {
		$deptId = $_POST['deptId'];
		$floorName = $_POST['floorName'];
		$model = new Model();
		$model->execute("insert into floor(floor_name,dept_id) values('".$floorName."','".$deptId."');");
		$treeHtml = $this->createTree();
		$data['tree'] = $treeHtml;
		$this->ajaxReturn($data,'JSON');
	}
	
	public function searchFloor() {
		$deptId = $_POST['deptId'];
		$model = new Model();
		$sql = "select * from floor where del_flag='0' and dept_id = '".$deptId."'";
		$floorList = $model->query($sql);
		$data['floorList'] = $floorList;
		$this->ajaxReturn($data,'JSON');
	}
	
	public function delDept() {
		$deptId = $_POST['deptId'];
		$model = new Model();
		$model->execute("update user set del_flag=1 where dept_id ='".$deptId."'");
		$model->execute("update department set del_flag=1 where dept_id ='".$deptId."'");
		$this->ajaxReturn($data,'JSON');
	}
	
	public function delFloor() {
		$floorId = $_POST['floorId'];
		$model = new Model();
		$model->execute("update floor set del_flag=1 where floor_id ='".$floorId."'");
		$this->ajaxReturn($data,'JSON');
	}
	
	private function createTree() {
		$treeHtml = '<ul class="item_list_p">';
		$model = new Model();
		
		$sql = "select * from department where del_flag=0 ";
		if($_SESSION['dept_id'] != "1") {
			$sql .= " and dept_id= '".$_SESSION['dept_id']."'";
		}
		
		$deptList = $model->query($sql);
		if(is_array($deptList)) {
			foreach($deptList as $deptKey => $deptVal) {
				$treeHtml .='<li class="list_c" name="list_'.$deptVal['dept_id'].'" id="list_c'.$deptVal['dept_id'].'"><i class="c_click"></i>'.$deptVal['dept_name'];
				if($_SESSION['admin_flag'] == "1") {
					$treeHtml .='<span class="list_delete"></span>';
				}
				$treeHtml .='</li>';
				
				
				$sql = "select * from floor where dept_id = '".$deptVal['dept_id']."' and del_flag=0 ";
				$floorList = $model->query($sql);
				if(is_array($floorList)) {
					foreach($floorList as $floorKey => $floorVal) {
						$treeHtml .= '<li class="list_p" name="list_'.$deptVal['dept_id'].'" id="list_p'.$floorVal['floor_id'].'"><i class="ico"></i><i class="p_click"></i>'.$floorVal['floor_name'];
						if($_SESSION['admin_flag'] == "1") {
							$treeHtml .='<span class="list_delete"></span>';
						}
						$treeHtml .='</li>';
						
						$sql = "select * from image where dept_id = '".$deptVal['dept_id']."' and floor_id='".$floorVal['floor_id']."' ";
						$imageList = $model->query($sql);
						if(is_array($imageList)) {
							$treeHtml .= '<ul class="item_list_s">';
							$treeHtml .= '<i class="ico"></i>';
							foreach($imageList as $imageKey => $imageVal) {
								$treeHtml .= '<li class="list_s"><a href="" onclick="showImage('.$imageVal['image_id'].')">'.$imageVal['image_name'].'</a></li>';
							}
							$treeHtml .= '</ul>';
						}
					}
				}
			}
		}
		$treeHtml .= '</ul>';
		return $treeHtml;
	}
	
	private function getDepartment () {
		$model = new Model();
		
		$sql = "select * from department where del_flag='0' ";
		if($_SESSION['dept_id'] != "1") {
			$sql .= " and dept_id= '".$_SESSION['dept_id']."'";
		}
		
		$deptList = $model->query($sql);
		return $deptList;
	}
	
}