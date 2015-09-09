<?php
namespace Home\Model;
use Think\Model;
class ImageModel extends Model {
    protected $_auto = array (
		array('createtime','time',1,'function')
	)
}